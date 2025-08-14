<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return EmployeeResource::collection(Employee::latest()->paginate(10));
    }

    public function store(CreateEmployeeRequest $request): EmployeeResource|\Illuminate\Http\JsonResponse
    {
        try {
            $input = $request->validated();
            DB::beginTransaction();
            $employee = Employee::create($input);
            $employee->profile()->updateOrCreate([], $input['profile']);
            DB::commit();
            return new EmployeeResource($employee);
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Employee $employee): EmployeeResource
    {
        $employee->load('profile');
        return EmployeeResource::make($employee);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): EmployeeResource|\Illuminate\Http\JsonResponse
    {
        try {
            $input = $request->validated();
            DB::beginTransaction();
            $employee->update($input);
            $employee->profile()->updateOrCreate([], $input['profile']);
            DB::commit();
            return new EmployeeResource($employee);
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Employee $employee): \Illuminate\Http\JsonResponse
    {
        try {
            $employee->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
