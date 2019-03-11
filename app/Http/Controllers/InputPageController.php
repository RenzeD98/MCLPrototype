<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputPageController extends Controller
{
    public function index(){
        return view('inputpanel');
    }
}
