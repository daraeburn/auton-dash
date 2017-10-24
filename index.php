<?php

require 'defects.php';
require 'ui.php';

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

$inProgressCollection = DefectCollection::CreateCollectionByTagAndState("Open/In Progress",
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
UIdrawBoxOfCollections($thisPeriodCollections, "This Period",true,4);

$tableWidth=8;
switch ($type) {
    case "CLOSEDTHISPERIOD":
        echo $closedThisPeriodCollection->getHTMLTable($tableWidth);
        break;
    case "OPENEDTHISPERIOD":
        echo $openedThisPeriodCollection->getHTMLTable($tableWidth);
        break;
    case "BACKLOG":
        echo $backlogCollection->getHTMLTable($tableWidth6);
        break;
    case "INPROGRESS":
        echo $inProgressCollection->getHTMLTable($tableWidth);
        break;
    case "WITHREPORTER":
        echo $waitingOnDevCollection->getHTMLTable($tableWidth);
        break;
    case "CLOSEDTHISSPRINT":
        echo $closedThisSprintCollection->getHTMLTable($tableWidth6);
        break;
    case "READYFORTEST":
        echo $readyForTestCollection->getHTMLTable($tableWidth);
        break;
    case "QADONETHISSPRINT":
        echo $QADoneCollection->getHTMLTable($tableWidth);
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
?>
