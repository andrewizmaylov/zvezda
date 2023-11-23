<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ToggleTeamController extends Controller
{
	public function __invoke(Request $request)
	{
		User::find($request->user_id)->teams()->toggle($request->team_id);

		return back()->with('message', 'Teams relation was updated');
    }
}
