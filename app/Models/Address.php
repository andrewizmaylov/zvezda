<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    use HasFactory;
	use HasUuids;

	protected $fillable = [
		'id','zip','country','city','street_01','street_02','addressable_id','addressable_type'
	];

	/**
	 * Get the parent addressable model (user, stadium or order ...).
	 */
	public function addressable(): MorphTo
	{
		return $this->morphTo();
	}
}
