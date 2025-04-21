<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequests\CreateSectionRequest;
use App\Http\Requests\SectionRequests\UpdateSectionRequest;

use App\Http\Resources\SectionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Office;
use Illuminate\Support\Str;

class SectionController extends Controller
{ 
    public function list (Request $request, string $office_id) : JsonResponse 
    {
        $limit = $request->input('limit', 25);
        $page = $request->input('page', 1);
        $id = Office::hashToId($office_id);

        $sections = Section::where('office_id', $id)
                        ->when($request->query('slug'), function($query) use ($request){
                            $query->slug($request->query('slug'));
                        })
                        ->paginates(limit: $limit, page: $page);

        // $sections["data"] = SectionResource::collection($sections["data"]);
        
        $sections["data"] = SectionResource::collection($sections["data"]);
        return response()->json($sections);
    }
    //
    // public function list (Request $request) : JsonResponse 
    // {
    //     $sections = Section::when($request->query('title'), function($query) use ($request){
    //         $query->title($request->query('title'));
    //     })->get();

    //     return response()->json($sections);
    // }
    public function show (Request $request, Section $section) : JsonResponse 
    {

        return response()->json([
            'section' => SectionResource::make($section)
        ]);
    }
    public function create (CreateSectionRequest $request) : JsonResponse 
    {
        $fields = $request->validated();
        $section = Section::create([
            'title' => $fields['title'],
            'description' => $fields['description'],
            'office_id' => $fields['office_id'],
        ]);
        
        return response()->json([
            'section' => SectionResource::make($section)
        ]);
    }    public function update (UpdateSectionRequest $request, Section $section) : JsonResponse 
    {
        $fields = $request->validated();

        $section->update($fields);

        return response()->json([
            'section' => SectionResource::make($section)
        ]);
    }

    public function delete (Request $request, Section $section) : JsonResponse 
    {
        $section->delete();


        return response()->json([
            'message' => "{$section->title} #{$section->hash} has been deleted."
        ]);
    }
    public function restore (Request $request, string | int $section) : JsonResponse 
    {

        if(!is_numeric($section)){
            //expecting hash
            $section = Section::withTrashed()->byHash($section);
        
        }else {
            //expecting id
            $section = Section::withTrashed()->find($section);
            $section->restore();
        }
        return response()->json([
            'message' => "{$section->name}#{$section->hash} has been restored"
        ]);
    }
    






}
