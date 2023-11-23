<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMerchRequest;
use App\Http\Requests\UpdateMerchRequest;
use App\Models\Game;
use App\Models\Merch;
use App\Services\ContentCreation\DefaultCreator;
use App\Traits\HasCreationRoutine;
use Inertia\Inertia;

class MerchController extends Controller
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
	    return Inertia::render('Merch/MerchIndex', [
		    'merch' => Merch::isAdmin()->get()
	    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
	    return Inertia::render('Merch/MerchCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMerchRequest $request): \Inertia\Response
    {
	    $validated = $request->validated();
	    $instance = $this->creationRoutine($validated, 'Merch');

	    return Inertia::render('API/Latest/GetLatest', [
		    'input' => $instance,
		    'model' => 'Merch'
	    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Merch $slug): \Inertia\Response
    {
	    return Inertia::render('Merch/MerchShow', [
		    'input' => Merch::with('text')->where('id', $slug->id)->first()
	    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Merch $slug): \Inertia\Response
    {
	    return Inertia::render('Merch/MerchCreate', [
		    'input' => Merch::with('text')->where('id', $slug->id)->first()
	    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMerchRequest $request, Merch $slug): \Illuminate\Http\RedirectResponse
    {
	    $validated = $request->validated();
	    $this->creationRoutine($validated, 'Merch');

	    return back()->with('message', 'Merch was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Merch $slug): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
	    $slug->delete();

	    return redirect('/merch');
    }
}
