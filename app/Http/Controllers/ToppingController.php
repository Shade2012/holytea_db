<?php

namespace App\Http\Controllers;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToppingController extends Controller
{
    public function index (){
        $topping = Topping::all();
        return response([
            'status' => 'success',
            'message' => 'Data topping Berhasil Didapat!',
            'topping' => $topping,
         ]);
    }
    
    public function store(Request $request)
    {
        // Add 'heic' to the list of accepted mimes
        $validator = Validator::make($request->all(), [
            'name_topping' => 'required|string|max:255',
            'price_topping' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $post = Topping::create([
            'name_topping' => $request->name_topping,
            'price_topping' => $request->price_topping,
        ]);
        
        return response([
           'status' => 'success',
           'message' => 'Data Topping Berhasil Ditambahkan!',
           'data' => $post
        ]);
    }
    
    public function delete(int $id){
        $topping = Topping::find($id);
         // Check if the menu exists
    if ($topping) {
        // Delete the menu
        $topping->delete();
        return response()->json(['message' => 'Menu deleted successfully.'], 200);
    } else {
        return response()->json(['message' => 'Menu not found.'], 404);
    }
    }
}
