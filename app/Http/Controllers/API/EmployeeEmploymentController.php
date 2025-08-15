<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeEmploymentRequest;
use App\Http\Resources\EmployeeEmploymentResource;
use App\Models\Employee;
use App\Models\EmployeeEmployment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeEmploymentController extends Controller
{
    public function index(Employee $employee): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return EmployeeEmploymentResource::collection($employee->employments()->latest()->paginate(10));
    }

    public function store(EmployeeEmploymentRequest $request, Employee $employee): EmployeeEmploymentResource|\Illuminate\Http\JsonResponse
    {
        try {
            $employment = $employee->employments()->create($request->validated());
            return new EmployeeEmploymentResource($employment);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Employee $employee, EmployeeEmployment $employment): EmployeeEmploymentResource
    {
        return EmployeeEmploymentResource::make($employment);
    }

    public function update(EmployeeEmploymentRequest $request, Employee $employee, EmployeeEmployment $employment): EmployeeEmploymentResource|\Illuminate\Http\JsonResponse
    {
        try {
            $employment->update($request->validated());
            return new EmployeeEmploymentResource($employment);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(EmployeeEmployment $employment): \Illuminate\Http\JsonResponse
    {
        try {
            $employment->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
