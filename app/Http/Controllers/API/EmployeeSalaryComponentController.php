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
        $resource = $employee->salary_components()->with('component')->get();
        return EmployeeSalaryComponentResource::collection($resource);
    }

    public function store(EmployeeSalaryComponentRequest $request, Employee $employee): EmployeeSalaryComponentResource|\Illuminate\Http\JsonResponse
    {
        try {
            $salary_component = $employee->salary_components()->create($request->validated());
            $salary_component->load('component');
            return new EmployeeSalaryComponentResource($salary_component);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function batchStore(EmployeeSalaryComponentBatchRequest $request, Employee $employee)
    {
        try {
            $input = $request->validated();
            $employee->salary_components()->upsert($input['salary_components'], ['employee_id', 'salary_component_id'], ['amount']);
            $employee->load('salary_components.component');
            return EmployeeSalaryComponentResource::collection($employee->salary_components);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Employee $employee, EmployeeSalaryComponent $salary_component): EmployeeSalaryComponentResource
    {
        $salary_component->load('component');
        return EmployeeSalaryComponentResource::make($salary_component);
    }

    public function update(EmployeeSalaryComponentRequest $request, Employee $employee, EmployeeSalaryComponent $salary_component): EmployeeSalaryComponentResource|\Illuminate\Http\JsonResponse
    {
        try {
            $salary_component->update($request->validated());
            $salary_component->load('component');
            return new EmployeeSalaryComponentResource($salary_component);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Employee $employee, EmployeeSalaryComponent $salary_component): \Illuminate\Http\JsonResponse
    {
        try {
            $salary_component->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
