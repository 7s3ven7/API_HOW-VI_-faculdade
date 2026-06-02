<?php

abstract class baseRepository
{

    protected string $table;
    private bool $return;
    private PDO $connection;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host=localhost;dbname=unidade", "root", "");
    }

    public function all(): array
    {
        $query = "SELECT * FROM $this->table";

        $statement = $this->execute($query);

        return $statement->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function find(int $id): array
    {
        $params = [':id' => $id];

        $query = "SELECT * FROM $this->table WHERE id = :id";

        $statement = $this->execute($query, $params);

        return $statement->fetch(PDO::FETCH_ASSOC) ?? [];
    }

    public function insert(array $data): bool
    {
        $keys = array_keys($data);
        $values = [];
        $executeParams = [];

        foreach ($data as $key => $value) {
            $values[] = ":$key";
            $executeParams[":$key"] = $value;
        }

        $query = "INSERT INTO $this->table (" .
            implode(',', $keys) .
            ") VALUES (" .
            implode(',', $values) .
            ")";

        $this->execute($query, $executeParams);

        return $this->return;
    }

    public function update(array $data): bool
    {
        $querySetString = [];
        $executeParams = [];

        foreach ($data as $key => $value) {
            $querySetString[] = "$key = :$key";
            $executeParams[":$key"] = $value;
        }

        $query = "UPDATE $this->table SET " .
            implode(',', $querySetString) .
            " WHERE id = :id";
        $this->execute($query, $executeParams);

        return $this->return;
    }

    public function delete(int $id): bool
    {
        $params = [':id' => $id];

        $query = "DELETE FROM $this->table WHERE id = :id";

        $this->execute($query, $params);

        if ($this->find($id) !== []) {
            return true;
        }

        return false;
    }

    private function execute(string $query, array $params = null): PDOStatement
    {
        $statement = $this->connection->prepare($query);

        if (!empty($params)) {
            $this->bindParams($statement, $params);
        }

        $this->return = $statement->execute();
        return $statement;
    }

    private function bindParams(PDOStatement $stmt, array $param): void
    {
        foreach ($param as $key => $value) {
            $this->bindParam($stmt, $key, $value);
        }
    }

    private function bindParam(PDOStatement $stmt, string $key, $value): void
    {
        $stmt->bindValue($key, $value);
    }


}