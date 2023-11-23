<?php

namespace App\Traits;

use App\Enums\FileDisksEnum;
use App\Enums\FileSourcesEnum;
use Illuminate\Support\Facades\Storage;

trait HasImageTrait
{
	/**
	 * Update the Image.
	 *
	 * @param  array  $file
	 * @return void
	 */
	public function updateField(array $file): void
	{
		$field = FileSourcesEnum::getFieldName($file['source']);

		tap($this->$field, function ($previous) use ($file, $field) {
			$this->forceFill([
				$field => $file['link']
			])->save();

			if ($previous) {
				Storage::disk($this->fileDisk())->delete($previous);
			}
		});
	}

	/**
	 * Get the disk that images should be stored on.
	 *
	 * @return string
	 */
	public function fileDisk(): string
	{
		return isset($_ENV['FILE_SERVICE']) ? FileDisksEnum::getDefinedStorage() : 'public';
	}

	/**
	 * Delete the user's profile photo.
	 *
	 * @param $file
	 * @return void
	 */
	public function deleteField($file): void
	{
		Storage::disk($this->fileDisk())->delete($file->link);

		$this->forceFill([
			FileSourcesEnum::getFieldName($file->source) => null,
		])->save();
	}


	/**
	 * @return string
	 */
	public function getProfilePhotoUrlAttribute(): string
	{
		$file = $this->profile_photo_path ?? FileSourcesEnum::getDefault(4);
		return $this->profile_photo_path ?
			Storage::disk($this->fileDisk())->url($file) : $file;
	}

	/**
	 * Get the URL to the user's profile photo.
	 *
	 * @return string
	 */
	public function getLogoUrlAttribute(): ?string
	{
		$file = $this->logo ?? FileSourcesEnum::getDefault(2);
		return $this->logo ?
			Storage::disk($this->fileDisk())->url($file) : null;
	}

	public function getImageUrlAttribute(): ?string
	{
		return $this->image
			? Storage::disk($this->fileDisk())->url($this->image)
			: null;
	}

	public function getBannerUrlAttribute(): ?string
	{
		return $this->banner
			? Storage::disk($this->fileDisk())->url($this->banner)
			: null;
	}

}
