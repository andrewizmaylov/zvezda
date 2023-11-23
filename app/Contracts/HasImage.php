<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;

interface HasImage
{
	public function updateProfilePhoto(UploadedFile $photo, $storagePath = 'profile-photos');

	/**
	 * Delete the user's profile photo.
	 *
	 * @return void
	 */
	public function deleteProfilePhoto();

	/**
	 * Get the URL to the user's profile photo.
	 *
	 * @return \Illuminate\Database\Eloquent\Casts\Attribute
	 */
	public function profilePhotoUrl(): Attribute;

	/**
	 * Get the default profile photo URL if no profile photo has been uploaded.
	 *
	 * @return string
	 */
	public function defaultProfilePhotoUrl();
}