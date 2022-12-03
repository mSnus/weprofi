<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;

class Client extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $fillable = [
        'userid',
        'title',
        'status',
        'score',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

	 public const statusRegistered = 'registered';

    /* ************************ ACCESSOR ************************* */

    public function feedbacks()
    {
        return $this->hasMany('Feedback', 'client');
    }

    public function getResourceUrlAttribute()
    {
        return url('/admin/clients/'.$this->getKey());
    }

	 public function offers()
    {
        return $this->hasMany('App\Models\Offer', 'client');
    }
}
