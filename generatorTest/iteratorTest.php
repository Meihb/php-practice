<?php

/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/6/20
 * Time: 11:27
 */
class Xrange implements Iterator
{
    protected $start;
    protected $step;
    protected $limit;
    protected $i;
    protected $key;

    public function __construct($start, $limit, $step = 0)
    {
        $this->start = $start;
        $this->limit = $limit;
        $this->step = $step;
        $this->key = 0;

    }

    public function rewind()
    {
        $this->i = $this->start;
    }

    public function current()//foreach as value
    {
        return $this->i;
    }

    public function key()//foreach as key
    {
//        return $this->i + 1;
        return $this->key++;
    }


    public function next()
    {
        $this->i += $this->step;
    }

    public function valid()
    {
        return $this->i <= $this->limit;
    }
}

foreach (new Xrange(10, 100, 10) as $key => $value) {
    printf("%d %d\r\n\t", $key, $value);
}
