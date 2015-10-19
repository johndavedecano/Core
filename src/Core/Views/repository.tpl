<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 6/17/15
 * Time: 9:45 PM
 */

namespace App\Repositories;

use App\Repositories\Contracts\MODELRepositoryInterface;
use App\Models\MODEL;
use Jdecano\Core\Repositories\AbstractRepository;
class MODELRepository extends AbstractRepository implements MODELRepositoryInterface
{
    public function __construct(MODEL $model) {
        $this->model = $model;
    }
}