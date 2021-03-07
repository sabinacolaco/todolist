<?php
require_once 'config/ProcessAPI.php';

try {
    if (isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER']=='apiuser' &&  $_SERVER['PHP_AUTH_PW']=='777') {
        $API = new ProcessAPI($_REQUEST['request']);
        echo $API->processAPI();
    } else {
        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        echo json_encode(Array('status' => 'error', 'message' => 'Access Denied', 'code' => 500));
        exit;
    }
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}
?>