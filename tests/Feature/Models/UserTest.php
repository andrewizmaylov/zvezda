<?php

use App\Enums\RolesEnum;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

describe('team routine', function () {
	beforeEach(function () {
		seedRoles();
		$this->team = Team::factory()->create();
	});

	it('user can join the team', function () {
		$user = User::factory()->create();
		$user->assignRole(RolesEnum::PLAYER);

		$this->team->joinTeam($user);

		expect($this->team->players)
			->toHaveCount(1)
			->each()->toBeInstanceOf(User::class)
			->and($this->team->players)
			->first()
			->id->toEqual($user->id);
	});

	it('team member could be separated by role', function () {
		$user1 = User::factory()->create();
		$user1->assignRole(RolesEnum::PLAYER);
		$user2 = User::factory()->create();
		$user2->assignRole(RolesEnum::PLAYER);
		$user3 = User::factory()->create();
		$user3->assignRole(RolesEnum::COUCH);

		$this->team->joinTeam($user1);
		$this->team->joinTeam($user2);
		$this->team->joinTeam($user3);

		expect($this->team->players)
			->toHaveCount(2)
			->each()->toBeInstanceOf(User::class)
			->and($this->team->players)
			->first()
			->id->toEqual($user1->id)
			->and($this->team->players)
			->first()
			->email->toEqual($user1->email)
			->and($this->team->couchs)
			->toHaveCount(1)
			->first()->email->toEqual($user3->email);
	});
});

//it('simple user can\'t change the role', function () {
//	loginAsUser();
//
//	$players = User::factory()
//		->hasAttached(Role::factory()->create(['id' => 2, 'name' => 'player']))
//		->count(3)->state(
//			new \Illuminate\Database\Eloquent\Factories\Sequence(
//				['email' => 'player1@test.com'],
//				['email' => 'player2@test.com'],
//				['email' => 'player3@test.com'],
//			)
//		)->create();
//	$team = Team::factory()->create();
//
//	$team->joinByList($players);
////	dd($team->users);
//	expect($team->players)
//		->toHaveCount(3);
//});

//it('players can be joined by list', function () {
//	$users = User::factory()->count(20)->hasAttached(Role::factory()->create(['id'   => 2, 'name' => 'player']))->create();
//	$team = Team::factory()->create();
//
//	$team->joinByList($users);
////dd($users[0]->roles);
//	expect($team->players)
//		->toHaveCount(20);
//});

//it('check users', function () {
//	$data = [
//		['id' => '1dd2619a-3c19-4a9d-8526-ad7007f587a1', 'email' => 'john@example.com', 'password' => bcrypt('password')],
//		['id' => '2dd2619a-3c19-4a9d-8526-ad7007f587a2', 'email' => 'jane@example.com', 'password' => bcrypt('password')],
//		['id' => '3dd2619a-3c19-4a9d-8526-ad7007f587a3', 'email' => 'doe@example.com', 'password' => bcrypt('password')],
//	];
////dd(Str::uuid());
////	$users = User::upsert($data, ['email'], ['password']);
//	$users = User::upsert($data, ['email'], ['password' => 'password_22e']);
//
//	$users_id = User::whereIn('email', collect($data)->map(fn($el) => $el['email']))->get(['id', 'email', 'password']);
//
//	dd($users_id);
//});
