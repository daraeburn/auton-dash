<?php
require 'qc.php';
require 'ui.php';



$almClient = qcLogin($connectionParams);
if ($almClient) {
    $notClosedDefects = qcGetDefectsByTagAndState($almClient,'GLA_auto','<>Closed');

    $todoDefects = qcGetDefectsByTagAndState($almClient,'GLA_auto','New');
    $todoCount = count($todoDefects);

    $inProgressDefects = qcGetDefectsByTagAndState($almClient,'GLA_auto','Open');
    $inProgressCount = count($inProgressDefects);

    $waitingOnDevDefects = qcGetDefectsByTagAndState($almClient,"GLA_auto","'Ready%20for%20Test'");
    $waitingOnDevCount = count($waitingOnDevDefects);

    $completeDefects = qcGetDefectsByTagAndState($almClient,"GLA_auto","Closed");
    $completeCount = count($completeDefects);
}
head();
drawTitle();
drawCountBoxes($todoCount, $inProgressCount, $waitingOnDevCount, $completeCount);
qcDefectsTable($notClosedDefects);
qcLogout($almClient);
drawFooter();
?>
