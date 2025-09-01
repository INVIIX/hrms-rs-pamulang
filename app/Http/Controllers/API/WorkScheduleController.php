<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkScheduleRequest;
use App\Http\Resources\WorkScheduleResource;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class WorkScheduleController extends Controller
{

    public function index(Request $request)
    {
        $request->validate([
            'page' => 'nullable|numeric|min:1',
            'limit' => 'nullable|numeric|min:10|max:100',
            'search' => 'nullable|string|max:255',
        ]);

        $model = WorkSchedule::with('days');

        if ($request->has('search')) {
            $search = $request->input('search');
            $model->whereAny([
                'name'
            ], 'LIKE', '%' . $search . '%');
        }

        $collection = $model->paginate($request->input('limit', 10));
        return WorkScheduleResource::collection($collection);
    }


    public function store(WorkScheduleRequest $request)
    {
        try {
            $input = $request->validated();
            DB::beginTransaction();
            $work_schedule = WorkSchedule::create($input);
            $work_schedule->days()->upsert(
                $input['days'],
                ['work_schedule_id', 'day_of_week'],
                ['start_time', 'end_time', 'break_duration', 'is_overnight', 'is_holiday']
            );
            DB::commit();
            $work_schedule->load('days');
            return new WorkScheduleResource($work_schedule);
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function show(WorkSchedule $work_schedule)
    {
        $work_schedule->load('days');
        return new WorkScheduleResource($work_schedule);
    }


    public function update(WorkScheduleRequest $request, WorkSchedule $work_schedule)
    {
        try {
            $input = $request->validated();
            DB::beginTransaction();
            $work_schedule->update($input);
            $work_schedule->days()->upsert(
                $input['days'],
                ['work_schedule_id', 'day_of_week'],
                ['start_time', 'end_time', 'break_duration', 'is_overnight', 'is_holiday']
            );
            DB::commit();
            $work_schedule->load('days');
            return new WorkScheduleResource($work_schedule);
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function destroy(WorkSchedule $work_schedule)
    {
        try {
            $work_schedule->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
