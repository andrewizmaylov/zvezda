<?php

namespace App\Services\FileStorage\Contracts;

use App\Exceptions\FileStorageException;
use App\Models\File;
use Illuminate\Http\UploadedFile;

interface FileUploadServiceInterface
{
	/**
	 * @param  UploadedFile  $file
	 * @return File
	 */
	public function saveFile(UploadedFile $file): File;

	/**
	 * Delete a file from storage and its database record.
	 *
	 * @param  File  $file  An instance of the File model.
	 * @return string Message response.
	 * @throws FileStorageException|\Throwable If the file does not exist or the transaction fails.
	 */
	public function deleteFile(File $file): string;
}