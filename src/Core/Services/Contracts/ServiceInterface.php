<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 10/16/15
 * Time: 2:39 PM
 */
namespace Jdecano\Core\Services\Contracts;

interface ServiceInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function start(array $data);

    /**
     * @return array|void
     */
    public function run_validation();

    /**
     * @param $data
     * @return array
     */
    public function resolve($data);

    /**
     * @param array $data
     * @param int $code
     * @return array
     */
    public function reject($data, $code = 400);

    /**
     * @return void
     */
    public function before_merge();

    /**
     * @return void
     */
    public function after_merge();

    /**
     * @return void|mixed
     */
    public function handle();
}