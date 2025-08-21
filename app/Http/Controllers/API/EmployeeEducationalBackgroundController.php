<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeEducationalBackgroundRequest;
use App\Http\Resources\EmployeeEducationalBackgroundResource;
use App\Models\Employee;
use App\Models\EmployeeEducationalBackground;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeEducationalBackgroundController extends Controller
{
    public function index(Employee $employee): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $resource = $employee->educational_backgrounds()->latest()->paginate(10);
        return EmployeeEducationalBackgroundResource::collection($resource);
    }

    public function store(EmployeeEducationalBackgroundRequest $request, Employee $employee): EmployeeEducationalBackgroundResource|\Illuminate\Http\JsonResponse
    {
        try {
            $resource = $employee->educational_backgrounds()->create($request->validated());
            return new EmployeeEducationalBackgroundResource($resource);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Employee $employee, EmployeeEducationalBackground $resource): EmployeeEducationalBackgroundResource
    {
        return EmployeeEducationalBackgroundResource::make($resource);
    }

    public function update(EmployeeEducationalBackgroundRequest $request, Employee $employee, EmployeeEducationalBackground $resource): EmployeeEducationalBackgroundResource|\Illuminate\Http\JsonResponse
    {
        try {
            $resource->update($request->validated());
            return new EmployeeEducationalBackgroundResource($resource);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Employee $employee, EmployeeEducationalBackground $resource): \Illuminate\Http\JsonResponse
    {
        try {
            $resource->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
