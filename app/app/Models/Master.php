<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $fillable = [
        'userid',
        'title',
        'descr',
        'location',
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

    public function getResourceUrlAttribute()
    {
        return url('/admin/masters/'.$this->getKey());
    }

	 public function feedbacks()
    {
        return $this->hasMany('Feedback', 'master');
    }

	 public function counteroffers()
    {
		return $this->belongsToMany(Offer::class, 'offer_to_masters', 'master', 'offer', 'userid', 'offers.id');
    }
}
