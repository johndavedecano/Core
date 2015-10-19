<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 10/16/15
 * Time: 2:40 PM
 */
namespace Jdecano\Core\Services\Contracts;

/**
 * Interface DispatchesEventInterface
 * @package Jdecano\Core\Services\Contracts
 */
interface DispatchesEventInterface
{
    /**
     * @param $event
     * @param $payload
     * @return mixed
     */
    public function dispatch($event, $payload);
}