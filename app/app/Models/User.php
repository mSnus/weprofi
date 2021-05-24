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
		switch ($this->usertype) {
			case SELF::typeClient:
				return $this->client->title;

			case SELF::typeMaster:
				return  $this->master->title;

			default:
				return "(тип $this->usertype) " . $this->name;
		}
	}

	public function offers()
	{
		switch ($this->usertype) {
			case SELF::typeClient:
				return $this->client->offers;

			case SELF::typeMaster:
				return  $this->master->offers;

			default:
				throw new \Exception('This user type ($this->usertype) could not have any offers.');
		}
	}

	public function master()
	{
		return $this->hasOne('App\Models\Master', 'userid');
	}

	public function client()
	{
		return $this->hasOne('App\Models\Client', 'userid');
	}
}
