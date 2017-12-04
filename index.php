<?php

require 'defects.php';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
}else{
    $type = "";
}

if (isset($_GET['period_calc_from'])) {
    $period_calc_from = $_GET['period_calc_from'];
}else{
    $period_calc_from = date(dateformat, strtotime('last Tuesday'));
}

if (isset($_GET['period_calc_to'])) {
    $period_calc_to = $_GET['period_calc_to'];
}else{
    $period_calc_to = date(dateformat, strtotime('now'));
}


//$notClosedCollection = DefectCollection::CreateCollectionByTagAndState("Not closed",
//    page.'?type=NOTCLOSED',
//    tag,'<>'.doneString);

$backlogCollection = DefectCollection::CreateCollectionByTagAndState("Backlog",
    page.'?type=BACKLOG',
    tag,newString);

$devreqinfoCollection = DefectCollection::CreateCollectionByTagAndState("Dev-req-info",
    page.'?type=DEVREQINFO',
    tag,devReqInfoString);

$devreqclosedCollection = DefectCollection::CreateCollectionByTagAndState("Dev-req-closed",
    page.'?type=DEVREQCLOSED',
    tag,devReqClosedString);

$inProgressCollection = DefectCollection::CreateCollectionByTagAndState("In Progress",
    page.'?type=INPROGRESS',
    tag,openString);

$inTestCollection = DefectCollection::CreateCollectionByTagAndState("Dev Complete - In Test",
    page.'?type=WITHREPORTER',
    tag,readyForTestString);

$closedThisPeriodCollection = DefectCollection::CreateCollectionCompleteFromDateByTag("CLOSED",
    page.'?type=CLOSEDTHISPERIOD&period_calc_from='.$period_calc_from.'&period_calc_to='.$period_calc_to,
    tag,
    strtotime($period_calc_from),
    strtotime($period_calc_to));

$openedThisPeriodCollection = DefectCollection::CreateCollectionOpenedFromDateByTag("OPENED",
    page.'?type=OPENEDTHISPERIOD&period_calc_from='.$period_calc_from.'&period_calc_to='.$period_calc_to,
    tag,
    strtotime($period_calc_from),
    strtotime($period_calc_to));


$closedThisSprintCollection = DefectCollection::CreateCollectionCompleteFromDateByTag("CLOSED",
    page.'?type=CLOSEDTHISSPRINT',
    tag,
    strtotime(sprintstart),
    strtotime('now'));

$devReqClosedThisSprintCollection = DefectCollection::CreateCollectionDevReqClosedByTag("Dev-req-closed this sprint",
    page.'?type=DEVREQCLOSEDSPRINT',
    tag);

$readyForTestCollection =  DefectCollection::CreateCollectionReadyForTestByTag("Ready for Test",
    page.'?type=READYFORTEST',
    tag);

$QADoneCollection = DefectCollection::CreateCollectionFromExisting("QA Done",
    page.'?type=QADONETHISSPRINT',
    "success",
    $devReqClosedThisSprintCollection->defects,
    $readyForTestCollection->defects,
    $closedThisSprintCollection->defects);

$collections = array(
    $backlogCollection,
    $devreqinfoCollection,
    $inProgressCollection,
    $devreqclosedCollection,
    $readyForTestCollection,
);

$thisPeriodCollections = array(
    $openedThisPeriodCollection,
    $closedThisPeriodCollection,
);

$overviewCollections = array(
    $closedThisSprintCollection,
    $QADoneCollection,
);

UIMainhead();
UIdrawMainTitle();
echo '<div class="row">';
UIdrawStatusChart(3);
UIdrawBoxOfCollections($collections, "Current count",false,6);
UIdrawBoxOfCollections($overviewCollections, "This Sprint",false,3);
echo '</div>';
echo '<div class="row">';
UIdrawBoxOfCollections($thisPeriodCollections, "This Period",true,3);

$tableWidth=9;
switch ($type) {
    case "CLOSEDTHISPERIOD":
        echo $closedThisPeriodCollection->getHTMLTable($tableWidth);
        break;
    case "OPENEDTHISPERIOD":
        echo $openedThisPeriodCollection->getHTMLTable($tableWidth);
        break;
    case "BACKLOG":
        echo $backlogCollection->getHTMLTable($tableWidth);
        break;
    case "INPROGRESS":
        echo $inProgressCollection->getHTMLTable($tableWidth);
        break;
    case "WITHREPORTER":
        echo $waitingOnDevCollection->getHTMLTable($tableWidth);
        break;
    case "CLOSEDTHISSPRINT":
        echo $closedThisSprintCollection->getHTMLTable($tableWidth);
        break;
    case "READYFORTEST":
        echo $readyForTestCollection->getHTMLTable($tableWidth);
        break;
    case "QADONETHISSPRINT":
        echo $QADoneCollection->getHTMLTable($tableWidth);
        break;
    case "DEVREQCLOSED":
        echo $devreqclosedCollection->getHTMLTable($tableWidth);
        break;
    default:
        //echo $notClosedCollection->getHTMLTable();
}
echo '</div>';
DefectCollection::Logout();

//calculate the total
$backlogCount=$backlogCollection->getCount();
$devreqinfoCount=+$devreqinfoCollection->getCount();
$inProgressCount=$inProgressCollection->getCount();
$readyForTestCount=$readyForTestCollection->getCount();
$total = $backlogCount+$devreqinfoCount+$inProgressCount+$readyForTestCount;

UIdrawMainFooter(
    ($backlogCount/$total)*100,
    ($devreqinfoCount/$total)*100,
    ($inProgressCount/$total)*100,
    ($readyForTestCount/$total)*100,
    $period_calc_from,
    $period_calc_to
    );

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

        function refreshClicked() {
            var currentRoot = window.location.href.split("?")[0] 
            var el = document.getElementById("refreshDate");
        
            var newUrl = currentRoot+
            "?period_calc_from="+
            $("#datetimepickerFrom").data("DateTimePicker").date().format("YYYY-MM-DD")+
            "&period_calc_to="+
            $("#datetimepickerTo").data("DateTimePicker").date().format("YYYY-MM-DD")
            window.location.replace(newUrl);
            return false;
        };

        $(document).ready(function(){
            var dateFrom= new Date("'.$period_calc_from.'");
            var dateTo= new Date("'.$period_calc_to.'");
            
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

function UIdrawMainTitle() {
    echo '<table style="width: 100%;">
        <tr><td><h1>Auton Dashboard</h1></td>
        <td class="pull-right"><h1>Sprint '.sprintnumber.': start - '.sprintstart.'</h1></td></tr>
        </table>';
}

function UIdrawStatusChart($containerWidth){
    echo '<div class="col-md-'.$containerWidth.'">';
    echo '<div id="chartContainer" class="panel panel-default " style="height: 300px;"></div>';
    echo '</div>';
}

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
            <button type="button" class="btn btn-primary col-md-4" id="refreshDates" name="refreshDates" onclick="refreshClicked()">Refresh</button>
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

?>
