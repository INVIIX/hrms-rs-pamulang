<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeDocument extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Employee $employee)
    {
        $data = [
            'ktp' => $employee->single_document('ktp')->first(),
            'tax' => $employee->single_document('tax')->first(),
            'kontrak' => $employee->single_document('contract')->first(),
            'asuransi' => $employee->single_document('asuransi')->first(),
            'str_letter' => $employee->single_document('str_letter')->first(),
            'certificates' => $employee->documents()->where('collection', '=', 'certificates')->get(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
