<?php

namespace Psli\Todo\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Psli\Todo\Models\Label;
use Psli\Todo\Models\UserTask;
use Illuminate\Foundation\Auth\User;
use Psli\Todo\TodoPackageServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected $users;
    protected $userTasks;
    protected $labels;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testbench'])->run();

        $this->users = factory(User::class, 3)->create();
        $this->userTasks = factory(UserTask::class, 10)->create(['user_id' => $this->users->first()->id]);
        $this->userTasks = factory(UserTask::class, 5)->create(['user_id' => $this->users->last()->id]);
        $this->labels = factory(Label::class, 10)->create();

        $this->labels->each(function ($item) {
            $item->tasks()->attach(UserTask::first()->id);
            $item->tasks()->attach(UserTask::find(2)->id);
        });
    }

    protected function getPackageProviders($app): array
    {
        return [
            TodoPackageServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        include_once __DIR__ . '/../database/migrations/create_users_table.php.stub';
        include_once __DIR__ . '/../database/migrations/create_label_user_task_table.php.stub';
        include_once __DIR__ . '/../database/migrations/create_labels_table.php.stub';
        include_once __DIR__ . '/../database/migrations/create_user_tasks_table.php.stub';

        (new \CreateUsersTable)->up();
        (new \CreateLabelUserTaskTable)->up();
        (new \CreateLabelsTable)->up();
        (new \CreateUserTasksTable)->up();
    }
}
