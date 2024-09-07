<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    
    public function index()
    {
        return response([
            'status' => 'success',
            'message' => 'Data Menu Berhasil Ditambahkan!',
         ]);
    }
}
