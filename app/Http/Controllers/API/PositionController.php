<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Http\Resources\PositionResource;
use App\Models\Position;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PositionController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return PositionResource::collection(Position::latest()->paginate(10));
    }

    public function store(PositionRequest $request): PositionResource|\Illuminate\Http\JsonResponse
    {
        try {
            $position = Position::create($request->validated());
            return new PositionResource($position);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Position $position): PositionResource
    {
        return PositionResource::make($position);
    }

    public function update(PositionRequest $request, Position $position): PositionResource|\Illuminate\Http\JsonResponse
    {
        try {
            $position->update($request->validated());
            return new PositionResource($position);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Position $position): \Illuminate\Http\JsonResponse
    {
        try {
            $position->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
