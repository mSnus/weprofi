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
	 private $allMasters = null;

	 public const statusPending = 'pending';

    public static function boot()
    {
        parent::boot();

        self::deleting(function($offer)
        {
				$counterOffers = \App\Models\OfferToMaster::where('offer', $offer->id)->get();
            foreach ($counterOffers as $counterOffer) {
                $counterOffer->delete();
            }
        });
    }

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/offers/'.$this->getKey());
    }

	 public function getOwnerTitleAttribute(){
		 $client = \App\Models\Client::where('userid', $this->client)->value('title');
		return $client;
	 }

/* 	 public static function listAll(){
		$offers = \App\Models\Offer::query()->
		join('offer_to_masters', 'offer_to_masters.offer', '=', 'offers.id')->
		// join('masters', 'masters.userid', '=', 'offer_to_masters.master')->
		get();


	  return $offers;
	}
 */
/* 	public function master($master_id){
		$this->hasManyThrough(Master::class, OfferToMaster::class, 'offer', 'userid', 'id', 'masters.userid')->where('masters.userid', '=', $master_id);
	}
 */

	public function masters(){
		return $this->belongsToMany(Master::class, 'offer_to_masters', 'offer', 'master', 'id', 'masters.userid');
	}

	/**
	 * Сохраняет выбор клиента
	 *
	 * @return Response
	 */
	public function storeAcception($offer_id, $master_id)
	{
			$offer = Offer::find($offer_id);
			$offer->master = $master_id;
			$offer->status = "accepted";
			$offer->update();
	}

}
