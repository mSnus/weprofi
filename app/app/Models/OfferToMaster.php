<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OfferToMaster extends Model
{
	use \Backpack\CRUD\app\Models\Traits\CrudTrait;
	protected $fillable = [
		 'offer',
		 'master',
	];

	protected $dates = [
		 'created_at',
		 'updated_at',
	];

	/**
	 * Сохраняет отклик мастера
	 *
	 * @return Response
	 */
	public function storeSuggestion($offer_id)
	{
			$o2m = new OfferToMaster;
			$o2m->master = Auth::user()->user_role->userid;
			$o2m->offer = $offer_id;
			$o2m->save();
	}
}
