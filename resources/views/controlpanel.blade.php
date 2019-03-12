@extends('layout')

@section('content')

    <h1>Control panel</h1>
    <div class="individual-buttons">
        <input type="button" value="1" onclick="sendUpdate(1)">
        <input type="button" value="2" onclick="sendUpdate(2)">
        <input type="button" value="3" onclick="sendUpdate(3)">
        <input type="button" value="4" onclick="sendUpdate(4)">
    </div>
    <div class="devices-wrapper">
        <label for="devices">Amount of devices</label>
        <select id="devices" class="devices">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option selected value="4">4</option>
        </select>
    </div>
    <hr>
    <div>
        <label>Iteraties</label><input class="iteration" type="number" value="1">
        <label>Interval</label><input class="interval" type="number" value="0">
        <input id="startButton" type="button" value="start" onclick="startSession()">
    </div>
    <div>
        <h3>Times</h3>
        <ul class="laptimes"></ul>
    </div>
<script>
    const url = '{{ url('/') }}';

    // open connection to channel
    let pusher = new Pusher('298ef029374f89470d24', {
        cluster: 'eu'
    });

    //subscribe to a channel
    let channel = pusher.subscribe('MCL_prototype');

    //listen to event
    channel.bind('toggleStartButton', function (data) {
        enableButtons();
    });

    channel.bind('laptimes', function (data) {
        let laptime = data.laptime;
        appendLapTime(laptime);
    });

    function sendUpdate(id) {
        $.ajax({
            type: 'POST',
            url: url + '/api/push-client-update',
            data: {id: id},
            success: function(){
                console.log('verstuurd');
            }
        });
    }

    function startSession() {
        console.log('startSession');

        $('.laptimes').empty();

        let iterations = $('.iteration').val();
        let interval = $('.interval').val();
        let devices = $('.devices').val();

        disableButtons();

        $.ajax({
            type: 'POST',
            url: url + '/api/start-session',
            data: {
                iterations: iterations,
                interval: interval,
                devices: devices
            },
            success: function(){
                console.log('verstuurd');
            }
        });
    }

    function disableButtons() {
        let buttons = $(':button');
        buttons.prop('disabled', true);
    }

    function enableButtons() {
        let buttons = $(':button');
        buttons.prop('disabled', false);
    }

    function appendLapTime(laptime) {
        let li = document.createElement('li');
        li.innerText = laptime;
        $('.laptimes').append(li);
    }

</script>
    
@endsection
