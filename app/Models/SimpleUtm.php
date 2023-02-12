<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleUtm extends Model
{
    use HasFactory;

    protected $table = 'simple_utm';

    protected $fillable = [
        'source_id',
        'target_id',
        'view_count'
    ];
}
