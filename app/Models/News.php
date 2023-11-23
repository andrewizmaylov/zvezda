<?php

namespace App\Models;

use App\Traits\HasImageTrait;
use App\Traits\IsAdminTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class News extends SluggableModel
{
	use HasFactory;
	use HasImageTrait;
	use IsAdminTrait;

	protected $fillable = [
		'id','name','slug','description','details','published_at','image','schema','user_id','team_id'
	];

	protected $casts = [
		'schema'       => 'array',
		'details'      => 'array',
		'published_at' => 'datetime'
	];

	protected $appends = [
        'image_url',
	];

	/**
	 * Get the text model for the news.
	 */
	public function text(): MorphOne
	{
		return $this->morphOne(Text::class, 'textable');
	}
}
