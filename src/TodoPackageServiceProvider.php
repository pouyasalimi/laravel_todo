<?php

namespace Psli\Todo;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Psli\Todo\Contracts\LabelRepositoryInterface;
use Psli\Todo\Contracts\UserTaskRepositoryInterface;
use Psli\Todo\Http\Middleware\TodoAuthenticate;
use Psli\Todo\Models\UserTask;
use Psli\Todo\Observers\UserTaskObserver;
use Psli\Todo\Repositories\LabelRepository;
use Psli\Todo\Repositories\UserTaskRepository;

class TodoPackageServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(LabelRepositoryInterface::class, LabelRepository::class);
        $this->app->bind(UserTaskRepositoryInterface::class, UserTaskRepository::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../database/factories');

        $this->publishes([
            __DIR__ . '/../database/migrations/create_user_tasks_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_user_tasks_table.php'),
            __DIR__ . '/../database/migrations/create_labels_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_labels_table.php'),
            __DIR__ . '/../database/migrations/create_label_user_task_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_label_user_task_table.php'),
        ], 'migrations');


        $this->app->make(Router::class)->aliasMiddleware('auth.todo', TodoAuthenticate::class);
        UserTask::observe(UserTaskObserver::class);


        Builder::macro('routeNotificationFor', function ($driver, $notification = null) {
            $model = $this->getModel();
            if ($model instanceof User) {
                switch ($driver) {
                    case 'database':
                        return $model->notifications();
                    case 'mail':
                        return $model->email;
                }
            }
            unset(static::$macros['routeNotificationFor']);
        });
    }
}
