<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequests\DeleteSectionRequest;
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
use App\Http\Requests\SectionRequests\RestoreSectionRequest;
use App\Models\File;
use GuzzleHttp\Promise\Create;
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
            ->when($user->isSuperman(), function ($query) {
                $query->withTrashed();
            })
            ->paginates(limit: $limit, page: $page);

        $sections["data"] = SectionResource::collection($sections["data"]);
        return response()->json($sections);
    }
    public function show(Request $request, string $slug) {
        $user = $request->user();
        $office = $user->getSessionOffice();
        $search = $request->input("search"); // Grab the ?search=... query

        $section = Section::with([
            "subSections" => function ($query) use ($user, $search) {
                if ($user->isSuperman()) {
                    $query->withTrashed();
                }

                // Add filtering if search term is provided
                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where("title", "ILIKE", "%{$search}%")->orWhere("contents", "ILIKE", "%{$search}%");
                    });
                }
            },
        ])
            ->where("slug", $slug)
            ->where("office_id", $office->id)
            ->when($user->isSuperman(), fn($q) => $q->withTrashed())
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
    public function create(CreateSectionRequest $request, Section $section): JsonResponse {
        $user = request()->user();
        $office = $user->getSessionOffice();

        $fields = $request->validated();

        $section = Section::create([
            "office_id" => $office->id,
            "title" => $fields["title"],
            "description" => $fields["description"] ?? null,
            "contents" => $fields["contents"] ?? null,
            "slug" => Section::slugify($fields["title"]),
            "parent_id" => isset($fields["parent_id"]) && $fields["parent_id"] !== "none" ? Section::hashToId($fields["parent_id"]) : null,
        ]);

        $parentSection = $section->parent_id
            ? Section::with([
                "office",
                "subSections" => function ($query) {
                    $query->select("id", "title", "description", "slug", "contents", "parent_id");
                },
            ])->find($section->parent_id)
            : $section;

        trail("Create Section")->info("Section Created");

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
        trail("Update Section")->info("Section Updated");
    }

    public function deleteSection(DeleteSectionRequest $request, Section $section): JsonResponse {
        $user = $request->user();
        $office = $user->getSessionOffice();
        $exists = $office->sections()->where("id", $section->id)->first();

        if (!$exists) {
            return response()->json([
                "message" => "Section not found!",
            ]);
        }

        // Soft-delete subsections if any
        if ($section->subsections()->count() > 0) {
            $section->subsections()->delete(); // Soft-delete subsections
        }

        // Soft-delete the section itself
        $section->delete();

        return response()->json([
            "message" => $section->parent_id ? "Subsection deleted successfully." : "Section deleted successfully.",
        ]);
        trail("Delete Section")->info("Section Deleted");
    }

    public function restoreSection(RestoreSectionRequest $request, string $section): JsonResponse {
        $user = request()->user();
        $office = $user->getSessionOffice();

        // Get the soft-deleted section
        $section = $office->sections()->onlyTrashed()->where("id", Section::hashToId($section))->first();

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
            "data" => new SectionResource($section),
        ]);
        trail("Restore Section")->info("Section Restored");
    }

    public function upload(FileUploadRequest $request, Section $section) {
        $upload = $this->uploadFileRequest($request, "kb_file", "required|file|mimes:pdf,jpeg,jpg,png,doc,docx,ppt,pptx,mp4,mp3");
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
