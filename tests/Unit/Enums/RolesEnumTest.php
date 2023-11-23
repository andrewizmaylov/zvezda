<?php

use App\Enums\RolesEnum;
use App\Models\Role;
use App\Services\RoleManager\RoleManagerService;

//it('all roles from DB are present in ENUM', function () {
//	$roles_enum = new ReflectionClass(RolesEnum::class);
//	$constants = $roles_enum->getConstants();
//
//	$met = $roles_enum->getMethod('getRealRoles');
//	$values = $met->invokeArgs(null, []);  // Invoking a static method
//
//	expect($constants)->toEqualCanonicalizing($values);
//
//});
