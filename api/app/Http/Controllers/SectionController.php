<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequests\CreateSectionRequest;
use App\Http\Requests\SectionRequests\UpdateSectionRequest;

use App\Http\Resources\SectionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    public function list (Request $request, $office_id) : JsonResponse 
    {
        $sections = Section::where('office_id', $office_id)
                        ->when($request->query('slug'), function($query) use ($request){
                            $query->slug($request->query('slug'));
                        })
                        ->get();
        
        return response()->json(SectionResource::collection($sections));
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
            ...$fields,
            'slug' => Str::slug($fields['title'], '-')
        ]);
        
        return response()->json([
            'section' => SectionResource::make($section)
        ]);
    }
    public function update (UpdateSectionRequest $request, Section $section) : JsonResponse 
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
