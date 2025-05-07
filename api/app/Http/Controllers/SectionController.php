<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequests\CreateSectionRequest;
use App\Http\Requests\SectionRequests\UpdateSectionRequest;
use App\Http\Resources\GetSectionResource;
use App\Http\Resources\SectionResource;
use App\Http\Resources\FileResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Office;
use App\Traits\FilesTrait;
use App\Http\Requests\FileUploadRequest;
use App\Models\File;
use Illuminate\Support\Str;

class SectionController extends Controller {
    use FilesTrait;
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
    public function show(Request $request, string $slug) {
        $user = $request->user();
        $office = $user->getSessionOffice();

        $section = Section::with("subSections") // eager load subsections
            ->where("office_id", $office->id)
            ->where("slug", $slug)
            ->firstOrFail();

        return response()->json(new GetSectionResource($section));
    }

    public function getSectionByParentId(Request $request, ?string $parent_id = null) {
        $user = $request->user();
        $office = $user->getSessionOffice();

        $sections = Section::select("id", "title", "contents", "slug")
            ->where("office_id", $office->id)

            ->when($parent_id, function ($query) use ($parent_id) {
                $query->where("parent_id", Section::hashToId($parent_id));
            })
            ->when(!$parent_id, function ($query) {
                $query->whereNull("parent_id");
            })
            ->get();

        return response()->json(GetSectionResource::collection($sections));
    }
    public function create(Request $request): JsonResponse {
        $user = $request->user();
        $office = $user->getSessionOffice();

        $fields = $request->validate([
            "title" => "required|string",
            "description" => "nullable|string",
            "contents" => "nullable|string",
            "parent_id" => "nullable|string",
        ]);

        $section = Section::create([
            "office_id" => $office->id,
            "title" => $fields["title"],
            "description" => $fields["description"] ?? null,
            "contents" => $fields["contents"] ?? null,
            "slug" => Section::slugify($fields["title"]),
            "parent_id" => isset($fields["parent_id"]) && $fields["parent_id"] !== "none" ? Section::hashToId($fields["parent_id"]) : null, // <-- ADD THIS
        ]);

        $parentSection = $section->parent_id
            ? Section::with([
                "office",
                "subSections" => function ($query) {
                    $query->select("id", "title", "description", "slug", "contents", "parent_id");
                },
            ])->find($section->parent_id)
            : $section;

        return response()->json([
            "section" => new GetSectionResource($parentSection),
        ]);
    }

    public function update(UpdateSectionRequest $request, Section $section): JsonResponse {
        $fields = $request->validated();

        // Only allow editing title and contents for both types
        $section->update([
            "title" => $fields["title"],
            "contents" => $fields["contents"],
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

    public function upload(FileUploadRequest $request, Section $section) {
        $upload = $this->uploadFileRequest($request, "kb_file", "required|file|mime:pdf,png,xlsx");
        if (isset($upload["file"])) {
            $file = $upload["file"];
            $file->update(["filable_id" => $section->id, "filable_type" => Section::class]);
            return [
                ...$upload["result"],
                // "file" => $upload["file"],
                "sha256" => $upload["raw"]["sha256"],
                "data" => SectionResource::make($section),
            ];
        }
        return $upload["result"];
    }

    public function preview(Request $request, File $file) {
        return $this->previewFile($file);
    }

    public function download(Request $request, File $file) {
        return $this->downloadFile($file);
    }
}
