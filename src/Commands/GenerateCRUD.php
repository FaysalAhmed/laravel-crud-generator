<?php

namespace CRUDGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class GenerateCRUD extends Command
{
    protected $signature = 'generate:crud {entity}';
    protected $description = 'Generate CRUD files for a given entity';

    public function handle()
    {
        $entity = $this->argument('entity');
        $routeFile = $this->option('route')?: "{$entity}.php";

        Artisan::call('make:controller',[
            'name' => "{$entity}Controller"
        ]);

        Artisan::call('make:model',[
            'name'=> $entity,
            '--migration'=>true,
        ]);

        $this->generateViews($entity);

        Artisan::call('make:request',[
            'name'=>"{$entity}Request",
        ]);

        $this->generateRouteFile($entity,$routeFile);

        $this->info("CRUD files for {$entity} generated successfully");
    }

    protected function generateViews($entity)
    {
        $viewsPath = resource_path("views/{$entity}");

        if(!File::exists($viewsPath)){
            File::makeDirectory($viewsPath);
        }

        foreach(['create','edit','index','show'] as $view){
            $viewFile = "{$viewsPath}/{$view}.blade.php";
            if(!File::exists($viewFile)){
                File::put($viewFile,'<!--'.ucfirst($view).' view for '. $entity . '-->');
            }
        }
    }

    protected function generateRouteFile($entity, $routeFile)
    {
        $routeFileContents = <<<PHP
<?php
use Illumicate\Support\Facades\Route;
Route::resource('{$entity}','{$entity}Controller');
PHP;
        $routePath = base_path("routes/{$routeFile}");
        if(!File::exists($routePath)){
            File::put($routePath, $routeFileContents);
            $this->info("Route File '{$routeFile}' created successfully");
        }else{
            $this->error("Route file '{$routeFile}' already exists");
        }
    }
}