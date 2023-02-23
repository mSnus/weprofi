<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

include_once(base_path().'/app/helpers.php');



/**
 * Добавил свойство usertype:
 *
 * ALTER TABLE `users`
 * ADD `usertype` int(11) unsigned NOT NULL DEFAULT '0' AFTER `id`;
 */

class User extends Authenticatable
{
	use \Backpack\CRUD\app\Models\Traits\CrudTrait;
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'phone',
		'password',
		'usertype',

		'phone2',
    'phone_raw',
    'language',
    'tagline',
    'content',
    'rating',
    'pricelist',
    'location',
    'region',
		'timetable',

		'is_show_map',
		'is_whatsapp',
		'is_whatsapp2',
		'is_telegram',
		'is_telegram2',

		'status',
		'invite_token',

    'spec_id',
    'subspec_id',

    'avatar',

	];

	/**
	 * The user types. Just some random numbers, no meaning intended.
	 */
	public const typeClient = '11';
	public const typeMaster = '22';
	public const typeModerator = '55';
	public const typeAdmin = '999';

	public const imageAvatar = 1;
	public const imageGallery = 2;


	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];


	public function title()
	{
		return $this->user_role->title;
	}

	public function setPasswordAttribute($value) {
		$this->attributes['password'] = Hash::make($value);
	}

	public function getUserRoleAttribute(){
		switch ($this->usertype) {
			case SELF::typeClient:
				return $this->client();

			case SELF::typeMaster:
				return  $this->master();

			case SELF::typeModerator:
				return  $this->moderator();

			case SELF::typeAdmin:
				return  $this->admin();

			default:
				abort(403, 'ERROR: user "'.$this->name.'" with role of type "'.$this->usertype.'" not implemented.');
		}
	}

	public function getUserRoleStringAttribute(){
		switch ($this->usertype) {
			case SELF::typeClient:
				return 'client';

			case SELF::typeMaster:
				return 'master';

			case SELF::typeModerator:
				return 'moderator';

				case SELF::typeAdmin:
					return 'admin';

			default:
				abort(403, 'ERROR: user "'.$this->name.'" with role of type "'.$this->usertype.'" not implemented.');
		}
	}


	public function isModerator()
	{
		return ($this->usertype == SELF::typeModerator);
	}

	public function isMaster()
	{
		return ($this->usertype == SELF::typeMaster);
	}

	public function isClient()
	{
		return ($this->usertype == SELF::typeClient);
	}

	public function moderator()
	{
		return Moderator::where('userid', $this->id)->first();
	}

	public function admin()
	{
		return Moderator::where('userid', $this->id)->first();
	}

	public function master()
	{
		return Master::where('userid', $this->id)->first();
	}

	public function client()
	{
		return Client::where('userid', $this->id)->first();
	}

	public function specs()
	{
		$specs = DB::table('user_spec')
					->select('spec_id')
					->where('user_id', $this->id)
					->distinct()
					->get()
					->toArray();

		$arrSpecs = array_map(function($el) {return $el->spec_id;}, $specs);
		// $arrSpecs = explode(',', $this->spec_id);
		return $arrSpecs;

	}

	public function subspecs($spec_id = 0)
	{
		$subspecs = DB::table('user_spec')
					->select('spec_id','subspec_id')
					->where('user_id', $this->id)
					->when($spec_id > 0, function ($q) use ($spec_id) {
						return $q->where(function ($query) use ($spec_id){
							$query->where('spec_id', '=', $spec_id);
						}
						);
					})
					->get()
					->toArray();
		$arrSubspecs = [];

		foreach ($subspecs as $subspec) {
			$arrSubspecs[$subspec->spec_id][] = $subspec->subspec_id;
		}
		// dd($arrSubspecs);
		// array_map(function($el) {return ['spec_id' => $el->spec_id, 'subspec_id'=> $el->subspec_id];}, $subspecs);

		return $arrSubspecs;
	}

	/**
     * Get the user's type.
     *
     * @param  string  $value
     * @return string
     */
    public function getUsertypeAttribute($value)
    {
		// $usertype = SELF::with('users.usertype')->get();
        return $value;
    }


	public static function formatPricelist($pricelistRaw){
		$pricelist = strip_tags($pricelistRaw);


		$pricelistArr = array_filter(preg_split('~[\r\n]~', $pricelist));

		foreach ($pricelistArr as $key => $line) {
			$pricelistArr[$key] = preg_replace(
				'~^(.*)(\.{4}|_{2})(\d+)\s?(sh|₪)([^\r\n\t]*)$~Uims',
				'<div class="price-block">
					<div class="price-text">$1</div>
					<div class="price-value">$3&nbsp;&#8362 <span class="price-extra">$5</span></div>
				</div>',
				$pricelistArr[$key]);
		}

		$pricelist = join("\n", $pricelistArr);


		return $pricelist;
	}


	public static function formatTimetable($timetableRaw){
		$timetable = strip_tags($timetableRaw);


		$timetableArr = array_filter(preg_split('~[\r\n]~', $timetable));

		foreach ($timetableArr as $key => $line) {
			$timetableArr[$key] = preg_replace(
				'~^(.*)(\.{4}|_{2})([^\r\n\t]*)$~Uims',
				'<div class="timetable-block">
					<div class="timetable-text">$1</div>
					<div class="timetable-value">$3</div>
				</div>',
				$timetableArr[$key]);
		}

		$timetable = join("\n", $timetableArr);


		return ($timetable);
	}

	public static function getData($user_id)
    {
        $user = null;
        $gallery = null;
        $skills = null;
        $skills_list = "";

        if ($user_id) {
            $user_id = intval($user_id);
            $user = DB::table('users')
                ->select('users.name', 'users.phone', 'users.phone2', 'users.id as user_id',
						'users.location', 'users.region', 'users.id', 'users.usertype',
						'users.rating', 'users.rating_count', 'users.tagline',
						'is_show_map', 'is_whatsapp', 'is_whatsapp2', 'is_telegram', 'is_telegram2',
                        'images.path as avatar', 'users.created_at',
                        'users.tagline', 'users.content', 'users.pricelist', 'users.timetable')
                ->leftJoin('images', function($join) {
                             $join->on('images.parent_id', '=', 'users.id');
                             $join->on('images.type', '=', DB::raw("1"));
                         })
                ->where('users.id', $user_id)
                ->first();

               if (!$user) return [
                  'user_id' => $user_id,
                  'user' => "Пользователь с ID {$user_id} не найден",
                  'gallery' => [],
                  'skills' =>[]
              ];

			$user->content_raw = strip_tags($user->content);
            $user->content = processText(strip_tags($user->content));

			// $user->timetable = processText(strip_tags($user->timetable));
			$user->timetable_raw = $user->timetable;
			$user->timetable = self::formatTimetable($user->timetable);

			$user->pricelist_raw = $user->pricelist;
            $user->pricelist = self::formatPricelist($user->pricelist);



            $user->join_date = date("d-m-Y", strtotime($user->created_at));

            $gallery = DB::table('users')
                ->select('users.id as user_id', 'images.id as image_id', 'images.path as src', 'images.thumb')
                ->leftJoin('images', function($join) {
                             $join->on('images.parent_id', '=', 'users.id');
                             $join->on('images.type', '=', DB::raw("2"));
                         })
                ->where('users.id', $user_id)
                ->whereNotNull('path')
                ->get();

            $skills = DB::table('users')
                ->select('users.id as user_id',
				'specs.title as spec_title',
				'subspecs.title as subspec_title',
				'user_spec.spec_id',
				'user_spec.subspec_id'
				)
                ->leftJoin('user_spec', function($join) {
                             $join->on('user_spec.user_id', '=', 'users.id');
                         })
                ->leftJoin('specs', function($join) {
                            $join->on('user_spec.spec_id', '=', 'specs.id');
                        })
                ->leftJoin('subspecs', function($join) {
                            $join->on('user_spec.subspec_id', '=', 'subspecs.id');
                        })
                ->where('users.id', $user_id)
                ->get();

            foreach ($skills as $skill) {
                $skills_list .= "<a href='/spec/".$skill->spec_id."/".$skill->subspec_id."/'>".
					$skill->spec_title . ($skill->subspec_title ? ' ('.$skill->subspec_title.')' : '').
					'</a>, ';
            }

            $skills_list = mb_substr($skills_list, 0, mb_strlen($skills_list) - 2);
        }

        return [
            'user_id' => $user_id,
            'user' => $user,
            'gallery' => $gallery,
            'skills' => $skills_list
        ];
    }

	public function getUserOwnProfileViews(){
		$views = \App\Models\UserStats::select('own_profile_visits')->where('user_id', $this->id)->get()->first();
		return $views->own_profile_visits ?? 0;
	}

  public function getUserInviteLink(){
		return '<a href="'.url('https://weprofi.co.il/invite/'.$this->id.'/'.$this->invite_token).'" target="_blank">link</a>';
		// return '<b a="b">/invite'.$this->id.'/'.$this->invite_token.'/</b>';
	}

	public function getUserViews(){
		$views = \App\Models\UserViews::selectRaw('sum(view_count) as view_count')->where('target_id', $this->id)->groupBy('target_id')->get()->first();
		return $views->view_count ?? 0;
	}
	public function getUserViewsBy($viewer_id){
		$views = \App\Models\UserViews::selectRaw('sum(view_count) as view_count')
			->where('target_id', $this->id)
			->where('source_id', $viewer_id)
			->groupBy('target_id')
			->get()
			->first();
		return $views->view_count ?? 0;
	}
}
