<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Models\Position;
use App\Services\ContentCreation\DefaultCreator;
use App\Traits\HasCreationRoutine;
use Inertia\Inertia;
use Inertia\Response;

class PositionController extends Controller
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
    public function index(): Response
    {
        return Inertia::render('Position/PositionIndex', [
			'positions' => Position::isAdmin()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
	    return Inertia::render('Position/PositionCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request): Response
    {
	    $validated = $request->validated();
	    $instance = $this->creationRoutine($validated, 'Position');

	    return Inertia::render('API/Latest/GetLatest', [
		    'input' => $instance,
		    'model' => 'Position'
	    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $slug): Response
    {
	    return Inertia::render('Position/PositionShow', [
		    'position' => $slug
	    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $slug): Response
    {
	    return Inertia::render('Position/PositionCreate', [
		    'input' => $slug
	    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePositionRequest $request, Position $slug): \Illuminate\Http\RedirectResponse
    {
	    $validated = $request->validated();
	    $this->creationRoutine($validated, 'Position');

	    return back()->with('message', 'Position was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $slug): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
	    $slug->delete();

	    return redirect('/positions');
    }
}
