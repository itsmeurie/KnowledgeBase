<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FileUploadRequest;

use App\MITD\FileUpload;
use App\Models\File;

trait FilesTrait {
    protected function uploadFileRequest(FileUploadRequest $request, $location = "", $fileRule = "required|file") {
        $validated = $request->validated();
        $uid = $validated["uid"] ?? null;
        if (!$uid) {
            return FileUpload::prepareUpload($validated["name"], $validated["rename"], $validated["size"], $location);
        } else {
            $next = FileUpload::getNextPart($uid);
            if ($next["part"] == 1) {
                $request->validate(["file" => $fileRule]);
            }
            $received = FileUpload::receivePart($request->file("file"), $uid);
            if (!!$received["raw"]) {
                $received["file"] = File::create($received["raw"]);
            }
            return $received;
        }
    }

    protected function previewFile(File $files) {
        $filePath = join(DIRECTORY_SEPARATOR, [$files->path, $files->file_name . "." . $files->ext]);

        if (!Storage::disk()->exists($filePath)) {
            return response(
                [
                    "message" => "File not found!",
                ],
                422
            );
        }

        $fullPath = Storage::disk()->path($filePath);
        $headers = [
            "Content-Type" => $files->mime,
        ];

        return response()->file($fullPath, $headers);
    }

    protected function downloadFile(File $file) {
        $filePath = join(DIRECTORY_SEPARATOR, [$file->path, $file->file_name . "." . $file->ext]);

        if (!Storage::disk()->exists($filePath)) {
            return response([
                "message" => "File not Found!",
            ]);
        }

        $fullPath = Storage::disk()->path($filePath);
        $headers = [
            "Content-Type" => $file->mime,
            "Content-Length" => $file->size,
            "Content-disposition" => 'attachment; filename=" ' . $file->name . '"',
        ];

        return response()->download($fullPath, $file->name, $headers);
    }
}
