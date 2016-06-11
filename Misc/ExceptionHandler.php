<?php
/**
 * Created by PhpStorm.
 * User: aeon
 * Date: 11/06/16
 * Time: 6:32 PM
 */
function global_exception_handler($exception=null) {
    header("Access-Control-Allow-Orgin: *");
    header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("HTTP/1.0 404 Not Found");
    echo json_encode(array('error'=>  $exception->getMessage()));
}
set_exception_handler('global_exception_handler');