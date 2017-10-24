<?php

require 'config.php';

use StepanSib\AlmClient\AlmClient;
use StepanSib\AlmClient\AlmEntityManager;

class DefectCollection{
    static private $almClient;
    public $title;
    public $link;
    public $defects;
    public $color;

    public static function GetAlmClient(){
        if (is_null(self::$almClient)) {
            self::$almClient=self::qclogin();
        }
        return self::$almClient;
    }

    function __construct() 
    { 
        $a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
    } 

    public function __construct4($title, $link, $defects,$color) {
        $this->title = $title;
        $this->link = $link;
        $this->defects = $defects;
        $this->color = $color;
    }

    public function __construct6($title, $link, $color, $col1, $col2, $col3) {
        $this->title = $title;
        $this->link = $link;
        $this->defects = array_merge($col1, $col2, $col3);
        $this->color = $color;
    }

    public function getHTMLTable($containerWidth) {
        $html= '<div class = "col-md-'.$containerWidth.'">
        <div class = "panel panel-default">
        <div class="panel-heading">'.$this->title.'</div>
        <div class="panel-body">
        <div class = "col-md-12">';
        $html .= "<table id='defects' class='table table-striped table-bordered table-hover table-sm' size='100%'>
        <thead>
        <tr>
        <th>Id</th>
        <th>Name</th>
        <th>State</th>
        <th>Assign To</th>
        <th>Created Date</th>
        <th>Created By</th>
        <th>Closed date</th>
        </tr>
        </thead>
        <tbody>";
        foreach ($this->defects as $defect) {
            $html .= "<tr>";
            $html .= "<td><a href='/auton-dash/defectdetail.php?defectid=".$defect->id."'>" . $defect->id . "</td>";
            $html .= "<td>" . $defect->name . "</td>";
            $html .= "<td>" . $defect->getParameter('user-23') . "</td>";
            $html .= "<td>" . $defect->getParameter('user-02') . "</td>";
            $html .= "<td>" . $defect->getParameter('creation-time') . "</td>";
            $html .= "<td>" . $defect->getParameter('detected-by') . "</td>";
            $entityParameters=$defect->getParameters();
            if (array_key_exists("user-24",$entityParameters))
                $html .= "<td>".$defect->{'user-24'}."</td>";
            else
                $html .= "<td></td>";
        $html .= "</tr>";
        }
        $html .= "</tbody></table>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</div>";
        return $html;
    }

    public function getCount() {
        return count($this->defects);
    }

    private static function qcLogin() {
        $connectionParams = array(
            'host' => qcHost,
            'domain' => qcDomain,
            'project' => qcProject,
            'username' => qcUsername,
            'password' => qcPassword,
        );
        $almClient = new AlmClient($connectionParams);

        $almClient->getAuthenticator()->login();

        // lets check if user authenticated successfully
        if ($almClient->getAuthenticator()->isAuthenticated()) {
            return $almClient;    
        }
        return null;
    }

    static function GetDefectByID($defectid) {
        $almClient = self::GetAlmClient();
        $entity = $almClient->getManager()->getOneBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
            'id' => $defectid,
        ));
        return $entity;
    }

    static function CreateCollectionByTag($title, $link, $tag) {
        $almClient = self::GetAlmClient();
        $collection = new DefectCollection($title, $link, $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
            'user-89' => $tag,
        )),"primary");
        return $collection;
    }
    static function CreateCollectionByTagAndState($title, $link, $tag, $state) {
        $almClient = self::GetAlmClient();
        $collection = new DefectCollection($title, $link, $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
            'user-89' => $tag,
            'user-23' => $state,
        )),"primary");
        return $collection;
    }

    static function CreateCollectionCompleteFromDateByTag($title, $link, $tag, $fromDate, $toDate) {
        $almClient = self::GetAlmClient();
        $collection = new DefectCollection($title, $link, $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
            'user-89' => $tag,
            'user-23' => doneString,
            'user-24' => ">=".date(dateformat, $fromDate)."%20AND%20<=".date(dateformat, $toDate),
        )),"success");
        return $collection;
    }

    static function CreateCollectionOpenedFromDateByTag($title, $link, $tag, $fromDate, $toDate) {
        $almClient = self::GetAlmClient();
        $collection = new DefectCollection($title, $link, $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
            'user-89' => $tag,
//            'user-23' => openString,
            'creation-time' => ">=".date(dateformat, $fromDate)."%20AND%20<=".date(dateformat, $toDate),
        )),"success");
        return $collection;
    }

    static function CreateCollectionDevReqClosedByTag($title, $link, $tag) {
        $almClient = self::GetAlmClient();
        $collection = new DefectCollection($title, $link, $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
            'user-89' => $tag,
            'user-23' => devReqClosedString,
        )),"success");
        return $collection;
    }

    static function CreateCollectionReadyForTestByTag($title, $link, $tag) {
        $almClient = self::GetAlmClient();
        $collection = new DefectCollection($title, $link, $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
            'user-89' => $tag,
            'user-23' => readyForTestString,
        )),"success");
        return $collection;
    }

    public static function CreateCollectionFromExisting($title, $link, $color, $col1, $col2, $col3) {
        $almClient = self::GetAlmClient();
        $collection = new DefectCollection($title, $link, $color, $col1, $col2, $col3);
        return $collection;
    }

    static function Logout() {
        self::$almClient->getAuthenticator()->logout();
    }

    static function SaveDefect($defect) {
        $almClient = self::GetAlmClient();
        $almClient->getManager()->save($defect);
    }
}
?>
