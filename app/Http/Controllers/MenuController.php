<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    
    public function index()
    {
        $menus = Menu::all();
        return response([
            'status' => 'success',
            'message' => 'Data Menu Berhasil Didapat!',
            'menu' => $menus,
         ]);
    }

    public function store(Request $request)
    {
        // Add 'heic' to the list of accepted mimes
        $validator = Validator::make($request->all(), [
            'image_menu' => 'required|mimes:jpeg,png,jpg,gif,svg,heic|max:5000',
            'name_menu' => 'required|string|max:255',
            'price_menu' => 'required|numeric',
            'category_menu' => 'required|string|max:255',
            'rating_menu' => 'required|numeric|max:255',
            'description_menu' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $image = $request->file('image_menu');
    
        // Get original extension to handle HEIC correctly
        $extension = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $extension;
        $image->move(public_path('images/menu'), $imageName);
    
        $post = Menu::create([
            'image_menu' => $imageName,
            'name_menu' => $request->name_menu,
            'price_menu' => $request->price_menu,
            'category_menu' => $request->category_menu,
            'rating_menu' => $request->rating_menu,
            'description_menu' => $request->description_menu,
        ]);
        
        return response([
           'status' => 'success',
           'message' => 'Data Menu Berhasil Ditambahkan!',
           'data' => $post
        ]);
    }
    
    public function delete(int $id){
        $menu = Menu::find($id);
         // Check if the menu exists
    if ($menu) {
        // Delete the menu
        $menu->delete();
        return response()->json(['message' => 'Menu deleted successfully.'], 200);
    } else {
        return response()->json(['message' => 'Menu not found.'], 404);
    }
    }
}
