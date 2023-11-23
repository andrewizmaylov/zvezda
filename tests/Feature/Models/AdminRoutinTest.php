<?php

use App\Enums\RolesEnum;
use App\Models\Game;
use App\Models\Merch;
use App\Models\News;
use App\Models\Partner;
use App\Models\Position;
use App\Models\Role;
use App\Models\Stadium;
use App\Models\Team;
use App\Models\User;
use App\Services\ContentCreation\DefaultCreator;
use Carbon\Carbon;

describe('team routine', function () {
	beforeEach(function () {
		seedRoles();
		$this->creator = new DefaultCreator();
	});

	//	check that admin can create any of [player, couch, stadium, game, news, merch etc]
	//  for creation we will use a special service
	//  this service is more than just object creation
	//  we could implement logging processes together with notify and so
	//  for now we just check creation routine

	it('admin can create a player', function () {
		$role = RolesEnum::PLAYER;
		$data = array(getUser($role));
		$player_creator = new \App\Services\ContentCreation\UserCreator();
		$player = $player_creator->setModel('User')->createInstance($data)->getInstance()[0];

		expect(User::first())
			->id->toBe($player->id);

		$this->assertDatabaseHas('contacts', [
			'first_name'  => $data[0]['first_name'],
			'second_name' => $data[0]['second_name'],
			'last_name'   => $data[0]['last_name'],
			'birthday'    => $data[0]['birthday'],
		]);
		$this->assertDatabaseHas('role_user', [
			'role_id' => RolesEnum::PLAYER,
			'user_id' => $player->id,
		]);
	});

	it('admin can create a couch', function () {
		$role = RolesEnum::COUCH;
		$data = array(getUser($role));
		$player_creator = new \App\Services\ContentCreation\UserCreator();
		$player = $player_creator->setModel('User')->createInstance($data)->getInstance()[0];

		expect(User::first())
			->id->toBe($player->id);

		$this->assertDatabaseHas('contacts', [
			'first_name'  => $data[0]['first_name'],
			'second_name' => $data[0]['second_name'],
			'last_name'   => $data[0]['last_name'],
			'birthday'    => $data[0]['birthday'],
		]);
		$this->assertDatabaseHas('role_user', [
			'role_id' => RolesEnum::COUCH,
			'user_id' => $player->id,
		]);
	});

	it('admin can create a stadium', function () {
		$data = getStadium();
		$this->creator->setModel('Stadium')->createInstance($data);

		$this->assertDatabaseHas('stadia', [
			'name'        => $data['name'],
			'description' => $data['description'],
		]);

		expect(Stadium::all())
			->toHaveCount(1)
			->first()->description->toBe($data['description'])
			->first()->details->toEqualCanonicalizing($data['details'])
			->first()->details->toEqualCanonicalizing($data['details']);
	});

	it('admin can create a game', function () {
		$data = getGame();
		$game = $this->creator->setModel('Game')->createInstance($data)->getInstance();

		$this->assertDatabaseHas('games', [
			'name'        => $data['name'],
			'description' => $data['description'],
			'team_a'      => $data['team_a'],
			'team_b'      => $data['team_b'],
		]);

		expect(Game::all())
			->toHaveCount(1)
			->first()->id->toBe($game->id)
			->first()->description->toBe($game->description)
			->first()->date->format('Y-m-d')->toBe($game->date->format('Y-m-d'))
			->first()->details->toEqualCanonicalizing($data['details']);
	});

	it('admin can create a merch', function () {
		$data = getMerch();
		$this->creator->setModel('Merch')->createInstance($data);

		$this->assertDatabaseHas('merches', [
			'name'        => $data['name'],
			'description' => $data['description'],
		]);

		expect(Merch::all())
			->toHaveCount(1)
			->first()->description->toBe($data['description'])
			->first()->details->toEqualCanonicalizing($data['details']);
	});

	it('admin can create a team', function () {
		$data = getTeam();
		$this->creator->setModel('Team')->createInstance($data);

		$this->assertDatabaseHas('teams', [
			'name'        => $data['name'],
			'description' => $data['description'],
			'slug'        => $data['slug'],
			'logo'        => $data['logo'],
			'banner'      => $data['banner'],
		]);

		expect(Team::all())
			->toHaveCount(1)
			->first()->name->toBe($data['name'])
			->first()->description->toBe($data['description'])
			->first()->slug->toBe($data['slug'])
			->first()->banner->toBe($data['banner'])
			->first()->logo->toBe($data['logo']);
	});

	it('admin can create a news', function () {
		$data = getNews();
		$news = $this->creator->setModel('News')->createInstance($data)->getInstance();

		$this->assertDatabaseHas('news', [
			'name'         => $data['name'],
			'slug'         => $data['slug'],
			'description'  => $data['description'],
			'image'        => $data['image'],
			'published_at' => $data['published_at'],
			'user_id'      => $data['user_id'],
			'team_id'      => $data['team_id'],
		]);

		expect(News::all())
			->first()->name->toBe($news->name)
			->first()->description->toBe($news->description)
			->first()->slug->toBe($news->slug)
			->first()->image->toBe($news->image)
			->first()->schema->toBe($news->schema)
			->first()->published_at->format('Y-m-d H:m:s')->toBe($news->published_at->format('Y-m-d H:m:s'))
			->first()->user_id->toBe($news->user_id)
			->first()->team_id->toBe($news->team_id);
	});

	it('admin can create a partner', function () {
		$data = getPartner();
		$partner = $this->creator->setModel('Partner')->createInstance($data)->getInstance();

		$this->assertDatabaseHas('partners', [
			'name'         => $data['name'],
			'slug'         => $data['slug'],
			'description'  => $data['description'],
			'logo'         => $data['logo'],
			'banner'       => $data['banner'],
			'published_at' => $data['published_at'],
		]);

		expect(Partner::all())
			->first()->id->toBe($partner->id)
			->first()->name->toBe($partner->name)
			->first()->slug->toBe($partner->slug)
			->first()->description->toBe($partner->description)
			->first()->logo->toBe($partner->logo)
			->first()->banner->toBe($partner->banner)
			->first()->published_at->format('Y-m-d H:m:s')->toBe($partner->published_at->format('Y-m-d H:m:s'))
			->first()->details->toEqualCanonicalizing($partner->details);
	});

	it('admin can create a position', function () {
		$data = getPosition();
		$position = $this->creator->setModel('Position')->createInstance($data)->getInstance();

		$this->assertDatabaseHas('positions', [
			'name'         => $position['name'],
			'slug'         => $position['slug'],
			'description'  => $position['description'],
			'published_at' => $position['published_at'],
		]);

		expect(Position::all())
			->first()->id->toBe($position->id)
			->first()->name->toBe($position->name)
			->first()->slug->toBe($position->slug)
			->first()->description->toBe($position->description)
			->first()->published_at->format('Y-m')->toBe($position->published_at->format('Y-m'))
			->first()->details->toEqualCanonicalizing($position->details);
	});

	it('admin can create a role', function () {
		$data = getRole();
		$role_creator = new \App\Services\ContentCreation\RoleCreator();
		$role = $role_creator->setModel('Role')->createInstance($data)->getInstance();

		$this->assertDatabaseHas('roles', [
			'id'   => $role->id,
			'name' => $role->name,
		]);

		expect(Role::find($role->id))
			->id->toBe($role->id)
			->name->toBe($role->name);
	});
});


function randomDateBetween(): string
{
	$start = Carbon::parse('1990-01-01');
	$end = Carbon::parse('2004-01-01');

	return Carbon::createFromTimestamp(rand($start->timestamp, $end->timestamp))->format('Y-m-d');
}

/**
 * @param  string  $name
 * @return string
 */
function generateSlug(string $name): string
{
	return Str::slug($name);
}

function getUser($role): array
{
	return [
		'email'              => 'andrew@testdomain.com',
		'profile_photo_path' => fake()->url,
		'role'               => $role,
		'first_name'         => 'andrew',
		'second_name'        => 'jey',
		'last_name'          => 'smith',
		'tg'                 => '@andrew_smith',
		'birthday'           => randomDateBetween(),
	];
}

function getMerch(): array
{
	return [
		'name'        => 'merch',
		'slug'        => 'merch',
		'description' => fake()->text,
		'details'     => [
			'images' => [
				Str::random(50), Str::random(50)
			],
			'sizes'  => [
				'sm', 'l', 'lg', 'xl'
			]
		]
	];
}

function getGame(): array
{
	return [
		'name'        => 'game',
		'slug'        => 'game',
		'description' => fake()->text,
		'date'        => Carbon::parse('+2 weeks')->format('Y-m-d H:i:s'),
		'team_a'      => Team::factory()->create()->id,
		'team_b'      => Team::factory()->create()->id,
		'details'     => [
			'color' => 'red',
			'teams' => [
				'a' => [
					Str::random(36), Str::random(36), Str::random(36), Str::random(36),
				],
				'b' => [
					Str::random(36), Str::random(36), Str::random(36), Str::random(36),
				],
			]
		]
	];
}

function getStadium(): array
{
	return [
		'name'        => 'stadium_a',
		'slug'        => 'stadium_a',
		'description' => fake()->text,
		'details'     => [
			'color' => 'red',
			'plans' => [
				'a' => [
					Str::random(36), Str::random(36), Str::random(36), Str::random(36),
				],
			],
			'map'   => Str::random(),
		]
	];
}

function getTeam(): array
{
	return [
		'name'        => 'Team A',
		'description' => fake()->text,
		'slug'        => Str::slug('Team A'),
		'logo'        => Str::random(),
		'banner'      => Str::random(),
	];
}

function getNews(): array
{
	$name = fake()->sentence;

	return [
		'name'         => $name,
		'slug'         => generateSlug($name),
		'description'  => fake()->text,
		'image'        => Str::random(120),
		'schema'       => fake()->text,
		'published_at' => Carbon::parse('-1 day'),
		'user_id'      => User::factory()->create()->id,
		'team_id'      => Team::factory()->create()->id,
		'details'      => [
			[
				'id'    => Str::random(36),
				'model' => 'User',
			],
			[
				'id'    => Str::random(36),
				'model' => 'User',
			],
			[
				'id'    => Str::random(36),
				'model' => 'Team',
			]
		],
	];
}

function getPartner(): array
{
	$name = fake()->name;

	return [
		'name'         => $name,
		'slug'         => generateSlug($name),
		'description'  => fake()->text,
		'logo'         => Str::random(45),
		'banner'       => Str::random(45),
		'published_at' => Carbon::parse('-2 week'),
		'details'      => [
			'specials' => [

			],
			'images'   => [
				Str::random(36), Str::random(36),
			],
		],
	];
}

function getPosition(): array
{
	$name = fake()->name;

	return [
		'name'         => $name,
		'slug'         => generateSlug($name),
		'description'  => fake()->text,
		'published_at' => Carbon::parse('-2 week'),
		'details'      => [
			'specials' => [

			],
			'images'   => [
				Str::random(36), Str::random(36),
			],
		],
	];
}

function getRole(): array
{
	return [
		'id'   => 0,
		'name' => 'tourist',
	];
}
//
//it('can create players', function () {
//	$role = Role::find(2);
//	User::factory()->count(20)->create()->each(function ($user) use ($role) {
//		$user->roles()->attach($role);
//	});
//});