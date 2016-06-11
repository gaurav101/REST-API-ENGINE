<?php
/**
 * Created by PhpStorm.
 * User: aeon
 * Date: 09/06/16
 * Time: 9:02 PM
 */

namespace Assignment\Controllers\Engine\FrontController;

use Assignment\Controllers\Engine\FrontControllerInterface\FrontControllerInterface;
use Assignment\Controllers\IndexController;
use Assignment\APIEngine\Exceptions\ControllerNotFoundException;
use Assignment\APIEngine\Exceptions\ActionNotFoundException;
class FrontController implements FrontControllerInterface {

    const DEFAULT_CONTROLLER = "Index";
    const DEFAULT_ACTION     = "index";
    protected $controller    = self::DEFAULT_CONTROLLER;
    protected $action        = self::DEFAULT_ACTION;
    protected $params        = array();
    protected $basePath      = "front/index.php/";
    protected $method        =  "GET";
    public function __construct($options=array()) {

        $this->method = $_SERVER['REQUEST_METHOD'];

        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new \Exception("Unexpected Header");
            }
        }


        if (empty($options)) {
            $this->parseUri();
        }
        else {
            if (isset($options["controller"])) {
                $this->setController($options["controller"]);
            }
            if (isset($options["action"])) {
                $this->setAction($options["action"]);
            }
            if (isset($options["params"])) {
                $this->setParams($options["params"]);
            }
        }

    }

    protected function parseUri() {

        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");


      //  $path = preg_replace('/[^a-zA-Z0-9]//', "", $path);
        if (strpos($path, $this->basePath) === 0) {
            $path = substr($path, strlen($this->basePath));
        }

        list($controller, $action, $params) = explode("/", $path, 4);

        if (isset($controller)) {
            $this->setController($controller);
        }
        if (isset($action)) {
            $this->setAction($action);
        }
        if (isset($params)) {
            $this->setParams(explode("/", $params));
        }
    }

    public function setController($controller) {

        $controller = ucfirst("Assignment\\Controllers\\".strtolower($controller)) . "Controller";
        if (!class_exists($controller)) {
            throw new ControllerNotFoundException($this->controller . " Controller Not Found");
        }
        $this->controller = $controller;
        return $this;
    }

    public function setAction($action) {
        $reflector = new \ReflectionClass($this->controller);
        if (!$reflector->hasMethod($action)) {
            throw new ActionNotFoundException($this->action . " Action Not Found ");
        }
        $this->action = $action;
        return $this;
    }

    public function setParams(array $params) {
        $this->params = $params;
        return $this;
    }

    public function run() {

        if(class_exists($this->controller)){
           $controllerObject=new $this->controller;

            if($this->method!='GET'){

                $action=strtolower($this->method).$this->action;

            }else{
                $action=$this->action;
            }

            if(method_exists($controllerObject,$action)){
                $action=$this->action;

                call_user_func_array(array(new $this->controller, $action), $this->params);


            }else{

                throw new ActionNotFoundException($this->action . " with HTTP method ".$this->method." Not Found ");

            }

        }else{
            throw new ControllerNotFoundException($this->controller . " Not Found");
        }

    }
    private function _cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

}