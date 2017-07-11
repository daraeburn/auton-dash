<?php

require 'config.php';

use StepanSib\AlmClient\AlmClient;
use StepanSib\AlmClient\AlmEntityManager;

class DefectCollection{
    public $collectionTitle;
    public $collectionLink;
    public $defects;

    public function __construct($collectionTitle, $collectionLink, $defects) {
        $this->title = $collectionTitle;
        $this->link = $collectionLink;
        $this->defects = $defects;
    }

    public function getHTML() {
        $html = "<table class='table table-striped'>
        <tr>
        <th>Id</th>
        <th>Name</th>
        <th>State</th>
        <th>Assign To</th>
        </tr>";
        foreach ($this->defects as $defect) {
            $html += "<tr>";
            $html += "<td>" . $defect->id . "</td>";
            $html += "<td>" . $defect->name . "</td>";
            $html += "<td>" . $defect->getParameter('user-23') . "</td>";
            $html += "<td>" . $defect->getParameter('user-02') . "</td>";
        $html += "</tr>";
        }
        $html += "</table>";
        return $html;
    }

    public function getCount() {
        return count($this->defects);
    }
}

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

function qcDoneDefectsThisWeekByTag($almClient, $tag, $doneString) {
    $defects = $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
        'user-89' => $tag,
        'user-23' => $doneString,
        'user-24' => ">=".date('Y-m-d', strtotime('-7 days')),
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
