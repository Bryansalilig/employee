<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download($filename)
    {
        $path = 'images/referral-attachment/' . $filename; // Adjust the path as needed

        if (Storage::exists($path)) {
            $file = Storage::get($path);
            $headers = [
                'Content-Type' => 'application/pdf',
                                // For PDF
                'Content-Type' => 'application/pdf',

                // For Microsoft Word DOCX
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',

                // For Microsoft Word DOC
                'Content-Type' => 'application/msword',

                // For Excel XLSX
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

                // For Excel XLS
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ];

            return Response::make($file, 200, $headers);
        } else {
            abort(404, 'File not found');
        }
    }
}
