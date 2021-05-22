<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'clients';
	 protected $fillable = ['username',	 'pass',	 'email',	 'name',	 'phone'];
    public $timestamps = true;

	 public const statusRegistered = 'registered';

    public function feedbacks()
    {
        return $this->hasMany('Feedback', 'client');
    }

    public function offers()
    {
        return $this->hasMany('Offer', 'client');
    }

}