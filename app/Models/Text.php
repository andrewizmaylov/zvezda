<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Text extends Model
{
    use HasFactory;
	use HasUuids;

	protected $fillable = [
		'id','schema','user_id','user_id','textable_id','textable_type','published_at'
	];

	/**
	 * Get the parent addressable model (user, stadium or order ...).
	 */
	public function textable(): MorphTo
	{
		return $this->morphTo();
	}

	protected $casts = [
		'schema'       => 'array',
	];
}
