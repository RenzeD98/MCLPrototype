<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Laravel\Facades\Pusher;

class PusherController extends Controller
{
    /**
     * Return view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('controlpanel');
    }

    /**
     * Push an update to the input panel
     *
     * @param Request $request
     */
    public function pushInputPanelUpdate(Request $request){
        $message = 'red';
        Pusher::trigger('MCL_prototype', $request->id, ['message' => $message]);
    }

    /**
     * Start a session
     *
     * @param Request $request
     */
    public function startSession(Request $request) {
        $iterations = $request->iterations;
        $interval = $request->interval;
        $devices = $request->devices;
        $i = 0;

        $this->sessionUpdate($iterations, $interval, $i, $devices);
    }

    /**
     * Handle an session update
     *
     * @param $iterations
     * @param $interval
     * @param $i
     * @param $devices
     */
    public function sessionUpdate($iterations, $interval, $i, $devices){
        if($i < $iterations) {
            $channel = strval(rand(1, $devices));

            $data = json_encode(array(
                'iterations' => $iterations,
                'interval' => $interval,
                'i' => $i,
                'devices' => $devices
            ));

            if ($i !== 0) {
                sleep($interval);
            }

            Pusher::trigger('MCL_prototype', $channel, ['message' => $data]);
        } else {
            Pusher::trigger('MCL_prototype', 'toggleStartButton', ['message' => 'oh hallo']);
        }
    }

    /**
     * Session update receiver
     *
     * @param Request $request
     */
    public function recieveSessionUpdate(Request $request){
        // json decode request
        $request = json_decode($request->getContent());

        $iterations = $request->iterations;
        $interval = $request->interval;
        $i = $request->i + 1;
        $devices = $request->devices;
        $laptime = $request->laptime;

        //send laptime to controlpanel
        Pusher::trigger('MCL_prototype', 'laptimes', ['laptime' => $laptime]);

        $this->sessionUpdate($iterations, $interval, $i, $devices);
    }
}
