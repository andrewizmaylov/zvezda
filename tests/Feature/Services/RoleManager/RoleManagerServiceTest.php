<?php


use function Pest\Laravel\get;

it('can see', function () {
	get('/')->assertOk();
});
