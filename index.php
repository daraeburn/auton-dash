<?php

require 'defects.php';
require 'ui.php';

 if (isset($_GET['type'])) {
    $type = $_GET['type'];
}else{
    $type = "";
}

$notClosedCollection = DefectCollection::CreateCollectionByTagAndState("Not closed",
    page.'?type=NOTCLOSED',
    'GLA_auto','<>'.doneString);

$backlogCollection = DefectCollection::CreateCollectionByTagAndState("Backlog",
    page.'?type=BACKLOG',
    'GLA_auto',newString);

$devreqinfoCollection = DefectCollection::CreateCollectionByTagAndState("Dev info req",
    page.'?type=DEVREQINFO',
    'GLA_auto',devReqInfoString);

$inProgressCollection = DefectCollection::CreateCollectionByTagAndState("In Progress",
    page.'?type=INPROGRESS',
    'GLA_auto',openString);

$inTestCollection = DefectCollection::CreateCollectionByTagAndState("Dev Complete - In Test",
    page.'?type=WITHREPORTER',
    "GLA_auto",readyForTestString);

$closedThisWeekCollection = DefectCollection::CreateCollectionCompleteFromDateByTag("CLOSED this week",
    page.'?type=CLOSEDTHISWEEK',
    "GLA_auto",
    strtotime('Monday this week'));

$closedThisSprintCollection = DefectCollection::CreateCollectionCompleteFromDateByTag("CLOSED this sprint",
    page.'?type=CLOSEDTHISSPRINT',
    "GLA_auto",
    strtotime(sprintstart));

$devReqClosedThisSprintCollection = DefectCollection::CreateCollectionDevReqClosedByTag("Dev-req-closed this sprint",
    page.'?type=DEVREQCLOSEDSPRINT',
    "GLA_auto");

$readyForTestCollection =  DefectCollection::CreateCollectionReadyForTestByTag("Ready for Test this sprint",
    page.'?type=READYFORTESTSPRINT',
    "GLA_auto");

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
    $closedThisWeekCollection,
);

$overviewCollections = array(

    $closedThisSprintCollection,
    $QADoneCollection,
);

UIhead();
UIdrawTitle();
UIdrawStatusChart();
UIdrawBoxes($collections);
UIdrawBoxes($overviewCollections);

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
        echo $closedThreeWeeksCollection->getHTMLTable();
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
