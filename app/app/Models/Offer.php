<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $fillable = [
        'title',
        'descr',
        'price',
        'client',
        'master',
        'status',
        'location',
        'accepted',
        'finished',

    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'accepted',
        'finished',

    ];

    protected $appends = ['resource_url'];

	 public const statusPending = 'pending';

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/offers/'.$this->getKey());
    }
}
