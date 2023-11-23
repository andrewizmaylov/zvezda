<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStadiumRequest;
use App\Http\Requests\UpdateStadiumRequest;
use App\Models\Game;
use App\Models\Stadium;
use App\Services\ContentCreation\DefaultCreator;
use App\Traits\HasCreationRoutine;
use Inertia\Inertia;

class StadiumController extends Controller
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
	    return Inertia::render('Stadium/StadiumIndex', [
		    'stadiums' => Stadium::all()
	    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
	    return Inertia::render('Stadium/StadiumCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStadiumRequest $request): \Inertia\Response
    {
	    $validated = $request->validated();
	    $stadium = $this->creationRoutine($validated, 'Stadium');

	    return Inertia::render('API/Latest/GetLatest', [
		    'input' => $stadium,
		    'model' => 'Stadium'
	    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Stadium $slug): \Inertia\Response
    {
	    return Inertia::render('Stadium/StadiumShow', [
		    'stadium' => Stadium::with(['address', 'text'])->find($slug->id)
	    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stadium $slug): \Inertia\Response
    {
	    return Inertia::render('Stadium/StadiumCreate', [
		    'input' => Stadium::with(['address', 'text'])->find($slug->id)
	    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreStadiumRequest $request, Stadium $stadium): \Illuminate\Http\RedirectResponse
    {
	    $validated = $request->validated();
	    $team = $this->creationRoutine($validated, 'Stadium');

	    return back()->with('message', 'Stadium was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stadium $slug)
    {
	    $slug->delete();

	    return redirect('/stadiums');
    }
}
