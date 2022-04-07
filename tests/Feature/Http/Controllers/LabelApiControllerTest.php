<?php

namespace Psli\Todo\Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use JMac\Testing\Traits\AdditionalAssertions;
use Psli\Todo\Models\UserTask;
use Psli\Todo\Tests\TestCase;

/**
 * @see \Psli\Todo\Http\Controllers\LabelApiController
 */
class LabelApiControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_store_label()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->users->first()->token)
            ->json('post', route('api.todos.labels.store'), [
                'label' => 'Developer'
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'label' => 'Developer',
            ]);
    }

    public function test_store_just_unique_label()
    {
        $this->withHeader('Authorization', 'Bearer ' . $this->users->first()->token)
            ->json('post', route('api.todos.labels.store'), [
                'label' => 'Backend'
            ]);

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->users->first()->token)
            ->json('post', route('api.todos.labels.store'), [
                'label' => 'Backend'
            ]);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    'label' => ['The label has already been taken.'],
                ]
            ]);
    }

    public function test_index_labels_with_logged_in_user_task()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->users->first()->token)
            ->json('get', route('api.todos.labels.index'));

        $userTasks = UserTask::where('user_id', request()->user->id)->with(['labels' => function ($query) {
            $query->with(['tasks' => function ($query) {
                $query->where('user_id', request()->user->id);
            }]);
        }])->get();

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $this->labels->first()->id,
                'label' => $this->labels->first()->label,
                'total_tasks' => $userTasks->first()->labels->first()->tasks->count(),
            ]);
    }

    public function test_index_labels_with_other_logged_in_user_task()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->users->last()->token)
            ->json('get', route('api.todos.labels.index'));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $this->labels->first()->id,
                'label' => $this->labels->first()->label,
                'total_tasks' => 0,
            ]);
    }
}
