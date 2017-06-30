<?php
function drawCountBoxes($todoCount, $inProgressCount, $waitingOnDevCount, $complete) {
echo '<div class="container">
    <!--Row with three equal columns-->
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body"><h2>ToDo</h2><h2>'.$todoCount.'</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body"><h2>In Progress</h2><h2>'.$inProgressCount.'</h2></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body"><h2>With reporter</h2><h2>'.$waitingOnDevCount.'</h2></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body"><h2>Done</h2><h2>'.$complete.'</h2></div>
            </div>
        </div>

    </div>
</div>';
}

function drawTitle() {
echo '<div class="jumbotron">
<h1>Auton Dashboard</h1>
</div>';
}

function head() {
    echo '<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Auton Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional Bootstrap theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>
    <div class="container">';
}

function drawFooter(){
    echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </div>
</body>
</html>';
}
?>