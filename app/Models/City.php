<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    public const DEFAULT_REGION = 'acre'; //_israel
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
        $cities = City::orderBy('ordering')->orderBy('slug')->get()->all();//orderBy('macroregion')->

        $default_slug = ($default_slug == '') ? self::DEFAULT_REGION : $default_slug;

        $region_options = [];
        foreach ($cities as $city) {
            $default = ($city->slug == $default_slug);
            
            $region_options[] = (object) [
                'value' => $city->slug,
                'slug' => $city->slug,
                'title' => $city->title,
                'region' =>  $city->macroregion,
                'default' => $default,
            ];
        }

        return $region_options;
    }
}
