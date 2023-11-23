<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use App\Models\Team;
use App\Services\ContentCreation\GameCreator;
use App\Services\GameSlugGenerator;
use App\Traits\HasCreationRoutine;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class GameController extends Controller
{
	use HasCreationRoutine;

	protected mixed $creator = null;

	public function __construct()
	{
		$this->middleware('admin')->only(['create', 'edit', 'update', 'destroy', 'store']);
		$this->creator = new GameCreator();
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(): Response
	{
		return Inertia::render('Game/GameIndex', [
			'games' => Game::isAdmin()->with(['firstTeam:id,name', 'secondTeam:id,name', 'stadium:id,name'])->orderBy('date')->get()
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): Response
	{
		return Inertia::render('Game/GameCreate', [
			'teams' => Team::all(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreGameRequest $request): Response
	{
//		dd($request->all());
		$validated = $request->validated();
		$instance = $this->creationRoutine($validated, 'Game');

		return Inertia::render('API/Latest/GetLatest', [
			'input' => $instance,
			'model' => 'Game'
		]);
	}

	/**
	 * Display the specified resource.
	 */
	public function show($slug): Response
	{
		return Inertia::render('Game/GameShow', [
			'game' => Game::with(['firstTeam:id,name,logo', 'secondTeam:id,name,logo', 'stadium:id,name,details', 'stadium.text', 'stadium.address', 'text'])->where('slug', $slug)->first(),
			'teams' => Team::all(),
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit($slug): Response
	{
		return Inertia::render('Game/GameCreate', [
			'input' => Game::with(['text', 'firstTeam', 'secondTeam'])->where('slug', $slug)->firstOrFail(),
			'teams' => Team::all(),
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateGameRequest $request, $slug): RedirectResponse
	{
		$validated = $request->validated();
		$this->creationRoutine($validated, 'Game');

		$new_slug = GameSlugGenerator::makeSlugFromData($validated) ?? $slug;

		return $new_slug && $new_slug !== $slug ?
			redirect()->route('games.edit', ['slug' => $new_slug]) : back()->with('message', 'Game was updated');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Game $slug): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
	{
		$slug->delete();

		return redirect('/games');
	}
}
