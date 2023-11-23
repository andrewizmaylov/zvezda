<?php

namespace App\Http\Controllers;

use App\Exceptions\InconsistentDataException;
use App\Http\Requests\StoreUserRequest;
use App\Imports\UsersImport;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Services\ContentCreation\UserCreator;
use App\Services\CreateFromExelService;
use App\Traits\HasCreationRoutine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
	use HasCreationRoutine;
	protected mixed $creator = null;

	public function __construct()
	{
		$this->middleware('admin')->only(['create', 'edit', 'update', 'destroy', 'store']);
		$this->creator = new UserCreator();
	}

	/**
     * Display a listing of the resource.
     */
    public function index()
    {
	    return Inertia::render('User/UserIndex', [
		    'users' => User::with(['contact:user_id,first_name,last_name'])->get()
	    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
	    return Inertia::render('User/UserCreate', [
			'roles' => Role::all()
	    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
	    $validated = $request->validated();
	    $response = $this->creationRoutine(array($validated), 'User');

	    return Inertia::render('API/Latest/GetLatest', [
		    'input' => $response[0],
		    'model' => 'User'
	    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
	    return Inertia::render('User/UserShow', [
		    'user' => User::with(['contact', 'roles', 'address', 'teams'])->find($user->id),
	    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
	    return Inertia::render('User/UserCreate', [
		    'user' => User::with(['contact', 'roles', 'address', 'teams'])->find($user->id),
		    'roles' => Role::all()
	    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, User $user)
    {
	    $validated = $request->validated();
	    $this->creationRoutine(array($validated), 'User');

	    return back()->with('message', 'User was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
	    $user->delete();

	    return redirect('/users');
    }

	public function updateRoles(Request $request) {
		User::find($request->user_id)->assignRole($request->roles);

		return back();
	}

	/**
	 * @throws InconsistentDataException
	 */
	public function uploadFromExel(Request $request): JsonResponse
	{
		$request->validate([
			'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
		]);

		if (!$request->creatable) {
			throw new InconsistentDataException('app.inconsistent_data');
		}
		$data = [
			'appendable_id' => $request->appendable_id ?? null,
			'appendable' => $request->appendable ?? null,
			'creatable' => $request->creatable,
		];

		$service = new CreateFromExelService($data);
		return $service->handle($request->excel_file);
	}
}
