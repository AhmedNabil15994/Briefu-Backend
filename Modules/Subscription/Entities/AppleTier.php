<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;

class AppleTier extends Model
{
	const TIERS = [
		['tier_id' => "com.tocaan.briefu.propackage",'price' => "99"],
	];
	protected $guarded   = ['id'];
	public function subscriptions()
	{
	    return $this->hasMany(Subscription::class);
	}
}
