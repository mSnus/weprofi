<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



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
		'email',
		'password',
		'usertype',
	];

	/**
	 * The user types. Just some random numbers, no meaning intended.
	 */
	public const typeClient = '11';
	public const typeMaster = '22';
	public const typeModerator = '55';
	public const typeAdmin = '999';


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

	/**
     * Get the user's type.
     *
     * @param  string  $value
     * @return string
     */
    public function getUsertypeAttribute($value)
    {
		// $usertype = SELF::with('user.usertype')->get();
        return $value;
    }
}
