<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerformanceIndicatorRequest;
use App\Http\Resources\PerformanceIndicatorResource;
use App\Models\PerformanceIndicator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PerformanceIndicatorController extends Controller
{
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return PerformanceIndicatorResource::collection(PerformanceIndicator::latest()->paginate(10));
    }

    public function store(PerformanceIndicatorRequest $request): PerformanceIndicatorResource|\Illuminate\Http\JsonResponse
    {
        $input = $request->validated();
        try {
            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('kpi');
                $input['attachment'] = $path;
                $performance_indicator = PerformanceIndicator::updateOrCreate([], $input);
                return new PerformanceIndicatorResource($performance_indicator);
            }
            return response()->json(['error' => 'No file attachment'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(PerformanceIndicator $performance_indicator): PerformanceIndicatorResource
    {
        return PerformanceIndicatorResource::make($performance_indicator);
    }

    public function update(PerformanceIndicatorRequest $request, PerformanceIndicator $performance_indicator): PerformanceIndicatorResource|\Illuminate\Http\JsonResponse
    {
        $input = $request->validated();
        try {
            if ($request->hasFile('attachment')) {
                $input['attachment'] = $request->file('attachment')->store('kpi');
            }
            $performance_indicator->update($input);
            return new PerformanceIndicatorResource($performance_indicator);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(PerformanceIndicator $performance_indicator): \Illuminate\Http\JsonResponse
    {
        try {
            $performance_indicator->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
