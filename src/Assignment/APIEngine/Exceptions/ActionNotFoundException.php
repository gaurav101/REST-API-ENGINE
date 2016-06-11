<?php
/**
 * Created by PhpStorm.
 * User: aeon
 * Date: 11/06/16
 * Time: 6:26 PM
 */

namespace Assignment\APIEngine\Exceptions;


class ActionNotFoundException extends \Exception {

// Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {

        return (__CLASS__ . ": [{$this->code}]: {$this->message}\n");

    }


}