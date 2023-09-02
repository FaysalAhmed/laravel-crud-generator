<?php
namespace CRUDGenerator;

use Illuminate\Support\ServiceProvider;

class CRUDGeneratorServiceProvider extends ServiceProvider
{
    public function boot()
    {


    }

    public function register()
    {
        $this->commands([
            Commands\GenerateCRUD::class,
        ]);
    }
}