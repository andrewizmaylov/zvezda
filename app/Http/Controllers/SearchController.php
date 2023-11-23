<?php

namespace App\Http\Controllers;

use App\Services\Search\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
	public function __invoke(Request $request)
	{
		$searcher = new SearchService($request->model);

		return $searcher->run($request->all());
    }
}
