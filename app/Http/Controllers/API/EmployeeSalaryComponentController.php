<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeSalaryComponentBatchRequest;
use App\Http\Requests\EmployeeSalaryComponentRequest;
use App\Http\Resources\EmployeeSalaryComponentResource;
use App\Models\Employee;
use App\Models\EmployeeSalaryComponent;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeSalaryComponentController extends Controller
{
    public function index(Employee $employee): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return EmployeeSalaryComponentResource::collection(EmployeeSalaryComponent::latest()->paginate(10));
    }

    public function store(EmployeeSalaryComponentRequest $request, Employee $employee): EmployeeSalaryComponentResource|\Illuminate\Http\JsonResponse
    {
        try {
            $employeeSalaryComponent = $employee->salary_components()->create($request->validated());
            return new EmployeeSalaryComponentResource($employeeSalaryComponent);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function batchStore(EmployeeSalaryComponentBatchRequest $request, Employee $employee): EmployeeSalaryComponentResource|\Illuminate\Http\JsonResponse
    {
        try {
            $input = $request->validated();
            $employeeSalaryComponent = $employee->salary_components()->upsert($input['salary_components'], ['employee_id', 'salarty_component_id'], ['amount']);
            return new EmployeeSalaryComponentResource($employeeSalaryComponent);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Employee $employee, EmployeeSalaryComponent $employeeSalaryComponent): EmployeeSalaryComponentResource
    {
        return EmployeeSalaryComponentResource::make($employeeSalaryComponent);
    }

    public function update(EmployeeSalaryComponentRequest $request, Employee $employee, EmployeeSalaryComponent $employeeSalaryComponent): EmployeeSalaryComponentResource|\Illuminate\Http\JsonResponse
    {
        try {
            $employeeSalaryComponent->update($request->validated());
            return new EmployeeSalaryComponentResource($employeeSalaryComponent);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Employee $employee, EmployeeSalaryComponent $employeeSalaryComponent): \Illuminate\Http\JsonResponse
    {
        try {
            $employeeSalaryComponent->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
