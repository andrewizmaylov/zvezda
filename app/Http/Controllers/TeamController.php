<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Http\Requests\StoreTeamRequest;
use App\Models\Team;
use App\Models\User;
use App\Services\ContentCreation\DefaultCreator;
use App\Services\GetModelService;
use App\Traits\HasCreationRoutine;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamController extends Controller
{
	use HasCreationRoutine;

	protected mixed $creator = null;

	public function __construct()
	{
		$this->middleware('admin')->only(['create', 'edit', 'update', 'destroy', 'store']);
		$this->creator = new DefaultCreator();
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(): \Inertia\Response
	{
		return Inertia::render('Team/TeamIndex', [
			'teams' => Team::all()
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): \Inertia\Response
	{
		return Inertia::render('Team/TeamCreate');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreTeamRequest $request): \Inertia\Response
	{
		$validated = $request->validated();
		$team = $this->creationRoutine($validated, 'Team');

		return Inertia::render('API/Latest/GetLatest', [
			'input' => $team,
			'model' => 'Team'
		]);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Team $team): \Inertia\Response
	{
		return Inertia::render('Team/TeamShow', [
			'team' => Team::with('text')->where('id', $team->id)->firstOrFail()
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Team $slug): \Inertia\Response
	{
		return Inertia::render('Team/TeamCreate', [
			'input' => Team::with('text')->where('id', $slug->id)->firstOrFail()
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(StoreTeamRequest $request, Team $team): \Illuminate\Http\RedirectResponse
	{
		$validated = $request->validated();
		$team = $this->creationRoutine($validated, 'Team');

		return back()->with('message', 'Team was updated');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Team $slug)
	{
		$slug->delete();

		return redirect('/teams');
	}

	public function getMembers(Request $request)
	{
		$team_id = GetModelService::getModel('Team', $request->team_id)->id;

		return $this->getPlayers($team_id);
	}

	public function getTheGame(Request $request)
	{
		return response()->json([
			'team_a' => $this->getPlayers($request->team_a),
			'team_b' => $this->getPlayers($request->team_b),
		]);
	}

	/**
	 * @param  mixed  $team_id
	 * @return Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function getPlayers(mixed $team_id): array|\Illuminate\Database\Eloquent\Collection
	{
		return User::query()
			->whereHas('teams', function (Builder $query) use ($team_id) {
				$query->where('team_id', $team_id);
			})
			->whereHas('roles', function ($query) {
				$query->whereIn('role_id', [RolesEnum::PLAYER, RolesEnum::COUCH]);
			})
			->with(['contact', 'roles'])
			->get();
	}

}
