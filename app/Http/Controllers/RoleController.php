<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
	/**
	 * @return Response
	 */
	public function index(): \Inertia\Response
	{
		return Inertia::render('API/Roles/RolesIndex', [
			'roles' => Role::all(),
		]);
	}

	/**
	 * @param  StoreRoleRequest  $request
	 * @return RedirectResponse
	 */
	public function upsertRole(StoreRoleRequest $request): \Illuminate\Http\RedirectResponse
	{
		$validated = $request->validated();

		$roleData = [
			'id' => $request->id,
			'name' => $validated['name'],
		];

		Role::updateOrInsert(['id' => $request->_id], $roleData);

		return back()->with('message', 'Role updated');
    }
}
