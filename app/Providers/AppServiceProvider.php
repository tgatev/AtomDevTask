<?php

namespace App\Providers;

use App\Grids\LibrariesGrid;
use App\Grids\LibrariesGridInterface;
use Illuminate\Support\ServiceProvider;
use App\Grids\BooksGrid;
use App\Grids\BooksGridInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(BooksGridInterface::class, BooksGrid::class);
        $this->app->bind(LibrariesGridInterface::class, LibrariesGrid::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
