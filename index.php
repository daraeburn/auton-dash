<?php

require 'qc.php';
require 'ui.php';

 if (isset($_GET['type'])) {
        $type = $_GET['type'];
    }else{
        $type = "";
    }

$almClient = qcLogin($connectionParams);
if ($almClient) {
    $notClosedCollection = new DefectCollection("Not closed", page.'?type="NOTCLOSED"',
        qcGetDefectsByTagAndState($almClient,'GLA_auto','<>'.doneString));
    
    $backlogCollection = new DefectCollection("Backlog",page.'?type="BACKLOG"',
        qcGetDefectsByTagAndState($almClient,'GLA_auto',newString));

    $inProgressCollection= new DefectCollection("In Progress", page.'?type="INPROGRESS"',
        qcGetDefectsByTagAndState($almClient,'GLA_auto',openString));

    $waitingOnDevCollection = new DefectCollection("With Reporter", page.'?type="WITHREPORTER"',
        qcGetDefectsByTagAndState($almClient,"GLA_auto",waitingConfirmationString));

    $closedThisWeekCollection = new DefectCollection("CLOSED this week", page.'?type="CLOSEDTHISWEEK"',
        qcDoneDefectsThisWeekByTag($almClient,"GLA_auto", doneString));

    switch ($type) {
        case "CLOSEDTHISWEEK":
            $defectsToDisplay = $closedThisWeekCollection->defects;
            break;
        case "BACKLOG":
            $defectsToDisplay = $backlogCollection->defects;
            break;
        case "INPROGRESS":
            $defectsToDisplay = $inProgressCollection->defects;
            break;
        case "WITHREPORTER":
            $defectsToDisplay = $waitingOnDevCollection->defects;
            break;
        default:
            $defectsToDisplay = $notClosedCollection->defects;
    }
}
head(pageRefreshSeconds, page);
drawTitle();
drawCountBoxes($backlogCollection->getCount(), $inProgressCollection->getCount(),
    $waitingOnDevCollection->getCount(), $closedThisWeekCollection->getCount());
qcDefectsTable($defectsToDisplay);
qcLogout($almClient);
drawFooter();
?>
