<?php

namespace App\Services\Search;

use App\Enums\RolesEnum;
use App\Models\User;
use App\Services\Search\Contracts\SearchSerrviceInterface;

class SearchUser implements SearchSerrviceInterface
{

	public function getResults(array $input): \Illuminate\Database\Eloquent\Collection
	{
		$search = $input['search_input'];

		return User::query()
			->with(['contact', 'roles'])
			->where(function ($query) use ($search) {
				$query->where('users.email', 'like', "%$search%")
					->orWhereHas('contact', function ($query) use ($search) {
						$query->where('first_name', 'like', "%$search%")
							->orWhere('last_name', 'like', "%$search%");
					});
			})
			->whereHas('roles', function ($query) {
				$query->whereIn('role_id', [RolesEnum::PLAYER,RolesEnum::COUCH]);
			})
			->get();
	}
}