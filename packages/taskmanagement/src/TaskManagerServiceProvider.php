<?php

namespace MusaFormazione\TaskManager;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use MusaFormazione\TaskManager\Services\TaskService;

class TaskManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        // register viene invocato in fase di avvio del framework e non si può supporre che tutti i servizi siano già stati caricati

        // caricamento configurazione
        $this->mergeConfigFrom($this->packagePath('config/taskmanager.php'), 'taskmanager');

        // caricamento delle migrations
//        $this->loadMigrationsFrom($this->packagePath('database/migrations/create_tasks_table.php'));

        // caricamento delle rotte
        $this->loadRoutesFrom($this->packagePath('routes/web.php'));

        // caricamento delle viste
        $this->loadViewsFrom($this->packagePath('resources/views'), 'tasks');

        $this->app->bind(
            'task-manager',
            TaskService::class,
        );

    }

    protected function packagePath(string $path)
    {
        return __DIR__ . "/../{$path}";
    }

    public function boot()
    {
        // all'interno di boot tutti i servizi sono già stati caricati

        // metodo preferibile per il publishing delle migrations
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        // caricamento alias facade
//        $loader = AliasLoader::getInstance();
//        $loader->alias('TaskManager', MusaFormazione\TaskManager\Facades\TaskManager::class);
    }

    private function bootForConsole()
    {
        $this->publishes([
            $this->packagePath('database/migrations/create_tasks_table.php.stub') =>
                database_path('migrations/' . date('Y_m_d_His') . '_create_tasks_table.php')
        ], 'tasks-migrations');

        $this->publishes([
            $this->packagePath('resources/views') => resource_path('views/vendor/tasks')
        ], 'tasks-views');

        AboutCommand::add('Tasks package', function() {
            return [
                'Version' => '1.0.0',
                'Author' => 'Musa Formazione',
                'Description' => 'Simple task management',
            ];
        });

    }
}
