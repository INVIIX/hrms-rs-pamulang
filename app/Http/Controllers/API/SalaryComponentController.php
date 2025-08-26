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
            $salary_component = SalaryComponent::create($request->validated());
            return new SalaryComponentResource($salary_component);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(SalaryComponent $salary_component): SalaryComponentResource
    {
        return SalaryComponentResource::make($salary_component);
    }

    public function update(SalaryComponentRequest $request, SalaryComponent $salary_component): SalaryComponentResource|\Illuminate\Http\JsonResponse
    {
        try {
            $salary_component->update($request->validated());
            return new SalaryComponentResource($salary_component);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(SalaryComponent $salary_component): \Illuminate\Http\JsonResponse
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
