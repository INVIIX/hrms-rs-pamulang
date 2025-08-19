<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return GroupResource::collection(Group::with('parent')->withDepth()->latest()->paginate(10));
    }

    public function store(GroupRequest $request): GroupResource|\Illuminate\Http\JsonResponse
    {
        try {
            $group = Group::create($request->validated());
            $group->load(['parent']);
            return new GroupResource($group);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Group $group): GroupResource
    {
        $group->load(['parent']);
        return GroupResource::make($group);
    }

    public function update(GroupRequest $request, Group $group): GroupResource|\Illuminate\Http\JsonResponse
    {
        try {
            $group->update($request->validated());
            return new GroupResource($group);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Group $group): \Illuminate\Http\JsonResponse
    {
        try {
            $group->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function tree(): JsonResource
    {
        $node = Group::withDepth()->get()->toTree();
        return new JsonResource($node);
    }
}
