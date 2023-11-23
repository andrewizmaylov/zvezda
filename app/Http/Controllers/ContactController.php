<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
	{
		return Contact::query()
						->with('user:id,email,profile_photo_path,created_at')
						->orderBy('last_name')
						->orderBy('first_name')
						->paginate(40);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreContactRequest $request): \Illuminate\Http\RedirectResponse
	{
		$validated = $request->validated();

		Contact::updateOrCreate(['user_id' => auth()->id()], $validated);

		return back()->with('status', 'contact-information-updated');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Contact $contact)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Contact $contact)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Contact $contact)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Contact $contact)
	{
		//
	}
}
