<?php

require 'defects.php';

use StepanSib\AlmClient\AlmClient;
use StepanSib\AlmClient\AlmEntityManager;

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'update':
            update();
            break;
    }
}

function update() {

    if (isset($_POST['defectid'])) {
        $defectid = $_POST['defectid'];
    }else{
        $defectid = 0;
    }
    if (isset($_POST['createdDate'])) {
        $createdDate = $_POST['createdDate'];
    }else{
        $createdDate = 0;
    }
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
    }else{
        $name = "";
    }

    if ($defectid!=0 && $createdDate != 0 && $name!=""){
        $defect = DefectCollection::GetDefectByID($defectid);
        $defect->setParameter('name', $name);
        print_r($defect);
        DefectCollection::SaveDefect($defect);
        DefectCollection::Logout();
        echo "The insert function is called.";
    }
    
    exit;
}
?>