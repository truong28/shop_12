<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainCotroller extends Controller
{
    public function index()
    {
        return view('main',[
            'title' => 'Shop Clothes'
        ]);
    }
}
