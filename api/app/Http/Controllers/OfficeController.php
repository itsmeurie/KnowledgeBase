<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfficeRequests\CreateOfficeRequest;
use App\Http\Requests\OfficeRequests\UpdateOfficeRequest;

use App\Http\Resources\OfficeResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Intervention\Image\Colors\Rgb\Channels\Red;
use App\Models\Office;

class OfficeController extends Controller {
    public function list(Request $request): JsonResponse {
        $offices = Office::when($request->query("name"), function ($query) use ($request) {
            $query->name($request->query("name"));
        })
            ->when($request->query("code"), function ($query) use ($request) {
                $query->code($request->query("code"));
            })
            ->get();

        return response()->json(OfficeResource::collection($offices));
    }

    public function show(Request $request, Office $office): JsonResponse {
        return response()->json([
            "office" => OfficeResource::make($office),
        ]);
    }

    public function create(CreateOfficeRequest $request): JsonResponse {
        $fields = $request->validated();

        $office = Office::create($fields);

        return response()->json([
            "office" => OfficeResource::make($office),
        ]);
    }

    public function update(UpdateOfficeRequest $request, Office $office): JsonResponse {
        $fields = $request->validated();

        $office->update($fields);

        return response()->json([
            "office" => OfficeResource::make($office),
        ]);
    }

    public function delete(Request $request, Office $office): JsonResponse {
        $office->delete();

        return response()->json([
            "message" => "{$office->name} #{$office->hash} has been deleted.",
        ]);
    }

    public function restore(Request $request, string|int $id): JsonResponse {
        $user = request()->user();
        $office = $user->getSessionOffice();

        // Get the soft-deleted section
        $section = $office->sections()->onlyTrashed()->where("id", Office::hashToId($id))->first();

        if (!$section) {
            return response()->json([
                "message" => "Section not found!",
            ]);
        }

        // Restore the section
        $section->restore();

        // Restore all soft-deleted subsections
        $section->subsections()->onlyTrashed()->restore();

        return response()->json([
            "message" => "Section Restored Successfully",
            "data" => new OfficeResource($section),
        ]);
        trail("Restore Section")->info("Section Restored");
    }
}
