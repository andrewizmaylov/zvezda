<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use App\Services\GetModelService;
use Illuminate\Http\RedirectResponse;

class UpdateAddressController extends Controller
{
	/**
	 * @param  StoreAddressRequest  $request
	 * @return RedirectResponse
	 */
	public function __invoke(StoreAddressRequest $request): \Illuminate\Http\RedirectResponse
	{
		Address::updateOrCreate([
			'addressable_id'   => $request->addressable_id,
			'addressable_type' => 'App\\Models\\' . $request->addressable_type,
		], $request->validated());

		return back()->with('message', 'Address was updated');
	}
}
