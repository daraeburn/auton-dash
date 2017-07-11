<?php

function drawCountBoxes($backlogCount, $inProgressCount, $waitingOnDevCount, $completeThisWeekCount) {
echo '<div class="container">
    <!--Row with three equal columns-->
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Backlog</div>
                <div class="panel-body"><a href="'.page.'?type=BACKLOG">'.$backlogCount.'</a></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">In Progress</div>
                <div class="panel-body"><a href="'.page.'?type=INPROGRESS">'.$inProgressCount.'</a></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">With Reporter</div>
                <div class="panel-body"><a href="'.page.'?type=WITHREPORTER">'.$waitingOnDevCount.'</a></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-success">
                <div class="panel-heading">CLOSED this week</div>
                <div class="panel-body"><a href="'.page.'?type=CLOSEDTHISWEEK">'.$completeThisWeekCount.'</a></div>
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

function head($pageRefreshSeconds, $page) {
    echo '<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="'.$pageRefreshSeconds.';URL='.$page.'">
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