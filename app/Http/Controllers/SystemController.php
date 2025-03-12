<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\System;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Validator;
class SystemController extends Controller
{
    public function list(): JsonResponse
    {
        $records = System::all();

        return response()->json([
            'systems' => $records
        ]);
    }

    public function index(): JsonResponse
    {
        $records = System::all();

        return response()->json([
            'systems' => $records
        ]);
    }

    public function show($id): JsonResponse
    {
        $record = System::find($id);

        if (!$record) {
            return response()->json([
                'message' => "Record not found"
            ], 404);
        }

        return response()->json([
            'data' => $record
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $fields = $request->all();

        $record = System::create([
            'title' => $fields['title'],
            'content' => $fields['content'],
        ]);

        return response()->json([
            'data' => $record,
            'message' => 'Record created'
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $record = System::find($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required', 
            'content' => 'nullable'
            
        ]);

        $fields = $validator->validated();

        if (!$record) {
            return response()->json([
                'message' => "Record not found"
            ], 404);
        }

        $fields = $request->all();
        $record->update($fields);

        return response()->json([
            'data' => $record,
            'message' => 'Record updated'
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $record = System::find($id);

        if (!$record) {
            return response()->json([
                'message' => "Record not found"
            ], 404);
        }

        $record->delete();

        return response()->json([
            'message' => 'Record deleted'
        ]);
    }



    
}



class User extends Model
    {
        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class)->withDefault( [
                'name' => 'Guest Author',
            ]);
        }
         
    }



class Phone extends Model
{
   public function phone(): HasOne
   {
    return $this->hasOne(Phone::class, 'foreign_key', 'owner_key');
   }

}




