<?php

namespace App\Box;

use App\Box\AbstractBox;
use \PDO;

class DbBox extends AbstractBox
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save()
    {
        try {
            $this->pdo->beginTransaction();

            $this->pdo->query('DELETE FROM box')->execute();

            $stmt = $this->pdo->prepare("INSERT INTO box (key, value) VALUES (:key, :value)");

            foreach ($this->data as $key => $value) {
                $stmt->bindValue(':key', $key);
                $stmt->bindValue(':value', serialize($value));
                $stmt->execute();
            }
            $this->pdo->commit();
        } catch (\Exception $e) {
            $this->pdo->rollback();
            throw $e;
        }
    }

    public function load()
    {
        $stmt = $this->pdo->query('SELECT key, value FROM box_items');

        $data = [];

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $data[$row['key']] = unserialize($row['value']);
        }

        $this->data = $data;
    }
}
