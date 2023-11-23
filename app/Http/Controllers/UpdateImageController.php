<?php

namespace App\Http\Controllers;

use App\Services\GetModelService;
use Illuminate\Http\Request;

class UpdateImageController extends Controller
{
	/**
	 * @throws \Exception
	 */
	public function __invoke(Request $request): void
	{
		$this->validateData($request->all());
		$model = GetModelService::getModel($request->model, $request->id);
		try {
			$model->updateField($request->file);
		} catch (\Exception $e) {
			echo __('app.file_not_uploaded');
		}
    }

	/**
	 * @param  array  $data
	 * @return void
	 * @throws \Exception
	 */
	public function validateData(array $data): void
	{
		if (!$data['model'] || !$data['id'] || !$data['file']) {
			throw new \Exception(__('app.file_validation_error'));
		}
	}
}
