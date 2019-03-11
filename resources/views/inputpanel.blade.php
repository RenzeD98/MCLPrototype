<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
</head>
<body>

<div class="settings">
    <input type="button" value="1" onclick="setChannel(1)">
    <input type="button" value="2" onclick="setChannel(2)">
    <input type="button" value="3" onclick="setChannel(3)">
    <input type="button" value="4" onclick="setChannel(4)">
</div>

<div class="inputButtonContainer" style="display: none">
    <input disabled id="inputButton" type="button" value="click" onclick="returnInput()">
</div>

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

        // document.getElementsByClassName("settings").style.display = "none";
        // document.getElementById("inputButton").style.display = "block";


        //listen to event
        channel.bind(id, function (data) {
            //if channelgroup MCL_prototype is called with the selected channel id, then toggle input
            jsonData = data.message;
            toggleInput();

            // alert('An event was triggered with message: ' + data.message);
        });
    }

    function toggleInput() {
        //toggle the state of the inputButton
        var inputButton = $('#inputButton');
        if (inputButton.prop('disabled')) {
            inputButton.prop('disabled', false);
            inputButton.css('background-color', 'green');
        } else {
            inputButton.prop('disabled', true);
            inputButton.css('background-color', 'red');
        }
    }

    function returnInput() {
        //return when the input button is clicked
        console.log('click');
        $.ajax({
            type: 'POST',
            url: url + '/api/update-session',
            data: {data: jsonData},
            success: function (data) {
                toggleInput();
            }
        });
    }

</script>
</body>
</html>
