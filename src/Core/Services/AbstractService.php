<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 6/16/15
 * Time: 10:44 PM
 */
namespace Jdecano\Core\Services;
use Jdecano\Core\Services\Contracts\DispatchesEventInterface;
use Jdecano\Core\Services\Contracts\ServiceInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\Factory as Validator;

abstract class AbstractService implements ServiceInterface, DispatchesEventInterface
{
    use DispatchesEvent;
    /**
     * @var array
     */
    protected $response = [];
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
     * @param array $data
     * @return array
     */
    public function start(array $data) {
        $this->before_merge();
        $this->data = array_merge($this->data, $data);
        $this->after_merge();
        return $this->run_validation();
    }
    /**
     * @return array|void
     */
    public function run_validation() {
        try {
            $validator = Validator::make($this->data, $this->rules, $this->messages);
            if ($validator->fails()) {
                return $this->reject($validator->errors()->toArray());
            }
            return $this->handle();
        } catch (\Exception $e) {
            if($e instanceof HttpException) {
                return $this->reject(['error' => [$e->getMessage()]], $e->getStatusCode());
            } else {
                $this->log($e);
                return $this->reject(['error' => [$e->getMessage()]], 500);
            }
        }
    }
    /**
     * @param $data
     * @return array
     */
    public function resolve($data) {
        $this->response = [];
        $this->response['status'] = 'success';
        $this->response['code'] = 200;
        $this->response['data'] = $data;
        return $this->response;
    }
    /**
     * @param array $data
     * @param int $code
     * @return array
     */
    public function reject($data, $code = 400) {
        $this->response = [];
        $this->response['status'] = 'failure';
        $this->response['code'] = $code;
        $this->response['message'] = $data;
        return $this->response;
    }
    /**
     * @return void
     */
    public function before_merge() {
        return;
    }
    /**
     * @return void
     */
    public function after_merge() {
        return;
    }
    /**
     * @return void|mixed
     */
    public function handle() {
        return;
    }
    /**
     * @param $e mixed
     */
    private function log($e) {
        return \Log::error($e);
    }
}