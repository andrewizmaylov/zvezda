<?php

namespace App\Services\ContentCreation;

use App\Contracts\ContentCreationInterface;
use App\Models\Game;
use App\Models\Team;
use App\Services\GameSlugGenerator;
use DB;
use Illuminate\Support\Facades\Log;

class GameCreator extends ContentCreation
{
	public function createInstance(array $data): ContentCreationInterface
	{
		DB::transaction(function () use ($data) {
			$this->instances = $data['id'] ?
				$this->updateRecord($data) : Game::create($data);
		});

		return $this;
	}

	public function updateRecord($data)
	{
		$new_slug = GameSlugGenerator::makeSlugFromData($data);

		if ($new_slug && $new_slug !== $data['slug']) {
			Log::info('Game slug will be updated: ' . $new_slug . '::' . $data['slug']);
			$data['slug'] = $new_slug;
		}

		return Game::updateOrCreate(['id' => $data['id']], $data);
	}
}