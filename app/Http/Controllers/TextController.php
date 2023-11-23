<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Services\GetModelService;
use Illuminate\Http\Request;

class TextController extends Controller
{
	public function __invoke(Request $request)
	{
		Text::updateOrCreate([
			'textable_id'   => $request->textable_id,
			'textable_type' => 'App\\Models\\'.$request->textable_type,
		], $request->text);

		return back()->with('message', 'Text was updated');
	}
}