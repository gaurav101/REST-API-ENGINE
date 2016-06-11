<?php
/**
 * Created by PhpStorm.
 * User: aeon
 * Date: 09/06/16
 * Time: 5:49 PM
 */

namespace Assignment\Models;


class User {

    public $name;

    private $token="My private key";

    public function get($key,$value){

        if($key=='token'){
            return $key;
        }


    }
}