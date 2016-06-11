<?php
/**
 * Created by PhpStorm.
 * User: aeon
 * Date: 09/06/16
 * Time: 9:09 PM
 */

namespace Assignment\Controllers;


class IndexController {

    public function index(){
    echo "hello this is from controller";
    }
    public function my($id){
        echo "hello this is from my controller". $id;
    }

}