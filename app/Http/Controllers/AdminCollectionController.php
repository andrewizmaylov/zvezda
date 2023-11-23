<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AdminCollectionController extends Controller
{
	/**
	 * @param  Request  $request
	 * @return Collection
	 */
	public function __invoke(Request $request): Collection
	{
		$model = '\\App\\Models\\' . $request->model;

		return $model::all();
    }
}
