<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoanRequest;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class LoanController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return LoanResource::collection(
            Loan::with(['employee', 'group'])->latest()->paginate(10)
        );
    }

    public function store(LoanRequest $request): LoanResource|JsonResponse
    {
        try {
            $loan = Loan::create($request->validated());
            $loan->load(['employee', 'department']);
            return new LoanResource($loan);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(
                ['error' => $exception->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(Loan $loan): LoanResource
    {
        $loan->load(['employee', 'department']);
        return new LoanResource($loan);
    }

    public function update(LoanRequest $request, Loan $loan): LoanResource|JsonResponse
    {
        try {
            $loan->update($request->validated());
            return new LoanResource($loan);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(
                ['error' => $exception->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(Loan $loan): JsonResponse
    {
        try {
            $loan->delete();
            return response()->json(
                ['message' => 'Deleted successfully'],
                Response::HTTP_OK
            );
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(
                ['error' => $exception->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
