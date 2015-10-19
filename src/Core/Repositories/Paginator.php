<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 10/16/15
 * Time: 2:49 PM
 */

namespace Jdecano\Core\Repositories;


use Jdecano\Core\Repositories\Contracts\PaginatorInterface;

class Paginator implements PaginatorInterface
{
    /**
     * [$query description]
     * @var [type]
     */
    protected $query;
    /**
     * [$limit description]
     * @var [type]
     */
    protected $limit;
    /**
     * [$skip description]
     * @var [type]
     */
    protected $skip;
    /**
     * [$pages description]
     * @var [type]
     */
    private $pages;
    /**
     * [$offset description]
     * @var [type]
     */
    private $offset;
    /**
     * [$raw description]
     * @var [type]
     */
    private $raw;
    /**
     * [__construct description]
     * @param [type]  $query [description]
     * @param [type]  $limit [description]
     * @param integer $skip  [description]
     */
    public function __construct($query, $limit, $skip = 0) {
        $this->query = $query;
        $this->skip = $skip;
        $this->limit = intval($limit);
        $this->limit = ($this->limit < 1) ? 1 : $this->limit;
        $this->total = count($this->query->get());
        $this->pages = ceil($this->total / $this->limit);
        $this->offset = $this->limit * (intval($this->skip) - 1);
        $this->offset = ($this->offset < 1) ? 0 : $this->offset;
        $q = $this->query->take($this->limit)->skip($this->offset)->get();
        $this->raw = [
            'items' => $q,
            'total_items' => $this->total,
            'total_pages' => $this->pages,
            'offset' => $this->offset,
            'page' => $this->skip
        ];
    }
    /**
     * @return array
     */
    public function toArray() {
        return $this->raw;
    }
    /**
     * @return string
     */
    public function toJson() {
        return json_encode($this->raw);
    }
    /**
     * @return string
     */
    public function toHtml() {
        $url = \Request::url();
        $queryArray = array_except(\Request::all(), ['page']);
        $node = '<ul>';
        foreach (range(0, $this->raw['total_pages']) as $k => $v) {
            $queryArray['page'] = $k + 1;
            $queryString = http_build_query($queryArray);
            if ($this->offset == $k) {
                $node .= '<li class="active"><a href="'.$url.'/'.$queryString.'">'.$queryArray['page'].'</a></li>';
            } else {
                $node .= '<li><a href="/'.$queryString.'">'.$queryArray['page'].'</a></li>';
            }
        }
        $node .= '</ul>';
        return $node;
    }
}