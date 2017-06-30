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

function qcGetDefects($almClient) {
    $defects = $almClient->getManager()->getBy(AlmEntityManager::ENTITY_TYPE_DEFECT, array(
        'user-89' => 'GLA_auto',
        ));
    return $defects;

}
function qcLogout($almClient) {
    $almClient->getAuthenticator()->logout();
}

?>
