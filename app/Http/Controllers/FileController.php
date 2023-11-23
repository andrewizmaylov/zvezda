<?php

namespace App\Http\Controllers;

use App\Exceptions\FileStorageException;
use App\Models\File;
use App\Services\FileStorage\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
	/**
	 * @param  Request  $request
	 * @return JsonResponse
	 * @throws \Exception
	 */
	public function uploadTmp(Request $request): JsonResponse
	{
		$file = $request->file('file');

		if (!$file) {
			throw new \Exception(__('app.no_file'));
		}

		if (!$request->source) {
			throw new \Exception(__('app.no_source'));
		}

		$fileModel = (new FileUploadService($request->source))->saveFile($file);

		return \response()->json([
			'success' => true,
			'file'    => $fileModel,
		]);
	}

	/**
	 * @param  Request  $request
	 * @param  File  $file
	 * @return JsonResponse
	 * @throws FileStorageException
	 * @throws \Throwable
	 */
	public function delete(Request $request, File $file): JsonResponse
	{
		$uploader = new FileUploadService($file->source);
		$storageDeleteStatus = $uploader->deleteFile($file);

		if (!$storageDeleteStatus) {
			throw new \RuntimeException(__("app.file_not_deleted", ['id' => $file->id]));
		}

		if (!$file->delete()) {
			throw new \RuntimeException(__("app.file_not_deleted_bd", ['id' => $file->id]));
		}

		return \response()->json([
			'success' => true,
			'message' => $storageDeleteStatus
		]);
	}

	/**
	 * @param  Request  $request
	 * @return JsonResponse|string
	 * @throws \Throwable
	 */
	public function uploadByUrl(Request $request): JsonResponse|string
	{
		if (!$request->source) {
			throw new \Exception(__('app.no_source'));
		}

		$uploader = new FileUploadService($request->source);
		$fileModel = $uploader->createFromUrl($request->url);

		return \response()->json([
			'success' => true,
			'file'    => [
				'link' => $fileModel->link
			],
		]);
	}
}
