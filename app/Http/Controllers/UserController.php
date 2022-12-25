<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFeedback;
use App\Models\Userinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function index($id)
    {
        $data = User::getData($id);

        $feedback = UserFeedback::getFeedbackFromUser(Auth::id(), $id) ?? (object) ['value'=>5, 'content'=>''];

        if (!isset($feedback->value)) $feedback->value = 5;
        if (!isset($feedback->content)) $feedback->content = '';

        return view('user_page', [
            'user_id' => $data['user_id'],
            'user' => $data['user'],
            'gallery' => $data['gallery'],
            'skills' => $data['skills'],
            'feedback' => $feedback]);
    }


/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{

		// dd($request->all());
			$user = User::findOrFail($id);

			$user->name = $request->name;
			$user->phone = $request->phone;
			$user->location = $request->location;
			$user->usertype = ($request->usertype == User::typeMaster) ? User::typeMaster : User::typeClient;
            
            $request->region = $request->region ?? ['_israel'];
            $request->language = $request->language ?? ['ru'];

			if ($request->usertype == User::typeMaster) {
				$user->language = join(',', $request->language);
				$user->region = in_array('_israel', $request->region) ? '_israel' : join(',', $request->region);

                DB::table('user_spec')->where('user_id', '=', $user->id)->delete();

                // foreach();
                if (isset($request->subspec1) && is_array($request->subspec1) && !in_array(0, $request->subspec1)) {
                    foreach ($request->subspec1 as $subspec) {
                        $spec_data[] = [
                            'user_id' => $user->id,
                            'spec_id' => $request->spec1,
                            'subspec_id' => $subspec
                        ];
                    }
                } else {
                    $spec_data = [
                        'user_id' => $user->id,
                        'spec_id' => $request->spec1,
                        'subspec_id' => 0
                    ];
                }

                DB::table('user_spec')->insert($spec_data);

                $master = Userinfo::where('user_id', $id)->first();

                if ($master === null) {
                
                    $master = new Userinfo(['user_id' => $id]);
                    $master->user_id = $id;
                }

                $master->content = trim($request->content) ?? '';
                $master->tagline = trim($request->tagline) ?? '';
                $master->pricelist = trim($request->pricelist) ?? '';
                $master->save();
			}

			$user->save();


			return redirect('/profile')->with('status', 'Профиль сохранён');
	}

    function uploadAvatar(Request $request){
	    $image_ids = [];
        $subpath = "/img/avatars";

        $files_count = count($request->file('files'));
        if ($files_count > 0) {
            $file = $request->file('files')[0];

            $name = $file->getClientOriginalName();
            $image_ext = $file->getClientOriginalExtension();

            $filename = 'myimage_' . md5(date("Y-m-d_H:i:s_u") . rand(100, 999) . Auth::id()) . '.' . $image_ext;
            $path = public_path() . $subpath;
            $storedAs = $file->move($path, $filename);

            DB::table('images')->where('type', '=', User::imageAvatar)->where('parent_id', '=', Auth::id())->delete();

            DB::table('images')->insert([
                'path' => $subpath.'/'.$filename,
                'thumb' => $subpath.'/'.$filename,
                'type' => User::imageAvatar,//avatar
                'parent_id' => Auth::id(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

        }

        return redirect('/profile');
    }

    function uploadGallery(Request $request){
	    $image_ids = [];
        $subpath = "/img/gallery";

        $files_count = count($request->file('files'));

        Log::error($files_count);
        
        if ($files_count > 0) {

            DB::table('images')->where('type', '=', User::imageGallery)->where('parent_id', '=', Auth::id())->delete();

            for ($i = 0; $i < $files_count; $i++) {
                $file = $request->file('files')[$i];

                $name = $file->getClientOriginalName();
                $image_ext = $file->getClientOriginalExtension();

                $filename = 'myimage_' . md5(date("Y-m-d_H:i:s_u") . rand(100, 999) . Auth::id()) . '.' . $image_ext;
                $path = public_path() . $subpath;
                $storedAs = $file->move($path, $filename);    

                DB::table('images')->insert([
                    'path' => $subpath.'/'.$filename,
                    'thumb' => $subpath.'/'.$filename,
                    'type' => User::imageGallery,
                    'parent_id' => Auth::id(),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }


        }

        return redirect('/profile');
    }

    private function recalculateRating($user_id){
        $user = User::find($user_id);

        $new_rating = DB::table('user_feedback')
            ->selectRaw('avg(value) as rating')
            ->where('target_id', '=', $user_id)
            ->get()
            ->first();

        $user->rating = round($new_rating->rating);
        $user->update();
    }

    public function sendFeedback(Request $request, $target_id){
        $source_id = Auth::id();

        if ($source_id != $target_id) {
            $content = trim($request->feedback_text ?? '');
            $value = min(max($request->feedback_rating ?? 5, 1), 5);

            DB::table('user_feedback')
                ->updateOrInsert(
                [
                    'source_id' => $source_id, 
                    'target_id' => $target_id
                ],
                [
                    'content' => $content, 
                    'value' => $value,
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );

            $this->recalculateRating($target_id);
        }
        return redirect('/user/'.$target_id);
    }
}
