<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model 
{

    protected $table = 'clients';
    public $timestamps = true;

    public function feedbacks()
    {
        return $this->hasMany('Feedback', 'client');
    }

    public function requests()
    {
        return $this->hasMany('Request', 'client');
    }

}