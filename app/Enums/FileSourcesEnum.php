<?php

namespace App\Enums;

class FileSourcesEnum
{
    public const MESSAGE_ATTACHMENT = 1;
    public const LOGO = 2;
    public const CONTENT_IMAGE = 3;
    public const PROFILE_PHOTO = 4;
    public const IMAGE = 5;
    public const BANNER = 6;

	/**
	 * @param  int  $type
	 * @return string
	 */
	public static function getFieldName(int $type): string
	{
		return [
			1 => 'file',
			2 => 'logo',
			3 => 'content_image',
			4 => 'profile_photo_path',
			5 => 'image',
			6 => 'banner',
		][$type] ?? 'file';
	}

	public static function getDefault(int $type): string
	{
		return [
			1 => '/img/empty.svg',
			2 => '/img/empty.svg',
			3 => '/img/empty.svg',
			4 => '/img/empty_user.jpeg',
			5 => '/img/empty.svg',
			6 => '/img/empty.svg',
		][$type] ?? '/img/empty.svg';
	}
}

