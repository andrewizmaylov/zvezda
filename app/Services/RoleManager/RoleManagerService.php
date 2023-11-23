<?php

namespace App\Services\RoleManager;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleManagerService
{

	/**
	 * @return Collection
	 */
	public static function getRealRoles(): \Illuminate\Database\Eloquent\Collection
	{
		return Role::all();
	}

	public function update(array $files, array $data)
	{

	}
}