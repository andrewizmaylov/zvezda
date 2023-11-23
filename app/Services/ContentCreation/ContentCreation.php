<?php

namespace App\Services\ContentCreation;

use App\Contracts\ContentCreationInterface;
use DB;

abstract class ContentCreation implements ContentCreationInterface
{
	protected string $model;
	protected mixed $instances = [];

	/**
	 * @inheritDoc
	 */
	public function setModel(string $model): ContentCreationInterface
	{
		$this->model = $model;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public abstract function createInstance(array $data): ContentCreationInterface;

	public function getInstance(): mixed
	{
		return $this->instances;
	}
}