<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetModelService
{
	/**
	 * @param $model
	 * @param $id
	 * @return Model|ModelNotFoundException
	 */
	public static function getModel($model, $id): Model|ModelNotFoundException
	{
		$model = '\\App\\Models\\' . $model;

		return $model::findOrFail($id);
	}
}