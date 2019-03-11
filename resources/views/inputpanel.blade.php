<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
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

    <div class="inputButton">
        <input type="button" value="click" onclick="returnInput()">
    </div>

    <script>

        function setChannel(id) {
            // open connection to channel
            var pusher = new Pusher('298ef029374f89470d24', {
                cluster: 'eu'
            });

            //subscribe to a channel
            var channel = pusher.subscribe('MCL_prototype');


            //listen to event
            channel.bind(id, function (data) {
                //if channelgroup MCL_prototype is called with the selected channel id, then toggle input
                // toggleInput();

                alert('An event was triggered with message: ' + data.message);
            });
        }

        function toggleInput(){
            //toggle the state of the inputButton

        }

        function returnInput() {
            //return when the input button is clicked

        }

    </script>
</body>
</html>
