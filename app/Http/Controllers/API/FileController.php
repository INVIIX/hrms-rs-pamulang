<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('local');
        $file = $request->get('path');
        $download = filter_var($request->get('download', false), FILTER_VALIDATE_BOOLEAN);

        if (!$file || !$disk->exists($file)) {
            return response()->json([
                'error' => 'File not found.'
            ], 404);
        }

        $stream = $disk->readStream($file);

        if ($download) {
            return response()->streamDownload(function () use ($stream) {
                fpassthru($stream);
                fclose($stream);
            }, basename($file), [
                'Content-Type' => $disk->mimeType($file),
                'Content-Length' => $disk->size($file),
            ]);
        }

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => $disk->mimeType($file),
            'Content-Length' => $disk->size($file),
        ]);
    }
}
