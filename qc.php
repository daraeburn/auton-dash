<?php

require 'config.php';

use StepanSib\AlmClient\AlmClient;
use StepanSib\AlmClient\AlmEntityManager;

function qcLogin($connectionParams) {
    $almClient = new AlmClient($connectionParams);

    $almClient->getAuthenticator()->login();

    // lets check if user authenticated successfully
    if ($almClient->getAuthenticator()->isAuthenticated()) {
        return $almClient;    
    }
    return null;
}

function qcGetDefectsByTag($almClient, $tag) {
    $defects = $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
        'user-89' => $tag,
        ));
    return $defects;
}

function qcGetDefectsByTagAndState($almClient, $tag, $state) {
    $defects = $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
        'user-89' => $tag,
        'user-23' => $state,
        ));
    return $defects;
}

function qcLogout($almClient) {
    $almClient->getAuthenticator()->logout();
}

function qcDefectsTable($defects) {
    echo "<table class='table table-striped'>
    <tr>
    <th>Id</th>
    <th>Name</th>
    <th>State</th>
    <th>Assign To</th>
    </tr>";
    foreach ($defects as $defect) {
        echo "<tr>";
        echo "<td>" . $defect->id . "</td>";
        echo "<td>" . $defect->name . "</td>";
        echo "<td>" . $defect->getParameter('user-23') . "</td>";
        echo "<td>" . $defect->getParameter('user-02') . "</td>";
    echo "</tr>";
    }
    echo "</table>";
}
?>
