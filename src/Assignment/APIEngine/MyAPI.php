<?php
/**
 * Created by PhpStorm.
 * User: aeon
 * Date: 09/06/16
 * Time: 5:31 PM
 */

namespace Assignment\APIEngine;
use Assignment\APIEngine\Generic\API;
use Assignment\Models\APIKey;
use Assignment\Models\User;
use MySqlConnector\Database\Database;
class MyAPI extends API
{
    protected $User;

    public function __construct($request, $origin) {

        parent::__construct($request);

        // Abstracted out for example
        $APIKey = new APIKey();

        $User = new User();

        $db=Database::getInstance();

        $db->getConnection();

        if (!array_key_exists('apiKey', $this->request)) {

            throw new \Exception('No API Key provided');

        } else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {

            throw new \Exception('Invalid API Key');

        } else if (array_key_exists('token', $this->request) &&

            !$User->get('token', $this->request['token'])) {

            throw new \Exception('Invalid User Token');
        }

        $this->User = $User;
    }

    /**
     * Example of an Endpoint
     */
    protected function example() {
        if ($this->method == 'GET') {
            return "Your name is " . $this->User->name;
        } else {
            return "Only accepts GET requests";
        }
    }
}
