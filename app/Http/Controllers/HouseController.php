<?php

namespace App\Http\Controllers;

use App\Filters\For_Sale;
use App\Filters\Ownership_Type;
use App\Filters\price;
use App\Filters\Space;
use App\Models\House;
use App\Models\House_property;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\Validator;

class HouseController extends Controller
{
    public function create(Request $request) {
        $rules = [
            'long_loc' => 'required|double',
            'lat_loc' => 'required|double',
            'is_for_sell' => 'required|boolean',
            'price' => 'required|double',
            'ownership_type' => 'required',
            'properties' => 'required|array',
            'properties.*.key' => 'required|int',
            'properties.*.value' => 'required',
            'images' => 'required|array',
            'images.*.is_main' => 'boolean',
            'images.*.image' => 'required|image',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) return response()->json($validator->errors(), 403);
        // $user = auth()->user();
        $dataHouse = [
            'long_loc' => $request->long_loc,
            'lat_loc' => $request->lat_loc,
            'is_for_sell' => $request->is_for_sell,
            'price' => $request->price,
            'ownership_type' => $request->ownership_type,
        ];
        $home = House::create($dataHouse);
        $dataProperties = $request->properties->map(function($object) use ($home) {
            $object['house_id'] = $home->id;
            return $object;
        });
        House_property::create($dataProperties);
        $dataImages = $request->images->map(function($object) use ($home) {
            $object['path'] = $object->file('image')->store('images', 'public');
            $object['house_id'] = $home->id;
            return $object;
        });
        Image::create($dataImages);
        return response()->json(['message' => 'House created'],200);
    }

    public function get_houses(Request $request){
        $pip=[
            Price::class,
            Space::class,
            For_Sale::class,
            Ownership_Type::class
        ];
        $houses=Pipeline::send( House::query())
        ->through($pip)
        ->thenReturn()->get();
        return response()->json($houses,200);
    }

    

    
}
