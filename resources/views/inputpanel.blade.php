@extends('layout')

@section('content')

    <div class="settings">
        <input type="button" value="1" onclick="setChannel(1)">
        <input type="button" value="2" onclick="setChannel(2)">
        <input type="button" value="3" onclick="setChannel(3)">
        <input type="button" value="4" onclick="setChannel(4)">
    </div>

    <button disabled id="inputButton" class="inputButtonContainer redBackground" style="display: none" onclick="returnInput()">
        <div style="display: none" class="stopwatch"></div>
    </button>

    <script src="{{ URL::asset('js/timer.js') }}"></script>
    <script>

        let jsonData = null;
        const url = '{{ url('/') }}';

        //Set channel id to listen to
        function setChannel(id) {
            // open connection to channel
            var pusher = new Pusher('298ef029374f89470d24', {
                cluster: 'eu'
            });

            //subscribe to a channel
            var channel = pusher.subscribe('MCL_prototype');

            alert('Channel ' + id + ' selected');

            $('.settings').toggle();
            $('.inputButtonContainer').toggle();

            //listen to event
            channel.bind(id, function (data) {
                //if channelgroup MCL_prototype is called with the selected channel id, then toggle input
                jsonData = data.message;
                toggleInput();
            });
        }

        //toggle the userinterface
        function toggleInput() {
            //toggle the state of the inputButton
            let inputButton = $('#inputButton');
            if (inputButton.prop('disabled')) {
                inputButton.prop('disabled', false);

                inputButton.addClass("greenBackground");
                inputButton.removeClass("redBackground");

                //start timer
                toggleStopwatch('start');
                stopwatch.start();
            } else {
                stopwatch.stop();
                stopwatch.reset();

                toggleStopwatch('stop');

                inputButton.prop('disabled', true);
                inputButton.addClass("redBackground");
                inputButton.removeClass("greenBackground");
            }
        }

        function toggleStopwatch(status) {
            let stopwatch = $('.stopwatch');

            if(status === 'start') {
                stopwatch.css('display', 'initial')
            } else {

                stopwatch.each(function() {
                    var elem = $(this);
                    // count the blinks
                    var count = 1;
                    var intervalId = setInterval(function() {
                        if (elem.css('visibility') == 'visible') {
                            elem.css('visibility', 'hidden');
                            // increment counter when showing to count # of blinks and stop when visible
                            if (count++ === 4) {
                                clearInterval(intervalId);
                            }
                        } else {
                            elem.css('visibility', 'visible');
                        }
                    }, 300);
                });
            }
        }

        //return the input back to the api
        function returnInput() {

            let laptime = stopwatch.lap();
            toggleInput();

            if (jsonData !== 'red') {
                jsonData = JSON.parse(jsonData);
                jsonData['laptime'] = laptime;
                jsonData = JSON.stringify(jsonData);

                //return when the input button is clicked
                $.ajax({
                    type: 'POST',
                    url: url + '/api/update-session',
                    data: jsonData,
                    success: function (data) {
                        console.log('click');
                    }
                });
            }


        }

    </script>
@endsection
