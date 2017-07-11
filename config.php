<?php
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

define ("page", $_SERVER['PHP_SELF']);
define ("doneString", 'Closed');
define ("newString", "New");
define ("openString", "Open");
define ("waitingConfirmationString", "'Ready%20for%20Test'");
define ("pageRefreshSeconds", 240);

if (file_exists(__DIR__ . '/connection_params.php')) {
    require_once __DIR__ . '/connection_params.php';
} else {
    $connectionParams = array(
        'host' => 'http://<default-server>:8080',
        'domain' => '<domain>',
        'project' => '<project>',
        'username' => '<username>',
        'password' => '<password>',
    );
}
?>
