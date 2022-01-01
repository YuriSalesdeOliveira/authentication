<?php

namespace Source\DataBase;

use PDO;
use PDOException;

abstract class AbstractDataBase
{
    protected PDOException $error;

    protected function createConnection(array $config)
    {
        [$driver, $host, $port, $dbname, $charset,
        $username, $password, $options] = array_values($config);
        
        return new PDO("{$driver}:host={$host};port={$port};dbname={$dbname};charset={$charset}",
            $username,
            $password,
            $options
        );

    }

    public function error(): bool|PDOException
    {
        return empty($this->error) ? false : $this->error;
    }
}