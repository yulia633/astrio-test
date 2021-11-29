<?php

namespace App\Box;

use App\Box\AbstractBox;

class FileBox extends AbstractBox
{
    protected $storageKey;

    public function __construct($storageKey = null)
    {
        if ($storageKey) {
            $this->storageKey = $storageKey;
        }

        if (!file_exists("storage/{$this->storageKey}")) {
            mkdir("storage/{$this->storageKey}");
        }
    }

    public function save()
    {
        file_put_contents("storage/{$this->storageKey}/box.json", json_encode($this->data));
    }

    public function load()
    {
        $this->data = $this->loadData();
    }

    public function loadData()
    {
        $items = [];

        $dir = opendir("storage/{$this->storageKey}");

        while (false !== ($item = readdir($dir))) {
            if (!in_array($item, ['.', '..'])) {
                $items[$item] = file_get_contents("storage/{$this->storageKey}/{$item}");
            }
        }

        return $items;
    }

    protected function keyExists($key)
    {
        return file_exists("storage/{$this->storageKey}/{$key}");
    }
}
