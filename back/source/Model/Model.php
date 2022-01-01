<?php

namespace Source\Model;

use Exception;
use PDOException;
use Source\DataBase\Connection;
use Source\Model\Trait\Attributes;
use Source\DataBase\InterfaceConnection;

abstract class Model
{
    use Attributes;

    protected static string $entity;
    protected static array $columns;
    protected static string $primary = 'id';
    protected static bool $timestamp = true;
    protected InterfaceConnection $connection;
    protected PDOException $error;
    protected array $query_result;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;

        $this->connection = new Connection();
    }

    public function remove(): bool
    {
        if (isset($this->id))
            return $this->delete(['id' => $this->id]);
        
        return false;
    }

    public static function removeById(string $id): bool
    {
        return (new static)->delete(['id' => $id]);
    }

    protected function delete(array $filters): bool
    {
        $sql = "DELETE FROM " . static::$entity . $this->where($filters);
        
        if ($this->connection->execute($sql, $filters)) return true;

        $this->error = $this->connection->error();

        return false;
    }

    public function save(): bool
    {
        if (isset($this->{static::$primary})) return $this->update();

        return $this->insert();
    }

    protected function insert(): bool
    {
        $this->timestamp('insert');

        $attributes_keys = array_keys($this->attributes);

        $this->checkMandatoryAttributes($attributes_keys);

        $sql = "INSERT INTO " . static::$entity . ' (' . implode(',', $attributes_keys)
            . ') VALUES (:' . implode(', :', $attributes_keys) . ')';

        if ($this->connection->execute($sql, $this->attributes)) return true;
        
        $this->error = $this->connection->error();

        return false;

    }

    protected function update(): bool
    {
        $this->timestamp('update');

        $attributes_keys = array_keys($this->attributes);

        $this->checkMandatoryAttributes($attributes_keys);

        $sql = 'UPDATE ' . static::$entity . $this->set($attributes_keys)
            . $this->where([static::$primary => $this->{static::$primary}]);

        if ($this->connection->execute($sql, $this->attributes)) return true;
    
        $this->error = $this->connection->error();

        return false;
    }

    protected function timestamp($insert_or_update): void
    {
        $date = date('Y-m-d H:i:s');

        switch ($insert_or_update) {
            case 'insert':
                $this->created_at = $date;
                break;
            case 'update':
                $this->updated_at = $date;
                break;
        }
    }

    protected function checkMandatoryAttributes($attributes_keys): void
    {
        $required_columns = $this->getRequiredColumns();

        foreach ($required_columns as $column) {
            if (!in_array($column, $attributes_keys))
                throw new Exception('O objeto deve conter todos os atributos obrigatórios'
                    . ' " ' . implode(', ', $required_columns) . ' " ');
        }
    }

    protected function getRequiredColumns(): array
    {
        $required_columns = [];

        foreach (static::$columns as $column => $is_or_not_required) {
            if ($is_or_not_required === 'require') $required_columns[] = $column;
        }

        return $required_columns;
    }

    public static function find(array $filters = [], string $columns = '*'): static
    {
        $instance = new static();

        $instance->getResultFromSelect($filters, $columns);

        return $instance;
    }

    public function first(): bool|object
    {
        $result = $this->object();

        return empty($result) ? false : $result[0];
    }

    public function fetch(): bool|array
    {
        return isset($this->query_result) ? $this->query_result : false;
    }

    public function object(): bool|array
    {
        if ($result = $this->fetch()) {

            $objects = [];

            foreach ($result as $row) {
                $objects[] = new static($row);
            }

            return $objects;
        }
        
        return false;
    }

    protected function getResultFromSelect(array $filters = [], string $columns = '*'): bool
    {
        $sql = "SELECT {$columns} FROM " . static::$entity
            . $this->where($filters);

        if ($this->connection->execute($sql, $filters)) {

            $this->query_result = $this->connection->queryResult();

            return true;
        }
    
        $this->error = $this->connection->error();

        return false;
    }

    protected function where(array $filters): string
    {
        $sql = ' WHERE 1 = 1 ';

        foreach (array_keys($filters) as $key)
            $sql .= " AND {$key} = :{$key}";

        return $sql;
    }

    protected function set(array $attributes_keys)
    {
        $sql = ' SET ';

        foreach ($attributes_keys as $attribute) {
            $sql .= "{$attribute} = :{$attribute},";
        }

        return substr($sql, 0, -1);
    }

    public function error(): bool|PDOException
    {
        if (empty($this->error)) return false;

        return $this->error;
    }
}