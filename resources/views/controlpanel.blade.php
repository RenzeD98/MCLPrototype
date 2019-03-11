<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Scripts -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
</head>
<body>
    <h1>Controllpanel</h1>
    <div class="individual-buttons">
        <input type="button" value="1" onclick="sendUpdate(1)">
        <input type="button" value="2" onclick="sendUpdate(2)">
        <input type="button" value="3" onclick="sendUpdate(3)">
        <input type="button" value="4" onclick="sendUpdate(4)">
    </div>
    <hr>
    <div>
        <label>Iteraties  </label><input class="iteration" type="number" value="1"><br>
        <label>Interval  </label><input class="interval" type="number" value="0"><br>
        <input type="button" value="start" onclick="startSession()">
    </div>


<script>
    var url = '{{ url('/') }}';

    function sendUpdate(id) {
        $.ajax({
            type: 'POST',
            url: url + '/api/push-client-update',
            data: {id: id},
            dataType: 'JSON',
            success: function(){
                console.log('verstuurd');
            }
        });
    }
    
    function startSession() {
        var iterations = $('.iteration').val();
        var interval = $('.interval').val();

        $.ajax({
            type: 'POST',
            url: url + '/api/start-session',
            data: {
                iterations: iterations,
                interval: interval
            },
            dataType: 'JSON',
            success: function(){
                console.log('verstuurd');
            }
        });
    }

</script>
</body>
</html>
