<?php

function UIdrawBoxes($collections, $heading, $showDate=false) {
    $width = intdiv(12,count($collections));
    
    $html= '<div class = "panel panel-default">
    <div class="panel-heading">'.$heading.'</div>';
    if ($showDate) {
        $html .='
        <div class="row">
        <div class="form-group"> <!-- Date input -->
            <label class="col-md-2 control-label" for="datetimepicker2">From Date</label>
            <div class="col-md-2">
                <div class="input-group date" id="datetimepicker2">
                    <input type="text" class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>    
        </div>
        <div class="form-group"> <!-- Date input -->
            <label class="col-md-2 control-label" for="datetimepicker1">To Date</label>
            <div class="col-md-2">
                <div class="input-group date" id="datetimepicker1">
                    <input type="text" class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group"> <!-- Submit button -->
                <button class="btn btn-primary " name="submit" type="submit">Submit</button>
            </div>
        </div>
        </div>';
    }
    $html .= '<div class = "panel-body container">
    <!--Row with four equal columns-->
    <div class="row">';
    foreach($collections as $collection){
        $html.='    <div class="col-md-'.$width.'">
            <div class="panel panel-'.$collection->color.'">
                <div class="panel-heading">'.$collection->title.'</div>
                    <div class="panel-body"><a href="'.$collection->link.'">'.$collection->getCount().'</a></div>
                </div>
            </div>';
    }
    $html.='</div>
        </div>
        </div>';
    echo $html;
}

function UIdrawTitle() {
    echo '<table style="width: 100%;">
        <tr><td><h1>Sprint '.sprintnumber.' start - '.sprintstart.'</h1></td>
        <td class="pull-right"><h1>Auton Dashboard</h1></td></tr>
        </table>';
}

function UIhead() {
    echo '<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="'.pageRefreshSeconds.';URL='.page.'">
    <title>Auton Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/2.18.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="custom.css">
    <!-- Optional Bootstrap theme -->
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cerulean/bootstrap.min.css" rel="stylesheet" integrity="sha384-zF4BRsG/fLiTGfR9QL82DrilZxrwgY/+du4p/c7J72zZj+FLYq4zY00RylP9ZjiT" crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"/>
    </head>
<body>
    <div class="container">';
}

function UIdrawFooter($backlog,$devreqinfo,$inprogress,$readyForTest){
    echo'';
    echo '<script>
        $(function(){
            $("#datetimepicker1").datetimepicker({
                format: "YYYY-MM-DD",
                useCurrent: true
            });
            
            $("#datetimepicker2").datetimepicker({
                format: "YYYY-MM-DD",
                useCurrent: false //Important! See issue #1075
            });

            $("#datetimepicker2").on("dp.change", function (e) {
                $("#datetimepicker1").data("DateTimePicker").minDate(e.date);
            });
            $("#datetimepicker1").on("dp.change", function (e) {
                $("#datetimepicker2").data("DateTimePicker").maxDate(e.date);
            });

            $("#defects").dataTable();
            
             var chart = new CanvasJS.Chart("chartContainer",
                {
                title:{
                    text: "Current defect status"
                },
                data: [
                {
                type: "doughnut",
                dataPoints: [
                {  y: '.$backlog.', indexLabel: "Backlog" },
                {  y: '.$devreqinfo.', indexLabel: "dev-req-info" },
                {  y: '.$inprogress.', indexLabel: "In Progress" },
                {  y: '.$readyForTest.', indexLabel: "Ready for Test" }
                ]
                }
                ]
            });

            chart.render();

            });
            </script>';
      echo '</div>
</body>
</html>';
}

function UIdrawStatusChart(){
    echo'';
    echo '<div id="chartContainer" style="height: 300px; width: 100%;"></div>';
}
?>