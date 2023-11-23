<?php

use App\Models\Contact;
use App\Models\Team;

use App\Models\User;
use function Pest\Laravel\get;
use Inertia\Testing\AssertableInertia as Assert;

it('returns a successful response', function () {
	get(route('home'))->assertOk();
});

// index set
it('can see roles_index page', function () {
	seedRoles();
	get(route('roles_index'))
		->assertRedirect();


	loginAsAdmin();
	get(route('roles_index'))
		->assertOk()
		->assertInertia(fn (Assert $assert) => $assert
			->component('API/Roles/RolesIndex')
			->has('roles', 4)
		);
});

it('can see game_index page', function () {
	loginAsUser();
	get(route('games.index'))
		->assertOk()
		->assertInertia(fn (Assert $assert) => $assert
			->component('Game/GameIndex')
		);
});

it('can see merch_index page', function () {
	loginAsUser();

	get(route('merch.index'))
		->assertOk()
		->assertInertia(fn (Assert $assert) => $assert
			->component('Merch/MerchIndex')
		);
});

it('can see news_index page', function () {
	get(route('news.index'))
		->assertOk()
		->assertInertia(fn (Assert $assert) => $assert
			->component('News/NewsIndex')
		);
});

it('can see partner_index page', function () {
	loginAsUser();

	get(route('partners.index'))
		->assertOk()
		->assertInertia(fn (Assert $assert) => $assert
			->component('Partner/PartnerIndex')
		);
});

it('can see stadium_index page', function () {
	get(route('stadiums.index'))
		->assertOk()
		->assertInertia(fn (Assert $assert) => $assert
			->component('Stadium/StadiumIndex')
		);
});

it('can see user_index', function () {
	get(route('user_index'))->assertOk();
});

it('can see teams.index', function () {
	get(route('teams.index'))
		->assertOk();
});




it('can see team_detail', function () {
	$team = Team::factory()->published(now())->create(['name' => 'new dimension']);
//	dd($team);
//	expect($team)
//		->toBeInstanceOf(Team::class);
	expect($team)->toHaveKeys(['name', 'slug']);
//	get(route('teams.show', $team))->assertOk();
});

it('can generate the full name of a user', function (Contact $contact, $fullName) {
	expect($contact->full_name)->toBe($fullName);
})->with([
	[fn() => Contact::factory()->create(['first_name' => 'Nuno', 'last_name' => 'Maduro']), 'Nuno Maduro'],
	[fn() => Contact::factory()->create(['first_name' => 'Luke', 'last_name' => 'Downing']), 'Luke Downing'],
	[
		fn() => Contact::factory()->create(['first_name' => 'Freek', 'last_name' => 'Van Der Herten']),
		'Freek Van Der Herten'
	],
])->repeat(3);

it('team creation page is visible only by admin', function () {
	get(route('teams.create'))
		->assertRedirect();

	seedRoles();
	loginAsAdmin();

	get(route('teams.create'))
		->assertOk()
		->assertInertia(fn (Assert $assert) => $assert
			->component('Team/TeamCreate')
		);
});