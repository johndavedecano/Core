<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 10/16/15
 * Time: 2:49 PM
 */
namespace Jdecano\Core\Repositories\Contracts;

interface PaginatorInterface
{
    /**
     * @return array
     */
    public function toArray();

    /**
     * @return string
     */
    public function toJson();

    /**
     * @return string
     */
    public function toHtml();
}