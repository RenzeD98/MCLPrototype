@extends('layout')

@section('content')

    <div class="settings">
        <input type="button" value="1" onclick="setChannel(1)">
        <input type="button" value="2" onclick="setChannel(2)">
        <input type="button" value="3" onclick="setChannel(3)">
        <input type="button" value="4" onclick="setChannel(4)">
    </div>

    <button disabled id="inputButton" class="inputButtonContainer redBackground" style="display: none" onclick="returnInput()">
        <div class="stopwatch"></div>
    </button>

    <script src="{{ URL::asset('js/timer.js') }}"></script>
    <script>

        let jsonData = null;
        const url = '{{ url('/') }}';

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

        function toggleInput() {
            //toggle the state of the inputButton
            let inputButton = $('#inputButton');
            if (inputButton.prop('disabled')) {
                inputButton.prop('disabled', false);

                inputButton.addClass("greenBackground");
                inputButton.removeClass("redBackground");

                //start timer
                stopwatch.start();
            } else {
                inputButton.prop('disabled', true);
                inputButton.addClass("redBackground");
                inputButton.removeClass("greenBackground");
            }
        }

        function returnInput() {
            stopwatch.stop();
            let laptime = stopwatch.lap();
            stopwatch.reset();

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

            toggleInput();
        }

    </script>
@endsection
