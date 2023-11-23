<?php

namespace App\Services\ContentCreation;

use App\Contracts\ContentCreationInterface;
use DB;

class RoleCreator extends ContentCreation
{
	public function createInstance(array $data): ContentCreationInterface
	{
		DB::transaction(function () use ($data) {
			$model = '\\App\\Models\\' . $this->model;
			$this->instances = $model::updateOrCreate(['id' => $data['id']], [...$data]);
		});

		return $this;
	}
}