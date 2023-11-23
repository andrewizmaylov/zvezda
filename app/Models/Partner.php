<?php

namespace App\Models;

use App\Traits\HasImageTrait;
use App\Traits\IsAdminTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Partner extends SluggableModel
{
    use HasFactory;
	use HasImageTrait;
	use IsAdminTrait;

	protected $fillable = [
		'id','name','slug','description','details','published_at','logo','banner'
	];

	protected $casts = [
		'details' => 'array',
		'published_at' => 'datetime',
	];

	protected $appends = [
		'logo_url', 'banner_url'
	];

	/**
	 * Get the partners address.
	 */
	public function address(): MorphOne
	{
		return $this->morphOne(Address::class, 'addressable');
	}
}
