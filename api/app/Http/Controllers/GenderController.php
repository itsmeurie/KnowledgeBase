<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Http\Resources\GenderResource;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    public function list(Request $request)
    {
        $genders = Gender::all();

        return response()->json(GenderResource::collection($genders));
    }
}
