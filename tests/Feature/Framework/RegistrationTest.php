<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
})->skip(function () {
    return ! Features::enabled(Features::registration());
}, 'Registration support is not enabled.');

test('registration screen cannot be rendered if support is disabled', function () {
    $response = $this->get('/register');

    $response->assertStatus(404);
})->skip(function () {
    return Features::enabled(Features::registration());
}, 'Registration support is enabled.');

test('new users can register', function () {
//	$user = User::factory()->create()
    $response = $this->post('/register', [
//        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

	expect(User::get())
		->toHaveCount(1)
		->first()->email->toEqual('test@example.com');

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
})->skip(function () {
    return ! Features::enabled(Features::registration());
}, 'Registration support is not enabled.');