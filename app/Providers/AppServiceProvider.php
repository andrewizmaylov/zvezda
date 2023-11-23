<?php

namespace App\Providers;
use App\Contracts\ContentCreatorInterface;
use App\Enums\FileDisksEnum;
use App\Services\ContentCreation\ContentCreator;
use App\Services\FileStorage\Contracts\FileStorageInterface;
use App\Services\FileStorage\FileStorage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
		$this->app->bind(FileStorageInterface::class, function () {
			return new FileStorage(FileDisksEnum::getDefinedStorage());
	    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
