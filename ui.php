<?php

function UIdrawBoxOfCollections($collections, $heading, $showDate=false, $containerWidth) {
    // if there are more than four boxes we should split them into rows of 4
    $collectionCount = count($collections);
    if ($collectionCount>=4){
        $width = 3;
    }
    else {
        $width = intdiv(12,$collectionCount);
    }
    
    
    $html= '<div class = "col-md-'.$containerWidth.'">
    <div class = "panel panel-default">
    <div class="panel-heading">'.$heading.'</div>
    <div class="panel-body panel-default ">
    <div class = "col-md-12">';
    if ($showDate) {
        $html .='
        <div class="row col-md-12">
        <form>
            <div class="form-group"> <!-- Date input -->
                <label class="col-md-4 control-label" for="datetimepickerFrom">From</label>
                <div class="col-md-8">
                    <div class="input-group date" id="datetimepickerFrom">
                        <input type="text" class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div> 
            </div>
            <div class="form-group"> <!-- Date input -->   
                <label class="col-md-4 control-label" for="datetimepickerTo">To</label>
                <div class="col-md-8">
                    <div class="input-group date" id="datetimepickerTo">
                        <input type="text" class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary col-md-4" id="refresh" name="refresh">Refresh</button>
            </form>
        </div>';
    }
    $html .= '<!--Row with equal columns-->
    <div class="row col-sm-12 top-buffer">';
    foreach($collections as $collection){
        $html.='<div class="col-md-'.$width.'">
        <div class="panel panel-'.$collection->color.'">
                    <div class="panel-heading">'.$collection->title.'</div>
                    <div class="panel-body"><a href="'.$collection->link.'">'.$collection->getCount().'</a></div>
                    </div>                
                    </div>';
    }
    $html.='</div>
        </div>
        </div>
        </div>
        </div>';
    echo $html;
}

function UIdrawMainTitle() {
    echo '<table style="width: 100%;">
        <tr><td><h1>Auton Dashboard</h1></td>
        <td class="pull-right"><h1>Sprint '.sprintnumber.': start - '.sprintstart.'</h1></td></tr>
        </table>';
}

function UIMainHead() {
    echo '<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Auton Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/2.18.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
       
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cerulean/bootstrap.min.css" rel="stylesheet" integrity="sha384-zF4BRsG/fLiTGfR9QL82DrilZxrwgY/+du4p/c7J72zZj+FLYq4zY00RylP9ZjiT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="custom.css">
    </head>
<body>
    <div id="mainContainer" class="container">';
}

function UIdrawMainFooter($backlog,$devreqinfo,$inprogress,$readyForTest,$period_calc_from,$period_calc_to){
    echo'';
    echo '<script>

        $(document).ready(function(){
            var dateFrom= new Date("'.$period_calc_from.'");
            var dateTo= new Date("'.$period_calc_to.'");

            var currentRoot = window.location.href.split("?")[0] 

            var el = document.getElementById("refresh");
            
            el.addEventListener("click", function() {
                window.location.href = currentRoot+
                    "?period_calc_from="+
                    $("#datetimepickerFrom").data("DateTimePicker").date().format("YYYY-MM-DD")+
                    "&period_calc_to="+
                    $("#datetimepickerTo").data("DateTimePicker").date().format("YYYY-MM-DD");
                return false;
            });
            
            $("#datetimepickerFrom").datetimepicker({
                format: "YYYY-MM-DD",
                useCurrent: false, //Important! See issue #1075
                defaultDate: dateFrom
            });

            $("#datetimepickerTo").datetimepicker({
                format: "YYYY-MM-DD",
                useCurrent: false, //Important! See issue #1075
                defaultDate: dateTo
            });

            $("#datetimepickerFrom").on("dp.change", function (e) {
                $("#datetimepickerTo").data("DateTimePicker").minDate(e.date);
            });
            $("#datetimepickerTo").on("dp.change", function (e) {
                $("#datetimepickerFrom").data("DateTimePicker").maxDate(e.date);
            });

            $("#defects").DataTable({
                "scrollX": true,
                "pageLength": 5
            });';
            
            echo 'var chart = new CanvasJS.Chart("chartContainer",
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
            chart.render();';

            echo '});
            </script>';
      echo '</div>
</body>
</html>';
}

function UIdrawStatusChart($containerWidth){
    echo '<div class="col-md-'.$containerWidth.'">';
    echo '<div id="chartContainer" class="panel panel-default " style="height: 300px;"></div>';
    echo '</div>';
}

function UIDefectHead() {
    echo '<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Auton Defect detail</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/2.18.1/moment.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wysihtml5/0.3.0/wysihtml5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/locales/bootstrap-wysihtml5.en-US.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.css"></style>
    

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.css"></style>

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

function UIdrawDefectTitle($defect) {
    echo '<table style="width: 100%;">
        <tr><td><h1>Defect detail - '.$defect->id.'</h1></td>
        <td class="pull-right"><h1>Auton Details</h1></td></tr>
        </table>';
}

function UIdrawDetailFooter($defectid){
    echo'';
    echo '<script>

    function goBack() {
        window.history.back();
    }

    $(document).ready(function(){

        $("#description").wysihtml5();

        $(".button").click(function(){
            var clickBtnValue = $(this).val();
            var ajaxurl = "ajax.php",
            data =  {"action": clickBtnValue,
                "defectid": '.$defectid.',
                "createdDate": document.getElementById("dCreatedDate").value,
                "name": document.getElementById("summary").value};
            $.post(ajaxurl, data, function (response) {
                // Response div goes here.
                alert("action performed successfully");
            });
        });
    });
    </script>
</div>
</body>
</html>';
}

?>