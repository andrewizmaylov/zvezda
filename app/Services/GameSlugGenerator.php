<?php

namespace App\Services;

use App\Models\Team;
use Carbon\Carbon;

class GameSlugGenerator
{
	/**
	 * @param  array  $data
	 * @return ?string
	 */
	public static function makeSlugFromData(array $data): ?string
	{
		if (!isset($data['team_a']) || !isset($data['team_b']) || !isset($data['date'])) {
			return null;
		}

		$team_1 = Team::where('id', $data['team_a'])->first()->slug;
		$team_2 = Team::where('id', $data['team_b'])->first()->slug;

		$date = Carbon::parse($data['date'])->format('Y-m-d');

		return $team_1 . '-' . $team_2 . '-' . $date;
	}
}