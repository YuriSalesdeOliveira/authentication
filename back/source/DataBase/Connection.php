<?php

namespace Source\DataBase;

use PDO;
use Exception;
use PDOException;

class Connection extends AbstractDataBase implements InterfaceConnection
{
    protected PDO $PDOInstance;

    protected function connection()
    {
        $this->PDOInstance = isset($this->PDOInstance) ?
        $this->PDOInstance : $this->createConnection(dataBaseConfig());

        return $this->PDOInstance;
    }

    public function execute(string $sql, ?array $params = null): bool
    {
        try {
            
            $connection = $this->connection();
            
            $statement = $connection->prepare($sql);
            $statement->execute($params);
            
            if ($this->modifyOrQuery($sql) === 'query')
                $this->query_result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            return true;

        } catch (PDOException $e) {

            $this->error = $e;
            
            return false;
        }
    }

    protected function modifyOrQuery($sql)
    {
        return str_contains(strtolower($sql), 'select') ? 'query' : 'modify';
    }

    public function queryResult(): array
    {
        if (!isset($this->query_result))
            throw new Exception('Execute uma consulta para obter um query result.');

        return $this->query_result;
    }
}