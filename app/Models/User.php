<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;



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
        'language',
        'tagline',
        'content',
        'rating',
        'pricelist',
        'location',
        'region',

        'spec_id',
        'subspec_id',

        'avatar'
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

	public function offers()
	{
		switch ($this->usertype) {
			case SELF::typeClient:
				return \App\Models\Offer::where('client', $this->id)->get();

			case SELF::typeMaster:
				return $this->user_role->counteroffers($this->id);

			default:
				throw new \Exception("No offers for usertype ".$this->user_role." exists", 1);
		}
	}

	public function getUserRoleAttribute(){
		switch ($this->usertype) {
			case SELF::typeClient:
				return $this->client();

			case SELF::typeMaster:
				return  $this->master();

			case SELF::typeModerator:
				return  $this->moderator();

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

	public static function getData($user_id)
    {
        $user = null;
        $gallery = null;
        $skills = null;
        $skills_list = "";        

        if ($user_id) {
            $user_id = intval($user_id);
            $user = DB::table('users')
                ->select('users.name', 'users.phone', 'users.id as user_id', 'users.location', 'users.region', 'users.id', 'users.usertype', 'users.rating',
                        'images.path as avatar', 'users.created_at', 
                        'users.tagline', 'users.content', 'users.pricelist')
                ->leftJoin('images', function($join) {
                             $join->on('images.parent_id', '=', 'users.id');
                             $join->on('images.type', '=', DB::raw("1"));
                         })
                ->where('users.id', $user_id)
                ->first();

			$user->content_raw = $user->content;
            $user->content = nl2br($user->content);
            
			
            $pricelist = array_filter(preg_split('~[\r\n]~', $user->pricelist));

            foreach ($pricelist as $key => $line) {
                $pricelist[$key] = preg_replace(
                    '~^(.*)(\.{4}|_{2})(\d+)\s?sh([^\r\n\t]*)$~Uims', 
                    '<div class="price-block">
                        <div class="price-text">$1</div>
                        <div class="price-value">$3&nbsp;&#8362 <span class="price-extra">$4</span></div>                        
                    </div>', 
                    $pricelist[$key]);                
            }

			$user->pricelist_raw = $user->pricelist;

            $user->pricelist = join("\n", $pricelist);

            $user->join_date = date("d-m-Y", strtotime($user->created_at));

            $gallery = DB::table('users')
                ->select('users.id as user_id', 'images.id as image_id', 'images.path as src')
                ->leftJoin('images', function($join) {
                             $join->on('images.parent_id', '=', 'users.id');
                             $join->on('images.type', '=', DB::raw("2"));
                         })
                ->where('users.id', $user_id)
                ->whereNotNull('path')
                ->get();

            $skills = DB::table('users')
                ->select('users.id as user_id', 'specs.title as spec_title', 'subspecs.title as subspec_title')
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
                $skills_list .= $skill->spec_title . ($skill->subspec_title ? ' ('.$skill->subspec_title.')' : '').', ';
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
}
