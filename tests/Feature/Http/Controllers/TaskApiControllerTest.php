<?php

namespace Psli\Todo\Tests\Feature\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Psli\Todo\Models\UserTask;
use Psli\Todo\Notifications\TaskStatusChangedNotification;
use Psli\Todo\Tests\TestCase;

/**
 * @see \Psli\Todo\Http\Controllers\UserTaskApiController
 */
class TaskApiControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_store_new_task()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->users->first()->token)
            ->json('post', route('api.todos.tasks.store'), [
                'title' => $this->faker->name(),
                'description' => $this->faker->text(),
                'status' => 'open'
            ]);

        $response->assertStatus(201);
    }

    public function test_edit_user_task()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->users->first()->token)
            ->json('put', route('api.todos.tasks.update', ['id' => $this->userTasks->first()->id]), [
                'title' => $this->faker->name(),
                'description' => $this->faker->text(),
            ]);

        $response->assertStatus(200);
    }

    public function test_change_status_of_task()
    {
        Notification::fake();

        $status = $this->userTasks->first()->status == 'open' ? 'close' : 'open';
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->users->first()->token)
            ->json('put', route('api.todos.tasks.status', ['id' => $this->userTasks->first()->id]), [
                'status' => $status,
            ]);

        $task = $this->userTasks->first();

        if ($response['data']['status'] == 'close') {
            Notification::assertSentTo(
                $task->user,
                TaskStatusChangedNotification::class,
                function ($notification) use ($task) {
                    return $notification->task->is($task);
                });
        }

        $this->assertEquals($response['data']['status'], $status);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' =>  array_keys((new UserTask())->toArray())
                ]
            ]);
    }

    public function test_add_label_to_a_task()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->users->first()->token)
            ->json('post', route('api.todos.tasks.attach.label.to.task'), [
                'task_id' => $this->userTasks->first()->id,
                'label_id' => $this->labels->first()->id,
            ]);
        $response->assertStatus(200);
    }

    public function test_get_details_of_my_task()
    {
        $labelTaskUser = DB::table('label_user_task')
            ->where('user_task_id', $this->users->first()->id)
            ->where('label_id', $this->labels->first()->id)
            ->inRandomOrder()
            ->first();

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->users->first()->token)
            ->json('get', route('api.todos.tasks.show', ['id' => $labelTaskUser->user_task_id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' =>  array_keys((new UserTask())->toArray())
                ]
            ]);
    }

    public function test_get_details_of_other_user_task()
    {
        $labelTaskUser = DB::table('label_user_task')
            ->where('user_task_id', $this->users->first()->id)
            ->where('label_id', $this->labels->first()->id)
            ->inRandomOrder()
            ->first();

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->users->last()->token)
            ->json('get', route('api.todos.tasks.show', ['id' => $labelTaskUser->user_task_id]));

        $response->assertStatus(403);
    }
}
