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
        $download = $request->get('download', false);

        if (!$file || !$disk->exists($file)) {
            return response()->json([
                'error' => 'File not found.'
            ], 404);
        }

        if ($download == true) {
            return response()->streamDownload(function () use ($disk, $file) {
                echo $disk->get($file);
            }, basename($file));
        }

        $stream = $disk->readStream($file);
        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => $disk->mimeType($file),
            'Content-Length' => $disk->size($file),
        ]);
    }
}
