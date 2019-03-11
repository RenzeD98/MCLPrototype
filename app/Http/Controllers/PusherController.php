<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Laravel\Facades\Pusher;

class PusherController extends Controller
{
    public function index(){
        $message = 'Pusher message';

        Pusher::trigger('MCL_prototype', '1', ['message' => $message]);

//        return view('welcome');
    }
}
