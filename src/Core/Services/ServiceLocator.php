<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 10/16/15
 * Time: 2:42 PM
 */
namespace Jdecano\Core\Services;

use Jdecano\Core\Services\Contracts\ServiceLocatorInterface;

class ServiceLocator implements ServiceLocatorInterface {
    /**
     * @var string
     */
    private $service;
    /**
     * @param $name
     * @return mixed
     */
    public function get($name) {
        $this->service = $this->format($name);
        return \App::make($this->service);
    }
    /**
     * @param $name
     * @return string
     */
    private function format($name) {
        $params = explode(".", $name);
        $class = "App\\Services\\";
        foreach($params as $param) {
            $class .= ucwords(camel_case($param)). "\\";
        }
        return rtrim($class, "\\");
    }
}