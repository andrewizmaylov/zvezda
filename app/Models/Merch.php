<?php

namespace App\Models;

use App\Traits\HasImageTrait;
use App\Traits\IsAdminTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Merch extends SluggableModel
{
    use HasFactory;
	use IsAdminTrait;
	use HasImageTrait;

	protected $fillable = [
		'id','name','slug','description','details','published_at','image'
	];

	protected $casts = [
		'details' => 'array'
	];

	protected $appends = [
		'image_url'
	];

	/**
	 * Get the text model for the merch.
	 */
	public function text(): MorphOne
	{
		return $this->morphOne(Text::class, 'textable');
	}
}
