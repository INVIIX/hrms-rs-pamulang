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
        return EmployeeTrainingResource::collection($employee->trainings()->latest()->paginate(10));
    }

    public function store(EmployeeTrainingRequest $request, Employee $employee): EmployeeTrainingResource|\Illuminate\Http\JsonResponse
    {
        try {
            $input = $request->validated();
            if ($request->hasFile('certificate_path')) {
                $input['certificate_path'] = $request->file('certificate_path')->store('certificates');
            } else {
                unset($input['certificate_path']);
            }
            $training = $employee->trainings()->create($input);
            return new EmployeeTrainingResource($training);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Employee $employee, EmployeeTraining $training): EmployeeTrainingResource
    {
        return EmployeeTrainingResource::make($training);
    }

    public function update(EmployeeTrainingRequest $request, Employee $employee, EmployeeTraining $training): EmployeeTrainingResource|\Illuminate\Http\JsonResponse
    {
        try {
            $input = $request->validated();
            if ($request->hasFile('certificate_path')) {
                $input['certificate_path'] = $request->file('certificate_path')->store('certificates');
            } else {
                unset($input['certificate_path']);
            }
            $training->update($input);
            return new EmployeeTrainingResource($training);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Employee $employee, EmployeeTraining $training): \Illuminate\Http\JsonResponse
    {
        try {
            $training->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
