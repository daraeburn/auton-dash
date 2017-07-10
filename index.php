<?php

require 'qc.php';
require 'ui.php';


$almClient = qcLogin($connectionParams);
if ($almClient) {
    $notClosedDefects = qcGetDefectsByTagAndState($almClient,'GLA_auto','<>'.$doneString);

    $todoDefects = qcGetDefectsByTagAndState($almClient,'GLA_auto',$newString);
    $todoCount = count($todoDefects);

    $inProgressDefects = qcGetDefectsByTagAndState($almClient,'GLA_auto',$openString);
    $inProgressCount = count($inProgressDefects);

    $waitingOnDevDefects = qcGetDefectsByTagAndState($almClient,"GLA_auto",$waitingConfirmationString);
    $waitingOnDevCount = count($waitingOnDevDefects);

    $completeDefectsThisWeek = qcDoneDefectsThisWeekByTag($almClient,"GLA_auto", $doneString);
    $completeThisWeekCount = count($completeDefectsThisWeek);
}
head($pageRefreshSeconds, $page);
drawTitle();
drawCountBoxes($todoCount, $inProgressCount, $waitingOnDevCount, $completeThisWeekCount);
qcDefectsTable($notClosedDefects);
qcLogout($almClient);
drawFooter();
?>
