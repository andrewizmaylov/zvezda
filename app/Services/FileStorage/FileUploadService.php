<?php

namespace App\Services\FileStorage;

use App\Enums\FileDisksEnum;
use App\Enums\FileSourcesEnum;
use App\Exceptions\FileStorageException;
use App\Exceptions\FileUploadException;
use App\Models\File;
use App\Services\FileStorage\Contracts\FileUploadServiceInterface;
use Illuminate\Foundation\Application;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileUploadService implements FileUploadServiceInterface
{
	private int $destination;
	private string $disk;

	public function __construct(int $destination)
	{
		$this->destination = $destination;
		$this->disk = FileDisksEnum::getDefinedStorage();
	}


	/**
	 * @param  string  $url
	 * @return File
	 * @throws \Throwable
	 */
	public function createFromUrl(string $url): File
	{
		$imageContent = @file_get_contents($url);
		if ($imageContent === false) {
			throw new FileUploadException("Failed to download image from URL.");
		}

		$tempFilePath = tempnam(sys_get_temp_dir(), 'image');
		file_put_contents($tempFilePath, $imageContent);
		$originalName = basename(parse_url($url, PHP_URL_PATH));
		$mimeType = mime_content_type($tempFilePath);

		// Create an UploadedFile object from the temporary file
		$uploadedFile = new UploadedFile(
			$tempFilePath,
			$originalName,
			$mimeType,
			null,
			true // Indicates file is "test", not from actual HTTP request
		);

		DB::beginTransaction();
		try {
			$fileModel = $this->saveFile($uploadedFile);
			DB::commit();
			return $fileModel;
		} catch (FileUploadException $exception) {
			DB::rollBack();
			Log::error($exception->getMessage());
			throw $exception;
		} finally {
			// Ensure the temporary file is deleted whether the try block succeeds or not
			@unlink($tempFilePath);
		}
	}

	/**
	 * Handle the process of storing a file and creating its database record.
	 *
	 * @param  UploadedFile  $file
	 * @return File
	 */
	public function saveFile(UploadedFile $file): File
	{
		$storedFilePath = $this->storeFile($file);

		return $this->createFileRecord($file, $storedFilePath);
	}

	/**
	 * Store the file on the disk.
	 *
	 * @param  UploadedFile  $file
	 * @return string The path to the stored file.
	 */
	protected function storeFile(UploadedFile $file): string
	{
		$visibility = $this->disk === 'yandex' ? 'public' : null;
		$filePath = Storage::disk($this->disk)->put(
			FileSourcesEnum::getFieldName($this->destination),
			$file,
			$visibility
		);

		return $filePath;
	}

	/**
	 * Save the file record in the database.
	 *
	 * @param  UploadedFile  $file
	 * @param  string  $link
	 * @return File
	 */
	protected function createFileRecord(UploadedFile $file, string $link): File
	{
		return File::create([
			'link'      => $link,
			'file_name' => $file->getClientOriginalName(),
			'extension' => $file->getClientOriginalExtension(),
			'file_size' => $file->getSize(),
			'disk'      => $this->disk,
			'source'    => $this->destination,
			'user_id'   => auth()->id(),
		]);
	}

	/**
	 * Delete a file from storage and its database record.
	 *
	 * @param  File  $file  An instance of the File model.
	 * @return string Message response.
	 * @throws FileStorageException|\Throwable If the file does not exist or the transaction fails.
	 */
	public function deleteFile(File $file): string
	{
		if (!Storage::disk($this->disk)->exists($file->link)) {
			throw new FileStorageException("File with id {$file->id} does not exist.");
		}

		DB::beginTransaction();

		try {
			$file->delete();
			Storage::disk($this->disk)->delete($file->link);
			DB::commit();

			return "File with id {$file->id} has been successfully deleted.";
		} catch (\Exception $exception) {
			DB::rollBack();
			// You could log the exception here if needed
			throw new FileStorageException("Failed to delete file with id {$file->id}: {$exception->getMessage()}");
		}
	}
}