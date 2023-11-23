<?php

namespace App\Services\FileStorage\Contracts;

use App\Exceptions\FileStorageException;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileStorageInterface
{
	/**
	 * @param  UploadedFile  $file
	 * @param  string  $dir
	 * @return string
	 */
	public function save(UploadedFile $file, string $dir): string;

	/**
	 * @param  UploadedFile  $file
	 * @return string
	 */
	public function saveTmp(UploadedFile $file): string;

	/**
	 * @param  File  $file
	 * @param  string  $dir
	 * @return File
	 */
	public function move(File $file, string $dir): File;

	/**
	 * @param  File  $file
	 * @param  string  $dir
	 * @return File
	 * @throws FileStorageException
	 */
	public function moveFromTmp(File $file, string $dir): File;

	/**
	 * @param  Collection  $files
	 * @param  string  $dir
	 * @return Collection
	 * @throws FileStorageException
	 */
	public function moveAllFromTmp(Collection $files, string $dir): Collection;

	/**
	 * @param  File  $file
	 * @return bool
	 * @throws FileStorageException
	 */
	public function delete(File $file): bool;

	/**
	 * @param  File  $file
	 * @return string
	 */
	public function getUrl(File $file): string;

	/**
	 * @param  File  $file
	 * @param  string|null  $fileName
	 * @return StreamedResponse
	 */
	public function download(File $file, ?string $fileName = null): StreamedResponse;

	/**
	 * @return string
	 */
	public function getDiskName(): string;
}