<?php

use App\Models\Role;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\followingRedirects;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('role can be created', function () {
	seedRoles();

	$response = get(route('roles_index'));

	expect($response)
		->assertOk()
		->toContain('roles', 4);
//		->toContain('roles.1', fn(Assert $assert) => $assert
//			->where('id', 2)
//			->where('name', 'admin')
//		);
//		->toContain('roles.1', fn(Assert $assert) => $assert
//			->where('id', 2)
//			->where('name', 'player')
//		)
//		->toContain('roles.2', fn(Assert $assert) => $assert
//			->where('id', 3)
//			->where('name', 'couch')
//		)
//		->toContain('roles.3', fn(Assert $assert) => $assert
//			->where('id', 7)
//			->where('name', 'sudo')
//		);
//					->each()->toBeInstanceOf(Role::class);
//	expect(Role::all())
//		->toHaveCount(4)
//		->each()->toBeInstanceOf(Role::class);
//
//	get(route('roles_index'))
//		->assertOk()
//		->assertInertia(fn(Assert $assert) => $assert
//			->component('API/Roles/RolesIndex')
//			->has('roles', 4)
//			->where('roles.2.id', 3)
//			->where('roles.2.name', 'coach')
//		);
})->skip();

it('role name can be edited', function () {
	Role::factory()->create(['id' => 12, 'name' => 'role']);
//
//	get(route('roles_index'))
//		->assertOk()
//		->assertInertia(fn(Assert $assert) => $assert
//			->component('API/Roles/RolesIndex')
//			->has('roles', 1)
//			->where('roles.0.id', 12)
//			->where('roles.0.name', 'role')
//		);
	$data = [
		'id' => 12,
		'name' => 'new_role'
	];
//	Role::factory()->create($data);

//	followingRedirects();
	post(route('role_upsert'), [...$data, '_id' => 12]);
	get(route('roles_index'))
		->assertOk()
		->assertInertia(fn(Assert $assert) => $assert
			->component('API/Roles/RolesIndex')
			->has('roles', 1)
			->where('roles.0.id', 12)
			->where('roles.0.name', 'new_role')
		);
})->skip();
