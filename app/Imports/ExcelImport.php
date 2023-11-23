<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ExcelImport implements ToArray, WithHeadingRow
{

	private string $model;

	public function __construct($model)
	{
		$this->model = '\\App\\Models\\' . $model;
	}

	public function array(array $array)
	{
		return new $this->model();
	}
}