<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\ExpectationFailedException;
use Tests\TestCase;

use function Pest\Laravel\actingAs;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, LazilyRefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBePhoneNumber', function () {
	expect($this->value)->toBeString()->toStartWith('+');

	if (! is_numeric(Str::of($this->value)->after('+')->remove([' ', '-', '_'])->__toString())) {
		throw new ExpectationFailedException('Phone mast be numeric');
	}
});

//expect()->intercept('toContain', TestResponse::class, function (...$value) {
//	$this->value->assertInertia(fn (AssertableInertia $inertia) => $inertia->has(...$value));
//});
/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * @param  User|null  $user
 * @return User
 */
function loginAsUser(User $user = null): User
{
	$new_user = $user ?? User::factory()->create([
		'email' => 'andrew.izmaylov@gmail.com'
	]);
	actingAs($new_user);

	return $new_user;
}

function loginAsAdmin(User $user = null): User
{
	$new_user = loginAsUser($user);
	$new_user->assignRole(\App\Enums\RolesEnum::ADMIN);

	return $new_user;
}

/**
 * @return void
 */
function seedRoles(): void
{
	$roles = [
		['id' => 1, 'name' => 'admin'],
		['id' => 2, 'name' => 'player'],
		['id' => 3, 'name' => 'coach'],
		['id' => 7, 'name' => 'sudo'],
	];

	Role::insert($roles);
}

