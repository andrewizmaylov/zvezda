<?php

namespace App\Services\ContentCreation;


use App\Models\Team;

class PlayerCreator extends UserCreator
{
	private Team $appendable;

	public function __construct(Team $appendable)
	{
		$this->appendable = $appendable;
	}

	/**
	 * @return void
	 */
	public function createTeam(): void
	{
		$this->appendable->joinByList($this->instances);
	}
}