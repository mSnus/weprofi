<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserViews extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_id',
        'target_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'source_id' => 'integer',
        'target_id' => 'integer',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function target()
    {
        return $this->belongsTo(Target::class);
    }
}
