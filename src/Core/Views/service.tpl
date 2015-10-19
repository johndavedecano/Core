<?php namespace App\Services\DOMAIN;

use Jdecano\Core\Repositories\AbstractService;
use App\Services\DOMAIN\Contracts\SERVICEInterface;

/**
 * Class SERVICE
 * @package App\Services\DOMAIN
 */
class SERVICE extends AbstractService implements SERVICEInterface
{
    /**
     * @var array
     */
    protected $rules = [];
    /**
     * @var array
     */
    protected $messages = [];
    /**
     * @var array
     */
    protected $data = [];
    /**
     * @return void|mixed
     */
    public function handle() {
        // TODO
    }
}