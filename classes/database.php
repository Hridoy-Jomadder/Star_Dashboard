<?php

class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "das_db";
    private $connection;

    public function __construct()
    {
        $this->connection = $this->connect();
    }

    private function connect()
    {
        $connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        return $connection;
    }

    public function read($query)
    {
        $result = $this->connection->query($query);

        if ($result === false) {
            die("Error executing query: " . $this->connection->error);
        }

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function readWithParams($query, $params)
    {
        $statement = $this->connection->prepare($query);

        if ($statement === false) {
            die("Error preparing query: " . $this->connection->error);
        }

        $types = str_repeat('s', count($params));
        $statement->bind_param($types, ...$params);

        if ($statement->execute() === false) {
            die("Error executing query: " . $this->connection->error);
        }

        $result = $statement->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $statement->close();

        return $rows;
    }

    public function escape_string($value)
    {
        return $this->connection->real_escape_string($value);
    }
}
