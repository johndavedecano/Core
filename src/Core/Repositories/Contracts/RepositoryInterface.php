<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 10/16/15
 * Time: 2:48 PM
 */
namespace Jdecano\Core\Repositories\Contracts;

interface RepositoryInterface
{
    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'));

    /**
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = array('*'));

    /**
     * @param int $limit
     * @param int $page
     * @param array $columns
     * @return array
     */
    public function paginate($limit = 15, $page = 1, $columns = array('*'));

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $id
     * @param array $data
     * @param string $attribute
     * @return mixed
     */
    public function update($id, array $data, $attribute = 'id');

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);
}