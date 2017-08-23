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

$closedThisWeekCollection = DefectCollection::CreateCollectionCompleteFromDateByTag("CLOSED this week",
    page.'?type=CLOSEDTHISWEEK',
    tag,
    strtotime('Monday this week'));

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
