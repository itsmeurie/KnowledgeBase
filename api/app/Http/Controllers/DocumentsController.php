<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequests\CreateDocumentRequest;
use App\Http\Requests\DocumentRequests\UpdateDocumentRequest;
use App\Models\Documents;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    //
    public function list(Request $request) : JsonResponse
    {
        $documents = Documents::all();

        return response()->json($documents);
    }

    public function show(Request $request, Documents $document) : JsonResponse
    {
        return response()->json([
            'documents' => $document
        ]);
    }

    public function create(CreateDocumentRequest $request) : JsonResponse
    {
        $fields = $request->validated();

        $document = Documents::create($fields);

        return response()->json([
            'document' => $document
        ]);
    }

    public function update(UpdateDocumentRequest $request, Documents $document) : JsonResponse
    {
        $fields = $request->validated();

        $document->update($fields);

        return response()->json([
            'document' => $document
        ]);
    }

    public function delete(Request $request, Documents $document) : JsonResponse
    {
        $document->delete();

        return response()->json([
            'message' => "{$document->contents}#{$document->hash} has been deleted."
        ]);
    }

    public function restore (Request $request, string | int $document) : JsonResponse
    {
        if (!is_numeric($document)) {
            $document = Documents::withTrashed()->byHash($document);
            # code...
        } else {
            $document = Documents::withTrashed()->find($document);
        }
        return response()->json([
            'message' => "{$document->contents}#{$document->hash} has been restored"
        ]);
    }
}
