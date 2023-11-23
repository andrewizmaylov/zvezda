<?php

namespace App\Services\Search;

use App\Services\Search\Contracts\SearchSerrviceInterface;

class SearchTeam implements SearchSerrviceInterface
{

	public function getResults(array $input)
	{
		dd('team search ',$input);
	}
}