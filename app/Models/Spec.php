<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spec extends Model
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
        'icon',
        'synonims',
        'ordering',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function subspecs()
    {
        return $this->hasMany(Subspec::class);
    }

    public function users()
    {
        // $users = User::where('')
        return $this->belongsToMany(User::class, 'user_spec')->distinct();
    }

    // public function list(){
    //     return $this->all()->orderBy('spec.title', 'ASC')->orderBy('spec.ordering', 'ASC');
    // }
}
