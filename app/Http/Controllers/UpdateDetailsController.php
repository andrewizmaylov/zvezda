<?php

namespace App\Http\Controllers;

use App\Enums\FileDisksEnum;
use App\Models\File;
use App\Services\FileStorage\FileStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UpdateDetailsController extends Controller
{
	private mixed $instance;

	/**
	 * @param  Request  $request
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function __invoke(Request $request): RedirectResponse
	{
		$this->validateRequest($request);

		$modelClass = '\\App\\Models\\' . $request->model;
		$this->instance = $modelClass::findOrFail($request->id);

		$this->updateDetails($request->all());

		if ($request->field === 'images') {
			$this->flushTrashed($request->input('trashed', []), FileDisksEnum::getDefinedStorage());
		}

		return back()->with('message', 'Details were updated');
	}

	public function updateDetails(array $data): void
	{
		$details = $this->instance->details ?? [];

		if ($data['field'] === 'root') {
			foreach ($data['root'] as $key => $value) {
				$details[$key] = $value;
			}
		} else {
			$details[$data['field']] = $data[$data['field']];
		}

		$this->instance->update([
			'details' => $details,
		]);
	}

	public function flushTrashed(array $data, $storage): void
	{
		if (empty($data)) return;

		$ids = collect($data)->pluck('id');
		$service = new FileStorage($storage);

		foreach ($ids as $id) {
			$file = File::find($id);
			if ($file) {
				$service->delete($file);
				$file->delete();
			}
		}
	}

	protected function validateRequest(Request $request): void
	{
		if (!$request->model || !$request->id || !$request->field) {
			throw new \Exception('Check params: model|field|id');
		}
	}
}
