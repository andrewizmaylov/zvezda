<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileInformationController extends Controller
{
	protected object $user;
	protected array $data = [];
	protected string $message = 'Nothing to update';


	public function __construct()
	{
		$this->middleware(function ($request, $next) {
			$this->user = auth()->user();
			return $next($request);
		});
	}

	/**
	 * @param  Request  $request
	 * @return void
	 */
	public function updateEmailAndPhoto(Request $request): void
	{

		if ($this->user->email !== $request->email) {
			$this->data['email'] = $request->email;
		}

		if ($request->file) {
			$this->user->updateField($request->file);
			$this->data['profile_photo_path'] = $request->file['link'];
		}

		$this->updateData();
	}

	/**
	 * @return void
	 */
	public function deleteUserPhoto(): void
	{
		$file = File::where('link', $this->user->profile_photo_path)->first();

		if (!$file) {
			$this->message = 'No file to delete';
		}
		DB::transaction(function () use ($file) {
			$this->user->deleteField($file);
			$this->message = "File with id $file->id and link $file->link was successfully deleted";

			$file->delete();
		});

		$this->updateData();
	}

	/**
	 * @return RedirectResponse
	 */
	public function updateData(): RedirectResponse
	{
		if (count($this->data) > 0) {
			User::where('email', auth()->user()->email)->update($this->data);

			$this->message = 'Updated: ';
			foreach ($this->data as $key => $value) {
				$this->message .= $key.', ';
			}
		}

		return back()->with('message', $this->message);
	}

}
