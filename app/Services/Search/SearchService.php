<?php

namespace App\Services\Search;

class SearchService
{
	public mixed $service;
	public function __construct($model)
	{
		$this->service = match ($model) {
			'User' => new SearchUser(),
			'Team' => new SearchTeam(),
		};
	}

	public function run(array $input): ?\Illuminate\Database\Eloquent\Collection
	{
		return $this->service->getResults($input);
	}
}