<?php

namespace Psli\Todo\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Psli\Todo\Contracts\UserTaskRepositoryInterface;
use Psli\Todo\Http\Requests\UserTaskAttachRequest;
use Psli\Todo\Http\Requests\UserTaskShowRequest;
use Psli\Todo\Http\Requests\UserTaskStatusRequest;
use Psli\Todo\Http\Requests\UserTaskStoreRequest;
use Psli\Todo\Http\Requests\UserTaskUpdateRequest;
use Psli\Todo\Http\Resources\TaskApiResource;

class UserTaskApiController extends Controller
{
    private UserTaskRepositoryInterface $taskRepository;

    public function __construct(UserTaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index(): AnonymousResourceCollection
    {
        $result = $this->taskRepository->paginate();
        return TaskApiResource::collection($result);
    }

    public function store(UserTaskStoreRequest $request): TaskApiResource
    {
        $result = $this->taskRepository->create(array_merge(['user_id' => $request->user->id], $request->validated()));
        return new TaskApiResource($result);
    }

    public function update(UserTaskUpdateRequest $request, int $id): TaskApiResource
    {
        $result = $this->taskRepository->update($request->validated(), $id);
        return new TaskApiResource($result);
    }

    public function show(UserTaskShowRequest $request, int $id): TaskApiResource
    {
        $result = $this->taskRepository->find($id);
        return new TaskApiResource($result);
    }

    public function status(UserTaskStatusRequest $request, int $id): JsonResponse
    {
        $result = $this->taskRepository->status($request->validated(), $id);
        return response()->json(['data' => ['status' => $result->status]]);
    }

    public function attachLabelToTask(UserTaskAttachRequest $request): JsonResponse
    {
        $this->taskRepository->attach($request->task_id, $request->label_id);
        return response()->json(['data' => 'OK']);
    }
}
