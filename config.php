<?php
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

define ("page", $_SERVER['PHP_SELF']);
define ("doneString", 'Closed');
define ("devReqClosedString", "dev-req-closed");
define ("devReqInfoString", "dev-req-info");
define ("newString", "New");
define ("openString", "Open");
define ("readyForTestString", "'Ready%20for%20Test'");
define ("pageRefreshSeconds", 240);
define ("sprintstart", "2017-07-12");
define ("dateformat", "Y-m-d");

if (file_exists(__DIR__ . '/connection_params.php')) {
    require_once __DIR__ . '/connection_params.php';
} else {
    require_once __DIR__ . '/connection_params.default.php';
}
?>
