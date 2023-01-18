<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Macroregion extends Model
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
        'slug',
        'macroregion'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public static function getOptions($default_slug = ''){
        $regions = Macroregion::orderBy('title')->get()->all();

        $region_options = [];
        foreach ($regions as $city) {
            $default = ($city->slug == $default_slug);
            
            $region_options[] = (object) [
                'value' => $city->slug,
                'title' => $city->title,
                'region' =>  $city->macroregion,
                'default' => $default,
            ];
        }

        return $region_options;
    }
}
