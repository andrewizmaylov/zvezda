<?php

namespace App\Models;

use App\Traits\HasImageTrait;
use App\Traits\IsAdminTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Game extends SluggableModel
{
	use HasFactory;
	use IsAdminTrait;
	use HasImageTrait;

	protected $fillable = [
		'id','name','slug','description','details','published_at','image','date','time','team_a','team_b','stadium_id'
	];

	protected $casts = [
		'details' => 'array',
		'date'    => 'date:Y-m-d',
		'time'    => 'datetime:H:i',
	];

	protected $appends = [
		'image_url'
	];

	/**
	 * Get the text model for the game.
	 */
	public function text(): MorphOne
	{
		return $this->morphOne(Text::class, 'textable');
	}

	/**
	 * @return BelongsTo
	 */
	public function stadium(): BelongsTo
	{
		return $this->belongsTo(\App\Models\Stadium::class);
	}

	/**
	 * @return BelongsTo
	 */
	public function firstTeam(): BelongsTo
	{
		return $this->belongsTo(\App\Models\Team::class, 'team_a');
	}

	/**
	 * @return BelongsTo
	 */
	public function secondTeam(): BelongsTo
	{
		return $this->belongsTo(\App\Models\Team::class, 'team_b');
	}

	public function getSlugOneAttribute()
	{
		return Team::where('id', $this->team_a)->first()->slug;
	}

	public function getSlugTwoAttribute()
	{
		return Team::where('id', $this->team_b)->first()->slug;
	}

	public function getGameDateAttribute()
	{
		return $this->date->format('Y-m-d');
	}

	/**
	 * @return array[]
	 */
	public function sluggable(): array
	{
		return [
			'slug' => [
				'source'    => ['slug_one', 'slug_two', 'game_date'],
				'separator' => '-'
			]
		];
	}

//	public function getSlug()
//	{
//		return $this->slug_one . '-' . $this->slug_two . '-' . $this->game_date;
//	}

//	public static function getSchedule()
//	{
//		return [];
//	}

	/**
	 * @return Attribute
	 */
	protected function timeColumn(): Attribute
	{
		return new Attribute(
			get: fn($value) => $value->format('H:i'), // When accessing the value
			set: fn($value) => Carbon::createFromFormat('H:i:s', $value), // When setting the value
		);
	}
}
