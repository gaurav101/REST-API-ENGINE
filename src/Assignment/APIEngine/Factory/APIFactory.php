<?php
/**
 * Created by PhpStorm.
 * User: aeon
 * Date: 09/06/16
 * Time: 8:20 PM
 */

namespace Assignment\APIEngine\Factory;
use Assignment\APIEngine\MyAPI;

class APIFactory {

  public static function createAPI($class,$request,$origin){

      switch($class){

          case "MyApi":
              return  new MyAPI($request, $origin);
          default:
              throw new \Exception("Invalid Argument or class not found");
      }

  }



}