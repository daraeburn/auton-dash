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

    $waitingOnDevDefects = qcGetDefectsByTagAndState($almClient,"GLA_auto",urlencode("Ready for Test"));
    $waitingOnDevCount = count($waitingOnDevDefects);
}
head();
drawTitle();
drawCountBoxes($todoCount, $inProgressCount, $waitingOnDevCount);
qcDefectsTable($notClosedDefects);
qcLogout($almClient);
drawFooter();
?>
