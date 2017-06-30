<?php
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
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
