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
}
