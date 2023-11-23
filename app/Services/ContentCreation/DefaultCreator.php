<?php

namespace App\Services\ContentCreation;

use App\Contracts\ContentCreationInterface;
use DB;

class DefaultCreator extends ContentCreation
{
	public function createInstance(array $data): ContentCreationInterface
	{
		DB::transaction(function () use ($data) {
			$model = '\\App\\Models\\' . $this->model;
			$this->instances = $model::updateOrCreate(['slug' => $data['slug']], [...$data]);
		});

		return $this;
	}
}