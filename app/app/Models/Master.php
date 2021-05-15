<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master extends Model 
{

    protected $table = 'masters';
    public $timestamps = true;

    public function feedbacks()
    {
        return $this->hasMany('Feedback', 'master');
    }

    public function requests()
    {
        return $this->hasMany('Request', 'master');
    }

}