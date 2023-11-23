<?php

namespace App\Enums;

class FileDisksEnum
{
    public const YANDEX = 'yandex';
    public const AWS = 's3';
    public const LOCAL = 'local';
    public const PUBLIC = 'public';


	public static function getDefinedStorage(): string
	{
		return env('FILE_SERVICE');
	}
}
