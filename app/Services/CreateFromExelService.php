<?php

namespace App\Services;

use App\Services\ContentCreation\ContentCreation;
use App\Services\ContentCreation\DefaultCreator;
use App\Services\ContentCreation\GameCreator;
use App\Services\ContentCreation\PlayerCreator;
use App\Services\ContentCreation\RoleCreator;
use App\Services\ContentCreation\UserCreator;
use App\Traits\HasCreationRoutine;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Imports\ExcelImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Model;

class CreateFromExelService
{
	use HasCreationRoutine;

	protected mixed $appendable;
	protected string $creatable;
	protected bool $success = false;
	protected Collection $data;
	private mixed $creator;

	public function __construct(array $input_data)
	{
		$this->appendable = $this->defineModel($input_data);
		$this->creatable = $input_data['creatable'];
		$this->creator = $this->defineCreator();
	}

	/**
	 * @param $file
	 * @return JsonResponse
	 */
	public function handle($file): JsonResponse
	{
		$result = Excel::toArray(new ExcelImport($this->creatable), $file);

		DB::transaction(function() use ($result) {
			$this->data = $this->creationRoutine($result[0], $this->creatable);

			if ($this->data) {
				$this->success = true;

				if ($this->creatable === 'User') {
					$this->creator->createTeam();
				}
			}
		});

 		return response()->json([
			'success' => $this->success,
			'new_records'    => $this->data,
		], 200);
	}

	/**
	 * @return ContentCreation
	 */
	protected function defineCreator(): ContentCreation
	{
		return match ($this->creatable) {
			'User' => new PlayerCreator($this->appendable),
			'Game' => new GameCreator(),
			'Role' => new RoleCreator(),
			default => new DefaultCreator(),
		};
	}

	/**
	 * @param  array  $input_data
	 * @return Model|ModelNotFoundException|null
	 */
	public function defineModel(array $input_data): Model|ModelNotFoundException|null
	{
		if (!$input_data['appendable']) {
			return null;
		}

		return GetModelService::getModel($input_data['appendable'], $input_data['appendable_id']);
	}
}