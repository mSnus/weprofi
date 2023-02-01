<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFeedback;
use App\Models\Userinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

include_once(base_path().'/app/helpers.php');

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

        return view('pages.master_page', [
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
			$user->phone  = parsePhone($request->phone);

			$user->location = $request->location;
			$user->usertype = ($request->usertype == User::typeMaster) ? User::typeMaster : User::typeClient;
            
            $request->region = $request->region ?? ['_israel'];
            $request->language = $request->language ?? ['ru'];

            $user->avatar = intval(trim($request->avatar)) ?? 0;

            if (isset($request->password) && trim($request->password) != '') {
                $user->password = trim($request->password);
            }

			if ($request->usertype == User::typeMaster) {
				$user->language = join(',', $request->language);
				$user->region = in_array('_israel', $request->region) ? '_israel' : join(',', $request->region);

                DB::table('user_spec')->where('user_id', '=', $user->id)->delete();

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
                
                // $subspecs = '0';
                // if (isset($request->subspec1) && is_array($request->subspec1) && !in_array(0, $request->subspec1)) {
                //     $subspecs = join(',', $request->subspec1);
                // } else {
                //     $subspecs = intval($request->subspec1 ?? '0') ;
                // }

                // $user->spec_id = intval($request->spec1 ?? 0);
                // $user->subspec_id = $subspecs ;

                $user->content = trim($request->content) ?? '';
                $user->tagline = trim($request->tagline) ?? '';
                $user->pricelist = trim($request->pricelist) ?? '';
                $user->timetable = trim($request->timetable) ?? '';

                $user->phone2  = parsePhone($request->phone2);

                $user->is_whatsapp = (isset($request->is_whatsapp) && ($request->is_whatsapp == 1)) ? 1 : 0;
                $user->is_telegram = (isset($request->is_telegram) && ($request->is_telegram == 1)) ? 1 : 0;
                $user->is_whatsapp2 = (isset($request->is_whatsapp2) && ($request->is_whatsapp2 == 1)) ? 1 : 0;
                $user->is_telegram2 = (isset($request->is_telegram2) && ($request->is_telegram2 == 1)) ? 1 : 0;
                $user->is_show_map = (isset($request->is_show_map) && ($request->is_show_map == 1)) ? 1 : 0;
                // $master->save();
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

    function removeImage(Request $request){
        $image = DB::table('images')->where('type', '=', 2)->where('parent_id', '=', 51)->where('id', '=', $request->id);

        if ($image) {
            unlink(public_path().$image->get()->first()->path);
            $image->delete();
            return response('ok', 200);
        } else {
            return response('error: image not found', 201);
        }       
    }

    function getGallery(Request $request){
        $images = DB::table('images')
            ->where('type', '=', User::imageGallery)
            ->where('parent_id', '=', Auth::id())
            ->get()
            ->all();

        return response()->json($images);       
    }

    function getAvatar(Request $request){
        $images = DB::table('images')
            ->where('type', '=', User::imageAvatar)
            ->where('parent_id', '=', Auth::id())
            ->get()
            ->all();

        return response()->json($images);       
    }

    function uploadGallery(Request $request){
	    $image_ids = [];
        $subpath = "/img/gallery";

        $files_count = 0;
        
        if ($request->hasFile('files')) {

            $files = $request->file('files');

            foreach ($files as $file) {
                $files_count++;
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

        return response()->json('file count: '.$files_count);
    }

    private function recalculateRating($user_id){
        $user = User::find($user_id);

        $new_rating = DB::table('user_feedback')
            ->selectRaw('avg(value) as rating, count(value) as rating_count')
            ->where('target_id', '=', $user_id)
            ->get()
            ->first();

        $user->rating = round($new_rating->rating);
        $user->rating_count = round($new_rating->rating_count);
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
