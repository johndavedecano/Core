<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 10/16/15
 * Time: 2:43 PM
 */
namespace Jdecano\Core\Services\Contracts;

interface ServiceLocatorInterface
{
    /**
     * @param $name
     * @return mixed
     */
    public function get($name);
}