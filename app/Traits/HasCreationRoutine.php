<?php

namespace App\Traits;

trait HasCreationRoutine
{
	/**
	 * @param  mixed  $validated
	 * @return mixed
	 */
	public function creationRoutine(mixed $validated, $model): mixed
	{
		return $this->creator->setModel($model)
			->createInstance($validated)
			->getInstance();
	}
}