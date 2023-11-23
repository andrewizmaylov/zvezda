<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\Game;
use App\Models\News;
use App\Services\ContentCreation\DefaultCreator;
use App\Traits\HasCreationRoutine;
use Inertia\Inertia;

class NewsController extends Controller
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
	    return Inertia::render('News/NewsIndex', [
		    'news' => News::all()
	    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
	    return Inertia::render('News/NewsCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request): \Inertia\Response
    {
	    $validated = $request->validated();
	    $instance = $this->creationRoutine($validated, 'News');

	    return Inertia::render('API/Latest/GetLatest', [
		    'input' => $instance,
		    'model' => 'News'
	    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $slug): \Inertia\Response
    {
	    return Inertia::render('News/NewsShow', [
		    'news' => News::with('text')->where('id', $slug->id)->first()
	    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $slug): \Inertia\Response
    {
	    return Inertia::render('News/NewsCreate', [
		    'input' => News::with('text')->where('id', $slug->id)->first()
	    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreNewsRequest $request, News $slug): \Illuminate\Http\RedirectResponse
    {
	    $validated = $request->validated();
	    $this->creationRoutine($validated, 'News');

	    return back()->with('message', 'News was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $slug): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
	    $slug->text()->delete();
	    $slug->delete();

	    return redirect('/news');
    }
}
