<?php

use App\Models\Stadium;

use function Pest\Laravel\post;

it('can store and update images field on details column', function () {
	loginAsUser();

	$id = Stadium::factory()->create([
		'details' => [
			'string'  => 'some data',
			'integer' => 925,
			'email'   => auth()->user()->email,
			'images'  => [
				[
					"id"   => "9a6f9379-fc27-4c13-910e-0c3f61fda412",
					"link" => "dev/tmp/LNbOxEIZjI8NpFf0ampJ5iU0e71dEapxPnQXblga.jpg"
				],
				[
					"id"   => "9a6f939a-a60a-4a7c-8972-401191488f9e",
					"link" => "dev/tmp/B8NGLitCHvDX0XgmOcCJLiwC0pw05XFORvrPpeMw.jpg"
				],
				[
					"id"   => "9a6fc67a-19ff-4b40-b77c-8ef76139bf87",
					"link" => "dev/tmp/WmB8kd2L1Bl5gmhzDof2Mbn39YIyAN3I0yR62bUO.jpg"
				],
				[
					"id"   => "9a6fc9c1-8656-41dc-855c-01f7a3db8703",
					"link" => "dev/tmp/rbiOXZdSBoWRVzNhLzxuhFla70TrJvu5xYVv0hbM.jpg"
				]
			]
		]
	])->id;

	$dataSet = [
		"id"     => $id,
		"images" => [
			[
				"id"   => "9a740d8e-b4ad-4c6f-b59f-641f7a3e787e",
				"link" => "dev/tmp/s7RGBXXkgypvGr9vrWL5Rb7LuabbcbP1kP4fKOgs.jpg",
			],
			[
				"id"   => "9a740d8e-e058-4a44-89ad-3fce98fd8c50",
				"link" => "dev/tmp/dKJrLp12arCOj4oCRp9TvzjBxzp5EYh84pUakn2X.jpg",
			],
		],
		"model"  => "Stadium",
		"field"  => 'images',
	];

	$response = post('/update_details', $dataSet);

	$response->assertStatus(302);

	$stadium = Stadium::find($id);

	foreach ($dataSet['images'] as $expectedTag) {
		expect($stadium->details['images'])->toContain($expectedTag);
	}

	expect($stadium->details)
		->email->toBe(auth()->user()->email)
		->string->toBe('some data')
		->integer->toBe(925);
});
