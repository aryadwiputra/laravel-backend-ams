<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    protected function registerRepositories(): void
    {
        $repositoriesPath = app_path('Repositories'); // Direktori tempat repository Anda berada

        // Loop melalui semua direktori di dalam direktori Repositories
        foreach (File::directories($repositoriesPath) as $directory) {
            $namespace = 'App\\Repositories\\' . basename($directory); // Namespace untuk direktori ini

            // Loop melalui semua file PHP di dalam direktori
            foreach (File::allFiles($directory) as $file) {
                $filename = $file->getFilenameWithoutExtension();

                // Cek apakah nama file berakhiran "Interface"
                if (str_ends_with($filename, 'Interface')) {
                    $interface = $namespace . '\\' . $filename;
                    $repository = str_replace('Interface', '', $interface); // Hilangkan "Interface" untuk mendapatkan nama repository

                    // Pastikan class repository ada sebelum melakukan binding
                    if (class_exists($repository)) {
                        $this->app->bind($interface, $repository);
                    }
                }
            }
        }
    }
}