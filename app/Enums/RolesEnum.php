<?php

namespace App\Enums;

use App\Models\Role;

class RolesEnum
{
    public const ADMIN = 1;
    public const PLAYER = 2;
    public const COUCH = 3;
    public const SUDO = 7;

	public static function values()
	{
		return [
			self::ADMIN,
			self::PLAYER,
			self::COUCH,
			self::SUDO,
		];
	}

	public static function getRealRoles(): \Illuminate\Database\Eloquent\Collection
	{
		return Role::all();
	}

}
