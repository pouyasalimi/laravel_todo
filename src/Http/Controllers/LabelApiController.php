<?php

namespace Psli\Todo\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Psli\Todo\Contracts\LabelRepositoryInterface;
use Psli\Todo\Http\Requests\LabelStoreRequest;
use Psli\Todo\Http\Resources\LabelApiResource;

class LabelApiController extends Controller
{
    private LabelRepositoryInterface $labelService;

    public function __construct(LabelRepositoryInterface $labelService)
    {
        $this->labelService = $labelService;
    }

    public function index(): AnonymousResourceCollection
    {
        $result = $this->labelService->paginate();
        return LabelApiResource::collection($result);
    }

    public function store(LabelStoreRequest $request): LabelApiResource
    {
        $result = $this->labelService->create($request->validated());
        return new LabelApiResource($result);
    }
}
