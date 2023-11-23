<?php

use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

it('creation process is for admin only', function () {
	get(route('teams.create'))
		->assertRedirect('/');
//		->assertInertia(fn(Assert $assert) => $assert
//			->component('MainPage')
//		);
	get(route('teams.index'))
		->assertOK()
		->assertInertia(fn(Assert $assert) => $assert
			->component('Team/TeamIndex')
		);
});

describe('auth', function () {
	$team = [
		'name' => 'team1',
		'slug' => 'team1_slug',
		'description' => 'team1 description',
		'banner' => Str::random(100),
		'logo' => Str::random(100),
		'published_at' => Carbon::now(),
	];

	it('team can be created with all necessary information', function () use ($team) {
		$team = Team::create($team);

		expect(Team::all())
			->toHaveCount(1)
			->first()->toBeInstanceOf(Team::class)
			->first()->id->toBe($team->id);
	});

	test('admin can create new team thru the dedicated page', function () use ($team) {
		seedRoles();
		$user = loginAsUser();
		$user->assignRole(\App\Enums\RolesEnum::ADMIN);

		$response = Pest\Laravel\post(route('teams.store'), $team);
		$response->dump();

		$this->assertDatabaseHas('teams', $team);

		expect(Team::all())
			->toHaveCount(1)
			->each()->toBeInstanceOf(Team::class);
	});

	test('admin can change team, simple user not', function () use ($team) {
		seedRoles();
		$admin = User::factory()->create();
		$admin->assignRole(\App\Enums\RolesEnum::ADMIN);

		$player = User::factory()->create();


		$response = Pest\Laravel\post(route('teams.store'), $team);
		$response->dump();

		$this->assertDatabaseHas('teams', $team);

		expect(Team::all())
			->toHaveCount(1)
			->each()->toBeInstanceOf(Team::class);
	})->skip();
});


it('user can show only published teams', function () {
	$teams = Team::factory()->published(Carbon::now())->count(3)->create();
	$unpublished_team = Team::factory()->create();

	$response = get(route('teams.index'));

	expect($response)
		->assertOk();
});

it('admin can see all teams on index page', function () {
});
