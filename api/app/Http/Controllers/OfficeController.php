<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfficeRequests\CreateOfficeRequest;
use App\Http\Requests\OfficeRequests\UpdateOfficeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Intervention\Image\Colors\Rgb\Channels\Red;
use App\Models\Office;

class OfficeController extends Controller
{
    public function list(Request $request) : JsonResponse 
    {

        $offices = Office::when($request->query('name'), function($query) use ($request){
                        $query->name($request->query('name'));
                    })->get();

        return response()->json($offices);    
    }

    public function show(Request $request, Office $office) : JsonResponse 
    {
        return response()->json([
            'office' => $office
        ]);    
    }

    public function create(CreateOfficeRequest $request) : JsonResponse 
    {
        $fields = $request->validated();

        $office = Office::create($fields);

        return response()->json([
            'office' => $office
        ]);    
    }

    public function update(UpdateOfficeRequest $request, Office $office) : JsonResponse 
    {

        $fields = $request->validated();

        $office->update($fields);

        return response()->json([
            'office' => $office
        ]);    
    }

    public function delete(Request $request, Office $office) : JsonResponse 
    {

        $office->delete();

        return response()->json([
            'message' => "{$office->name} #{$office->hash} has been deleted."
        ]);    
    }

    public function restore(Request $request, string | int $office) : JsonResponse 
    {

        if(!is_numeric($office)){
            // expecting Hash
            $office = Office::withTrashed()->byHash($office);
        }else{
            // expecting id
            $office = Office::withTrashed()->find($office);
            $office->restore();
        }


        return response()->json([
            'message' => "{$office->name}#{$office->hash} has been restored"
        ]);    
    }

}
