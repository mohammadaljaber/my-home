<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Image;
use App\Filters\price;
use App\Filters\Space;
use App\Filters\For_Sale;
use Illuminate\Http\Request;
use App\Models\House_property;
use App\Filters\Ownership_Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
            'properties' => 'array',
            'properties.*.key' => 'required|int',
            'properties.*.value' => 'required',
            'images' => 'required|array',
            'images.*.is_main' => 'boolean',
            'images.*.image' => 'required|image',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) 
            return response()->json($validator->errors(), 403);
        $dataHouse = [
            'user_id'=>Auth::user()->id,
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

    public function update(Request $request,$id){
        $rules = [
            'long_loc' => 'required|double',
            'lat_loc' => 'required|double',
            'is_for_sell' => 'required|boolean',
            'price' => 'required|double',
            'ownership_type' => 'required',
            'properties' => 'required|array',
            'properties.*.key' => 'required|int',
            'properties.*.value' => 'required',
            'images' => 'array',
            'images.*.is_main' => 'boolean',
            'images.*.image' => 'image',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails())
            return response()->json($validator->errors(), 403);

        $home=House::where('id',$id)->update([
            'long_loc' => $request->long_loc,
            'lat_loc' => $request->lat_loc,
            'is_for_sell' => $request->is_for_sell,
            'price' => $request->price,
            'ownership_type' => $request->ownership_type,
        ]);
        if($request->images){
            $dataImages = $request->images->map(function($object) use ($home) {
                $object['path'] = $object->file('image')->store('images', 'public');
                $object['house_id'] = $home->id;
                return $object;
            });
            Image::insert($dataImages);
        }
        if($request->images_to_delete){
            $images=Image::whereIn('id',$request->images_to_delete)->get();
            foreach($images as $image){
                if( File::exists($image->path)){
                    File::delete($image->path);
                }
            }
            Image::destroy($request->images_to_delete);
        }
        foreach($request->property as $property){
            House_property::where('id',$property->id)->update([
                'value'=>$property->value
            ]);
        }
        return response()->json(['message' => 'House updated'],200);
        
    }

    public function house_info($id){
        $home=House::findorfail($id)->first();
        $properties=array_map(function($property){
            return [
                'key'=>$property['key'],
                'value'=>$property['pivot']['value'],
            ];
        },$home->properties->toArray());

        
        return response()->json([
            'house'=>$home,
            'property'=>$properties
        ],200);
    }

    

    
}
