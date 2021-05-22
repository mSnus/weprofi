<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
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

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/offers/'.$this->getKey());
    }
}
