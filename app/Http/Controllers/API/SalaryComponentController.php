<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryComponentRequest;
use App\Http\Resources\SalaryComponentResource;
use App\Models\SalaryComponent;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalaryComponentController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return SalaryComponentResource::collection(SalaryComponent::latest()->paginate(10));
    }

    public function store(SalaryComponentRequest $request): SalaryComponentResource|\Illuminate\Http\JsonResponse
    {
        try {
            $salaryComponent = SalaryComponent::create($request->validated());
            return new SalaryComponentResource($salaryComponent);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(SalaryComponent $salaryComponent): SalaryComponentResource
    {
        return SalaryComponentResource::make($salaryComponent);
    }

    public function update(SalaryComponentRequest $request, SalaryComponent $salaryComponent): SalaryComponentResource|\Illuminate\Http\JsonResponse
    {
        try {
            $salaryComponent->update($request->validated());
            return new SalaryComponentResource($salaryComponent);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(SalaryComponent $salaryComponent): \Illuminate\Http\JsonResponse
    {
        try {
            $salaryComponent->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
