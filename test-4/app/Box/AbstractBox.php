<?php

namespace App\Box;

use App\Box\Contracts\BoxInterface;
use App\Box\Support\Singleton;

abstract class AbstractBox implements BoxInterface
{
    use Singleton;

    protected $data = [];

    public function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function getData($key)
    {
        return $this->data[$key] ?? null;
    }
}
