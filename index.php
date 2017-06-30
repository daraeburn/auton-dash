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

    $completeDefects = qcGetDefectsByTagAndState($almClient,"GLA_auto",$doneString);
    $completeCount = count($completeDefects);
}
head($pageRefreshSeconds, $page);
drawTitle();
drawCountBoxes($todoCount, $inProgressCount, $waitingOnDevCount, $completeCount);
qcDefectsTable($notClosedDefects);
qcLogout($almClient);
drawFooter();
?>
