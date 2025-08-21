<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeContactRequest;
use App\Http\Resources\EmployeeContactResource;
use App\Models\Employee;
use App\Models\EmployeeContact;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeContactController extends Controller
{
    public function index(Employee $employee): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return EmployeeContactResource::collection($employee->contacts()->latest()->paginate(10));
    }

    public function store(EmployeeContactRequest $request, Employee $employee): EmployeeContactResource|\Illuminate\Http\JsonResponse
    {
        try {
            $contact = $employee->contacts()->create($request->validated());
            return new EmployeeContactResource($contact);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Request $request, Employee $employee, EmployeeContact $contact): EmployeeContactResource
    {
        return EmployeeContactResource::make($contact);
    }

    public function update(EmployeeContactRequest $request, Employee $employee, EmployeeContact $contact): EmployeeContactResource|\Illuminate\Http\JsonResponse
    {
        try {
            $contact->update($request->validated());
            return new EmployeeContactResource($contact);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(EmployeeContact $contact): \Illuminate\Http\JsonResponse
    {
        try {
            $contact->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
