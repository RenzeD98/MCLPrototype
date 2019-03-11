<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Laravel\Facades\Pusher;

class PusherController extends Controller
{
    public function index(){
        return view('controlpanel');
    }

    public function pushInputPaneltUpdate(Request $request){

        $message = 'red';

        Pusher::trigger('MCL_prototype', $request->id, ['message' => $message]);
    }

    public function startSession(Request $request) {
        $iterations = $request->iterations;
        $intval = $request->interval;
        $i = 1;

        $this->pushSessionUpdate($iterations, $intval, $i);
    }

    public function pushSessionUpdate($iterations, $intval, $i){
        if($i <= $iterations) {
            $channel = strval(rand(1, 4));
            $data = array(
                'iterations' => $iterations,
                'intval' => $intval,
                'i' => $i
            );

            if ($i !== 1) {
                sleep($intval);
            }

            Pusher::trigger('MCL_prototype', $channel, ['message' => json_encode($data)]);
        }
    }

    public function receiveSesionUpdate(Request $request){
        $iterations = $request->iterations;
        $intval = $request->intval;
        $i = $request->i + 1;

        $this->pushSessionUpdate($iterations, $intval, $i);
    }
}
