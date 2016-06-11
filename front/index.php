<?php
/**
 * Created by PhpStorm.
 * User: aeon
 * Date: 09/06/16
 * Time: 9:06 PM
 */
require_once "../vendor/autoload.php";


use Assignment\Controllers\Engine\FrontController\FrontController;
$frontController = new FrontController();
$frontController->run();