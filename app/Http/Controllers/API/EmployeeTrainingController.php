<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeTrainingRequest;
use App\Http\Resources\EmployeeTrainingResource;
use App\Models\Employee;
use App\Models\EmployeeTraining;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeTrainingController extends Controller
{
    public function index(Employee $employee): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return EmployeeTrainingResource::collection(EmployeeTraining::latest()->paginate(10));
    }

    public function store(EmployeeTrainingRequest $request, Employee $employee): EmployeeTrainingResource|\Illuminate\Http\JsonResponse
    {
        try {
            $employeeTraining = EmployeeTraining::create($request->validated());
            return new EmployeeTrainingResource($employeeTraining);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Employee $employee, EmployeeTraining $employeeTraining ): EmployeeTrainingResource
    {
        return EmployeeTrainingResource::make($employeeTraining);
    }

    public function update(EmployeeTrainingRequest $request, Employee $employee, EmployeeTraining $employeeTraining): EmployeeTrainingResource|\Illuminate\Http\JsonResponse
    {
        try {
            $employeeTraining->update($request->validated());
            return new EmployeeTrainingResource($employeeTraining);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Employee $employee, EmployeeTraining $employeeTraining): \Illuminate\Http\JsonResponse
    {
        try {
            $employeeTraining->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
