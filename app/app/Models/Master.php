<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{

    protected $table = 'masters';
    public $timestamps = true;

	 public const statusRegistered = 'registered';

    public function feedbacks()
    {
        return $this->hasMany('Feedback', 'master');
    }

    public function requests()
    {
        return $this->hasMany('Request', 'master');
    }

}