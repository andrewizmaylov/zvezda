<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait IsAdminTrait
{
	/**
	 * @param  Builder  $query
	 * @return Builder
	 */
	public function scopeIsAdmin(Builder $query): Builder
	{
		return auth()->user()->isAdmin() ?
			$query : $query->whereNotNull('published_at');
	}
}