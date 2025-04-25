<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequests\CreateSectionRequest;
use App\Http\Requests\SectionRequests\UpdateSectionRequest;
use App\Http\Resources\GetSectionResource;
use App\Http\Resources\SectionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Office;
use Illuminate\Support\Str;

class SectionController extends Controller {
    public function list(Request $request, ?string $parent_id = null): JsonResponse {
        $limit = $request->input("limit", 25);
        $page = $request->input("page", 1);

        $parent_id = !!$parent_id ? Section::hashToId($parent_id) : null;

        $user = $request->user();
        $office = $user->getSessionOffice();

        $sections = Section::where("office_id", $office->id)
            ->when($parent_id, function ($query) use ($parent_id) {
                $query->where("parent_id", $parent_id);
            })
            ->when(!$parent_id, function ($query) use ($parent_id) {
                $query->whereNull("parent_id");
            })
            ->when($request->query("slug"), function ($query) use ($request) {
                $query->slug($request->query("slug"));
            })
            ->paginates(limit: $limit, page: $page);

        // $sections["data"] = SectionResource::collection($sections["data"]);

        $sections["data"] = SectionResource::collection($sections["data"]);
        return response()->json($sections);
    }
    public function show(string $office_id, string $slug) {
        $id = Office::hashToId($office_id);

        $section = Section::where("office_id", $id)->where("slug", $slug)->first();
        return response()->json($section);
    }

    public function getSectionByParentId(Request $request, string $parent_id) {
        $parent_id = Section::hashToId($parent_id);
        $user = $request->user();
        $office = $user->getSessionOffice();

        $sections = Section::select("id", "title", "slug")->where("parent_id", $parent_id)->where("office_id", $office->id)->get();

        return response()->json(GetSectionResource::collection($sections));
    }
    //
    // public function list (Request $request) : JsonResponse
    // {
    //     $sections = Section::when($request->query('title'), function($query) use ($request){
    //         $query->title($request->query('title'));
    //     })->get();

    //     return response()->json($sections);
    // }
    // public function show(Request $request, string $slug): JsonResponse {
    //     return response()->json([
    //         "section" => SectionResource::make($slug),
    //     ]);
    // }
    public function create(CreateSectionRequest $request): JsonResponse {
        $fields = $request->validated();
        $section = Section::create([
            "title" => $fields["title"],
            "description" => $fields["description"],
            "office_id" => $fields["office_id"],
        ]);

        return response()->json([
            "section" => SectionResource::make($section),
        ]);
    }
    public function update(UpdateSectionRequest $request, Section $section): JsonResponse {
        $fields = $request->validated();

        $section->update([
            "title" => $fields["title"],
            "description" => $fields["description"],
            "office_id" => $fields["office_id"],
        ]);

        return response()->json([
            "section" => SectionResource::make($section),
        ]);
    }

    public function delete(Request $request, Section $section): JsonResponse {
        $section->delete();

        return response()->json([
            "message" => "{$section->title} #{$section->hash} has been deleted.",
        ]);
    }
    public function restore(Request $request, string $section): JsonResponse {
        if (!is_numeric($section)) {
            //expecting hash
            $section = Section::withTrashed()->byHash($section);
        } else {
            //expecting id
            $section = Section::withTrashed()->find($section);
            $section->restore();
        }
        return response()->json([
            "message" => "{$section->name}#{$section->hash} has been restored",
        ]);
    }
}
