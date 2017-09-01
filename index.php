<?php

require 'defects.php';
require 'ui.php';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
}else{
    $type = "";
}

if (isset($_GET['week_calc_from'])) {
    $week_calc_from = strtotime($_GET['week_calc_from']);
}else{
    $week_calc_from = strtotime('Monday this week');
}

if (isset($_GET['week_calc_to'])) {
    $week_calc_to = strtotime($_GET['week_calc_to']);
}else{
    $week_calc_to = strtotime('now');
}


$notClosedCollection = DefectCollection::CreateCollectionByTagAndState("Not closed",
    page.'?type=NOTCLOSED',
    tag,'<>'.doneString);

$backlogCollection = DefectCollection::CreateCollectionByTagAndState("Backlog",
    page.'?type=BACKLOG',
    tag,newString);

$devreqinfoCollection = DefectCollection::CreateCollectionByTagAndState("Dev-req-info",
    page.'?type=DEVREQINFO',
    tag,devReqInfoString);

$inProgressCollection = DefectCollection::CreateCollectionByTagAndState("Open / In Progress",
    page.'?type=INPROGRESS',
    tag,openString);

$inTestCollection = DefectCollection::CreateCollectionByTagAndState("Dev Complete - In Test",
    page.'?type=WITHREPORTER',
    tag,readyForTestString);

$closedThisWeekCollection = DefectCollection::CreateCollectionCompleteFromDateByTag("CLOSED since ".date("Y-m-d", $week_calc_from),
    page.'?type=CLOSEDTHISWEEK',
    tag,
    $week_calc_from);

$closedThisSprintCollection = DefectCollection::CreateCollectionCompleteFromDateByTag("CLOSED this sprint",
    page.'?type=CLOSEDTHISSPRINT',
    tag,
    strtotime(sprintstart));

$devReqClosedThisSprintCollection = DefectCollection::CreateCollectionDevReqClosedByTag("Dev-req-closed this sprint",
    page.'?type=DEVREQCLOSEDSPRINT',
    tag);

$readyForTestCollection =  DefectCollection::CreateCollectionReadyForTestByTag("Ready for Test",
    page.'?type=READYFORTEST',
    tag);

$QADoneCollection = DefectCollection::CreateCollectionFromExisting("QA Done this sprint (Closed, dev-req-closed or Ready for test)",
    page.'?type=QADONETHISSPRINT',
    "success",
    $devReqClosedThisSprintCollection->defects,
    $readyForTestCollection->defects,
    $closedThisSprintCollection->defects);

$collections = array(
    $backlogCollection,
    $devreqinfoCollection,
    $inProgressCollection,
    $readyForTestCollection,

);

$thisPeriodCollections = array(
    $closedThisWeekCollection,

);

$overviewCollections = array(

    $closedThisSprintCollection,
    $QADoneCollection,
);

UIhead();
UIdrawTitle();
UIdrawStatusChart();
UIdrawBoxes($collections, "Current count");
UIdrawBoxes($thisPeriodCollections, "This Period",true);
UIdrawBoxes($overviewCollections, "This Sprint");

switch ($type) {
    case "CLOSEDTHISWEEK":
        echo $closedThisWeekCollection->getHTMLTable();
        break;
    case "BACKLOG":
        echo $backlogCollection->getHTMLTable();
        break;
    case "INPROGRESS":
        echo $inProgressCollection->getHTMLTable();
        break;
    case "WITHREPORTER":
        echo $waitingOnDevCollection->getHTMLTable();
        break;
    case "CLOSEDTHISSPRINT":
        echo $closedThisSprintCollection->getHTMLTable();
        break;
    case "READYFORTEST":
        echo $readyForTestCollection->getHTMLTable();
        break;
    case "QADONETHISSPRINT":
        echo $QADoneCollection->getHTMLTable();
        break;
    default:
        //echo $notClosedCollection->getHTMLTable();
}
DefectCollection::Logout();

//calculate the total
$backlogCount=$backlogCollection->getCount();
$devreqinfoCount=+$devreqinfoCollection->getCount();
$inProgressCount=$inProgressCollection->getCount();
$readyForTestCount=$readyForTestCollection->getCount();
$total = $backlogCount+$devreqinfoCount+$inProgressCount+$readyForTestCount;

UIdrawFooter(
    ($backlogCount/$total)*100,
    ($devreqinfoCount/$total)*100,
    ($inProgressCount/$total)*100,
    ($readyForTestCount/$total)*100
    );
?>
