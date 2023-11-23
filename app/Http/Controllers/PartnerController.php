<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Models\Game;
use App\Models\Partner;
use App\Services\ContentCreation\DefaultCreator;
use App\Traits\HasCreationRoutine;
use Inertia\Inertia;

class PartnerController extends Controller
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
	    return Inertia::render('Partner/PartnerIndex', [
		    'partners' => Partner::isAdmin()->get()
	    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
	    return Inertia::render('Partner/PartnerCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartnerRequest $request): \Inertia\Response
    {
	    $validated = $request->validated();
	    $instance = $this->creationRoutine($validated, 'Partner');

	    return Inertia::render('API/Latest/GetLatest', [
		    'input' => $instance,
		    'model' => 'Partner'
	    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $slug): \Inertia\Response
    {
	    return Inertia::render('Partner/PartnerShow', [
		    'partner' => Partner::with(['address'])->find($slug->id)
	    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $slug): \Inertia\Response
    {
	    return Inertia::render('Partner/PartnerCreate', [
		    'input' => Partner::with(['address'])->find($slug->id)
	    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePartnerRequest $request, Partner $slug): \Illuminate\Http\RedirectResponse
    {
	    $validated = $request->validated();
	    $this->creationRoutine($validated, 'Partner');

	    return back()->with('message', 'Partner was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $slug): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
	    $slug->delete();

	    return redirect('/partners');
    }
}
