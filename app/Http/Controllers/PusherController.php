<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Laravel\Facades\Pusher;

class PusherController extends Controller
{
    public function index(){
        return view('controlpanel');
    }

    public function pushInputPanelUpdate(Request $request){

        $message = 'red';

        Pusher::trigger('MCL_prototype', $request->id, ['message' => $message]);
    }

    public function startSession(Request $request) {
        $iterations = $request->iterations;
        $interval = $request->interval;
        $i = 1;

        $this->sessionUpdate($iterations, $interval, $i);
    }

    public function sessionUpdate($iterations, $interval, $i){
        if($i <= $iterations) {
            $channel = strval(rand(1, 4));

            $data = json_encode(array(
                'iterations' => $iterations,
                'interval' => $interval,
                'i' => $i
            ));

            if ($i !== 1) {
                sleep($interval);
            }

            Pusher::trigger('MCL_prototype', $channel, ['message' => $data]);
        } else {
            Pusher::trigger('MCL_prototype', 'toggleStartButton', ['message' => 'oh hallo']);
        }
    }

    public function recieveSessionUpdate(Request $request){
        // json decode request
        $request = json_decode($request->getContent());

        $iterations = $request->iterations;
        $interval = $request->interval;
        $i = $request->i + 1;
        $laptime = $request->laptime;

        //send laptime to controlpanel
        Pusher::trigger('MCL_prototype', 'laptimes', ['laptime' => $laptime]);

        $this->sessionUpdate($iterations, $interval, $i);
    }
}
