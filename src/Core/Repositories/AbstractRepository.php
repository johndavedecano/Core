<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 10/16/15
 * Time: 2:46 PM
 */

namespace Jdecano\Core\Repositories;

use Jdecano\Core\Repositories\Contracts\RepositoryInterface;

class AbstractRepository implements RepositoryInterface
{
    /**
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;
    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        return $this->model->find($id, $columns);
    }
    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*')) {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }
    /**
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = array('*')) {
        return $this->model->get($columns);
    }
    /**
     * @param int $limit
     * @param int $page
     * @param array $columns
     * @return array
     */
    public function paginate($limit = 15, $page = 1, $columns = array('*')) {
        $query = $this->model->select($columns);
        $paginator = new Paginator($query, $limit, $page);
        return $paginator->toArray();
    }
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        return $this->model->create($data);
    }
    /**
     * @param $id
     * @param array $data
     * @param string $attribute
     * @return mixed
     */
    public function update($id, array $data, $attribute = 'id') {
        return $this->model->where($attribute, $id)->update($data);
    }
    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->model->destroy($id);
    }
}