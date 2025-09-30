<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClockInRequest;
use App\Http\Requests\ClockOutRequest;
use App\Http\Requests\TimesheetRequest;
use App\Http\Resources\TimesheetResource;
use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'page' => 'nullable|numeric|min:1',
            'limit' => 'nullable|numeric|min:10|max:100',
            // 'search' => 'nullable|string|max:255',
        ]);

        $model = Timesheet::query();

        // if ($request->has('search')) {
        //     $search = $request->input('search');
        //     $model->whereAny([
        //         'nip',
        //         'name',
        //         'email',
        //         'phone',
        //     ], 'LIKE', '%' . $search . '%');
        // }

        $collection = $model->paginate($request->input('limit', 10));
        return TimesheetResource::collection($collection);
    }

    public function store(TimesheetRequest $request)
    {
        try {
            $timesheet = Timesheet::create($request->validated());
            return new TimesheetResource($timesheet);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function show(Timesheet $timesheet)
    {
        return new TimesheetResource($timesheet);
    }

    public function update(TimesheetRequest $request, Timesheet $timesheet)
    {
        try {
            $timesheet->update($request->validated());
            return new TimesheetResource($timesheet);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function destroy(Timesheet $timesheet)
    {
        try {
            $timesheet->delete();
            return response()->json(['message' => 'Deleted successfully'], 200);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function clockin(ClockInRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('clock_in_image')) {
            $data['clock_in_image'] = $request->file('clock_in_image')->store('attendances/' . now()->format('Y-m-d'));
        } else {
            unset($data['clock_in_image']);
        }

        $timesheet = Timesheet::firstOrCreate([
            'employee_id' => $data['employee_id'],
            'work_date' => $data['work_date']
        ], $data);

        if ($timesheet->clock_in) {
            return response()->json(['error' => "Anda sudah Clock In"], 422);
        }

        return response()->json($timesheet);
    }

    public function clockout(ClockOutRequest $request)
    {
        $data = $request->validated();

        $timesheet = Timesheet::where([
            'employee_id' => $request->user()->id,
            'clock_out' => null
        ])->first();

        if (empty($timesheet)) {
            return response()->json(['error' => "Anda belum Clock In"], 422);
        } else {
            if ($request->hasFile('clock_out_image')) {
                $input['clock_out_image'] = $request->file('clock_out_image')->store('attendances/' . now()->format('Y-m-d'));
            } else {
                unset($input['clock_out_image']);
            }
            $timesheet->update($data);
        }

        return response()->json($timesheet);
    }
}
