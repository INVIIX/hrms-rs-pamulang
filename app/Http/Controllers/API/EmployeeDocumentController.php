<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeDocumentResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EmployeeDocumentController extends Controller
{

    public function index(Employee $employee)
    {
        $data = (object) [
            'tax' => $employee->single_document('tax')->first(),
            'kontrak' => $employee->single_document('kontrak')->first(),
            'asuransi' => $employee->single_document('asuransi')->first(),
            'str_letter' => $employee->single_document('str_letter')->first(),
            'sp_letter' => $employee->single_document('sp_letter')->first(),
            'certificates' => $employee->documents()->where('collection', '=', 'certificates')->get(),
            'other_document' => $employee->single_document('other_document')->first(),
            'surat_perjanjian_lainnya' => $employee->single_document('surat_perjanjian_lainnya')->first(),
            'ktp' => $employee->single_document('ktp')->first(),
            'kartu_keluarga' => $employee->single_document('kartu_keluarga')->first(),
            'akta_kelahiran' => $employee->single_document('akta_kelahiran')->first(),
            'npwp' => $employee->single_document('npwp')->first(),
            'ijazah' => $employee->single_document('ijazah')->first(),
        ];
        return new EmployeDocumentResource($data);
    }


    public function store(EmployeeDocumentRequest $request, Employee $employee): DocumentResource|JsonResponse
    {
        $input = $request->validated();
        try {
            $result = collect(['id' => null]);
            $path = '';
            $collection = $input['collection'] ?? null;
            $data = [];
            if ($request->hasFile('file') && !empty($collection)) {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $mimeType = $file->getClientMimeType();
                $size = $file->getSize();
                $path = $request->file('file')->store('documents');
                $data = [
                    'collection' => $collection,
                    'filename' => $filename,
                    'path' => $path,
                    'mime_type' => $mimeType,
                    'size' => $size
                ];
            }
            if (!empty($data)) {
                $result = $collection == 'certificates'
                    ? $employee->documents()->create($data)
                    : $employee->single_document($collection)->updateOrCreate([], $data);
            }
            return new DocumentResource($result);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function show(Employee $employee, Document $document): DocumentResource
    {
        return new DocumentResource($document);
    }


    public function update(EmployeeDocumentRequest $request, Employee $employee, Document $document)
    {
        $input = $request->validated();
        try {
            $result = collect(['id' => null]);
            $path = '';
            $collection = $input['collection'] ?? null;
            $data = [];
            if ($request->hasFile('file') && !empty($collection)) {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $mimeType = $file->getClientMimeType();
                $size = $file->getSize();
                $path = $request->file('file')->store('documents');
                $data = [
                    'collection' => $collection,
                    'filename' => $filename,
                    'path' => $path,
                    'mime_type' => $mimeType,
                    'size' => $size
                ];
            }
            if (!empty($data)) {
                $document->update($data);
            }
            return new DocumentResource($document);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function destroy(Request $request, Employee $employee, Document $document)
    {
        try {
            $document->delete();
            return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json(['error' => 'There is an error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
