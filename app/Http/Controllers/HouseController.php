<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\House_property;
use App\Models\Image;
use Illuminate\Auth\Recaller;
use Illuminate\Http\Request;
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
        House_property::insert($dataProperties);
        $dataImages = $request->images->map(function($object) use ($home) {
            $object['path'] = $object->file('image')->store('images', 'public');
            $object['house_id'] = $home->id;
            return $object;
        });
        Image::insert($dataImages);
        return response()->json(['message' => 'House created'],200);
    }
}