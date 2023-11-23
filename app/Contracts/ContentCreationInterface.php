<?php

namespace App\Contracts;

interface ContentCreationInterface
{
	/**
	 * @param  string  $model
	 * @return ContentCreationInterface
	 */
	public function setModel(string $model): ContentCreationInterface;

	/**
	 * @param  array  $data
	 * @return ContentCreationInterface
	 */
	public function createInstance(array $data): ContentCreationInterface;


	/**
	 * @return mixed
	 */
	public function getInstance(): mixed;
}