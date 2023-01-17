<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Subspec extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'synonims',
        'ordering',
        'spec_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'spec_id' => 'integer',
    ];

    public function specs()
    {
        return $this->belongsToMany(Spec::class);
    }

    public function spec()
    {
        return $this->belongsTo(Spec::class);
    }

    public function specName()
    {
        return Spec::where('id', $this->spec_id)->firstOrFail()->title;
    }


    public function users()
    {
        // $users = User::where('')
        return $this->belongsToMany(User::class, 'user_spec')->distinct();
    }    
}
