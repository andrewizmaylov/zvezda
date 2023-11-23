<?php

namespace App\Services\Search\Contracts;

interface SearchSerrviceInterface
{
	public function getResults(array $input);
}