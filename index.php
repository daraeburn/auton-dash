<?php

require 'qc.php';
require 'ui.php';

 if (isset($_GET['type'])) {
    $type = $_GET['type'];
}else{
    $type = "";
}

$notClosedCollection = DefectCollection::CreateCollectionByTagAndState("Not closed", page.'?type=NOTCLOSED',
    'GLA_auto','<>'.doneString);

$backlogCollection = DefectCollection::CreateCollectionByTagAndState("Backlog",page.'?type=BACKLOG',
    'GLA_auto',newString);

$inProgressCollection = DefectCollection::CreateCollectionByTagAndState("In Progress", page.'?type=INPROGRESS',
    'GLA_auto',openString);

$waitingOnDevCollection = DefectCollection::CreateCollectionByTagAndState("With Reporter", page.'?type=WITHREPORTER',
    "GLA_auto",waitingConfirmationString);

$closedThisWeekCollection = DefectCollection::CreateCollectionThisWeekByTag("CLOSED this week", page.'?type=CLOSEDTHISWEEK',
    "GLA_auto", doneString);

$closedThreeWeeksCollection = DefectCollection::CreateCollectionThreeWeeksByTag("CLOSED this sprint", page.'?type=CLOSEDTHREEWEEKS',
    "GLA_auto", doneString);

$collections = array(
    $notClosedCollection,
    $backlogCollection,
    $inProgressCollection,
    $waitingOnDevCollection,
    $closedThisWeekCollection,
    $closedThreeWeeksCollection,
);

UIhead();
UIdrawTitle();
UIdrawBoxes($collections);
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
    case "CLOSEDTHREEWEEKS":
        echo $closedThreeWeeksCollection->getHTMLTable();
        break;
    default:
        echo $notClosedCollection->getHTMLTable();
}
DefectCollection::Logout();
UIdrawFooter();
?>
