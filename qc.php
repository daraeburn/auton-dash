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

    public function __construct($title, $link, $defects,$color) {
        $this->title = $title;
        $this->link = $link;
        $this->defects = $defects;
        $this->color = $color;
    }

    public function getHTMLTable() {
        $html="<h2>".$this->title."</h2>";
        $html .= "<table id='defects' class='table table-striped table-bordered table-hover'>
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

    static function CreateCollectionThisWeekByTag($title, $link, $tag, $doneString) {
        $almClient = self::GetAlmClient();
        $collection = new DefectCollection($title, $link, $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
            'user-89' => $tag,
            'user-23' => $doneString,
            'user-24' => ">=".date('Y-m-d', strtotime('Monday this week')),
        )),"success");
        return $collection;
    }

    static function CreateCollectionThreeWeeksByTag($title, $link, $tag, $doneString) {
        $almClient = self::GetAlmClient();
        $collection = new DefectCollection($title, $link, $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
            'user-89' => $tag,
            'user-23' => $doneString,
            'user-24' => ">=".date('Y-m-d', strtotime(sprintstart)),
        )),"success");
        return $collection;
    }

    static function Logout() {
        self::$almClient->getAuthenticator()->logout();
    }

}
?>
