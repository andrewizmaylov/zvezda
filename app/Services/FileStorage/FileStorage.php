<?php

namespace App\Services\FileStorage;

use App\Enums\FileDisksEnum;
use App\Models\File;
use App\Services\FileStorage\Contracts\FileStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Exceptions\FileStorageException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileStorage implements FileStorageInterface
{
	public const TMP_DIR = 'tmp';

	public string $disk;

	/**
	 * string $disk
	 */
	public function __construct(string $disk)
	{
		$this->disk = $disk;
	}

	/**
     * @param UploadedFile $file
     * @param string $dir
     * @return string
     */
	public function save(UploadedFile $file, string $dir): string
	{
		if (FileDisksEnum::getDefinedStorage() === 'yandex') {
			return Storage::disk($this->disk)->put(
				$this->toUploadDir($dir),
				$file,
				'public',
			);
		}

		return Storage::disk($this->disk)->put(
			$this->toUploadDir($dir),
			$file
		);
	}
    /**
     * @param UploadedFile $file
     * @return string
     */
	public function saveTmp(UploadedFile $file): string
	{
		// Тут не нужно указывать uploadDir, так как это делается в методе save
		return $this->save($file, self::TMP_DIR);
	}

	/**
	 * @param  File  $file
	 * @param  string  $dir
	 * @return File
	 * @throws FileStorageException
	 */
	public function move(File $file, string $dir): File
	{
		$dir = $this->toUploadDir($dir);

		$fileExplode = explode('/', $file->link);
		$fileName = $fileExplode[count($fileExplode) - 1];
		$newLink = $dir.'/'.$fileName;

		if (!Str::startsWith($file->link, $this->getUploadDir().'/')) {
			throw new FileStorageException("Вы не можете перемещать файлы из этой директории");
		}

		if (!Storage::disk($this->disk)->exists($file->link)) {
			throw new FileStorageException("Файл c id {$file->id} не существует");
		}

		$status = Storage::disk($this->disk)->move($file->link, $newLink);

		if (!$status) {
			throw new FileStorageException("Файл c id {$file->id} не перемещен.");
		}

		$file->update(['link' => $newLink]);

		return $file;
	}
    /**
     * @param File $file
     * @param string $dir
     * @return File
     * @throws FileStorageException
     */
	public function moveFromTmp(File $file, string $dir): File
	{
		$tmpDir = $this->toUploadDir(self::TMP_DIR);

		if (!$this->checkDirInLink($file->link, $tmpDir)) {
			throw new FileStorageException("Файл c id {$file->id} не храниться в директории ".$tmpDir);
		}

		// Тут не нужно указывать uploadDir, так как это делается в методе move
		return $this->move($file, $dir);
	}
    /**
     * @param Collection $files
     * @param string $dir
     * @return Collection
     * @throws FileStorageException
     */
	public function moveAllFromTmp(Collection $files, string $dir): Collection
	{
		$tmpDir = $this->toUploadDir(self::TMP_DIR);

		foreach ($files as $file) {
			if (!$this->checkDirInLink($file->link, $tmpDir)) {
				throw new FileStorageException("Файл с id {$file->id} не храниться в директории ".$tmpDir);
			}

			if (!Storage::disk($this->disk)->exists($file->link)) {
				throw new FileStorageException("Файл с id {$file->id} не существует");
			}
		}

		foreach ($files as $file) {
			// Тут не нужно указывать uploadDir, так как это делается в методе move
			$this->move($file, $dir);
		}

		return $files;
	}
    /**
     * @param File $file
     * @return bool
     * @throws FileStorageException
     */
	public function delete(File $file): bool
	{
		if (!Str::startsWith($file->link, $this->getUploadDir().'/')) {
			throw new FileStorageException("Вы не можете удалять файлы из этой директории");
		}

		if (!Storage::disk($this->disk)->exists($file->link)) {
			throw new FileStorageException("Файл c id {$file->id} не существует");
		}

		return Storage::disk($this->disk)->delete($file->link);
	}
    /**
     * @param File $file
     * @return string
     */
	public function getUrl(File $file): string
	{
		return Storage::disk($this->disk)->url($file->link);
	}
    /**
     * @param File $file
     * @param string|null $fileName
     * @return StreamedResponse
     */
	public function download(File $file, ?string $fileName = null): StreamedResponse
	{
		return Storage::disk($this->disk)->download($file->link, $fileName ?? $file->file_name);
	}
    /**
     * @return string
     */
	public function getDiskName(): string
	{
		return $this->disk;
	}
    /**
     * @param string $dir
     * @return string
     */
    protected function toUploadDir(string $dir): string
    {
        return $this->getUploadDir() . '/' . $dir;
    }

    /**
     * @return string
     */
    protected function getUploadDir(): string
    {
        return (config('filesystems.upload_file') ?? 'local');
    }

	/**
	 * @param  string  $link
	 * @param  string  $checkDir
	 * @return bool
	 */
	private function checkDirInLink(string $link, string $checkDir): bool
	{
		$fileExplode = explode('/', $link);
		$fileDir = '';

		// не учитываем имя файла
		for ($i = 0; $i < count($fileExplode) - 1; $i++) {
			$dir = $fileExplode[$i];

			if (trim($dir) !== '') {
				$fileDir .= $fileDir === '' ? $dir : '/'.$dir;
			}
		}

		return $fileDir === $checkDir;
	}
}
