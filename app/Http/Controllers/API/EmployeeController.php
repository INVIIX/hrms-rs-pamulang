<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $request->validate([
            'page' => 'nullable|numeric|min:1',
            'limit' => 'nullable|numeric|min:10|max:100',
            'search' => 'nullable|string|max:255',
        ]);

        $model = Employee::with(['profile']);

        // if ($request->has('includes')) {
        //     $includes = $request->input('includes');
        //     $model->with($includes);
        // }

        if ($request->has('search')) {
            $search = $request->input('search');
            $model->whereAny([
                'nip',
                'name',
                'email',
                'phone',
            ], 'LIKE', '%' . $search . '%');
        }

        $collection = $model->paginate($request->input('limit', 10));
        return EmployeeResource::collection($collection);
    }

    public function store(EmployeeCreateRequest $request): EmployeeResource|\Illuminate\Http\JsonResponse
    {
        try {
            $input = $request->validated();
            if ($request->hasFile('avatar')) {
                $input['avatar'] = $request->file('avatar')->store('avatars');
            } else {
                unset($input['avatar']);
            }
            DB::beginTransaction();
            $employee = Employee::create($input);
            $employee->profile()->updateOrCreate([], $input['profile']);
            DB::commit();
            $employee->load('profile');
            return new EmployeeResource($employee);
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Employee $employee): EmployeeResource
    {
        $employee->load(['profile']);
        return EmployeeResource::make($employee);
    }

    public function update(EmployeeUpdateRequest $request, Employee $employee): EmployeeResource|\Illuminate\Http\JsonResponse
    {
        try {
            $input = $request->validated();

            if (empty($input)) {
                throw new \Exception("No data");
            }

            if ($request->hasFile('avatar')) {
                $input['avatar'] = $request->file('avatar')->store('avatars');
            } else {
                unset($input['avatar']);
            }

            DB::beginTransaction();
            $employee->update($input);
            if (isset($input['profile'])) {
                $employee->profile()->updateOrCreate([], $input['profile']);
            }
            DB::commit();
            $employee->load('profile');
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
