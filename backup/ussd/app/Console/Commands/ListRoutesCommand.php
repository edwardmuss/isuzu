<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Lumen\Application;

class ListRoutesCommand extends Command
{
    protected $signature = 'route:list';
    protected $description = 'List all registered routes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Application $app)
    {
        $routes = $app->getRoutes();
        foreach ($routes as $route) {
            $this->line(sprintf(
                "%s\t%s\t%s",
                $route['method'],
                $route['uri'],
                $route['action']['uses'] ?? 'Closure'
            ));
        }
    }
}
