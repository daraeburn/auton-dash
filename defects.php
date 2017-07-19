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

    public function getHTMLTable() {
        $html="<h2>".$this->title."</h2>";
        $html .= "<table id='defects' class='table table-striped table-bordered table-hover table-sm'>
        <thead>
        <tr>
        <th>Id</th>
        <th>Name</th>
        <th>State</th>
        <th>Assign To</th>
        </tr>
        </thead>
        <tbody>";
        foreach ($this->defects as $defect) {
            $html .= "<tr>";
            $html .= "<td>" . $defect->id . "</td>";
            $html .= "<td>" . $defect->name . "</td>";
            $html .= "<td>" . $defect->getParameter('user-23') . "</td>";
            $html .= "<td>" . $defect->getParameter('user-02') . "</td>";
        $html .= "</tr>";
        }
        $html .= "</tbody></table>";
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

    static function CreateCollectionCompleteFromDateByTag($title, $link, $tag, $fromDate) {
        $almClient = self::GetAlmClient();
        $collection = new DefectCollection($title, $link, $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
            'user-89' => $tag,
            'user-23' => doneString,
            'user-24' => ">=".date(dateformat, $fromDate),
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

}
?>
