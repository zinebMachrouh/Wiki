<?php
class Wiki
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function getAll(){
        $this->conn->query("SELECT wikis.*, categories.title AS category FROM wikis INNER JOIN categories ON categories.id = wikis.category_id WHERE deleted = 0 AND archived = 0");
        return $this->conn->resultSet();
    }
}