<?php
class Category
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function getAll()
    {
        $this->conn->query("SELECT c.*, COUNT(w.id) AS countWikis FROM Categories c LEFT JOIN Wikis w ON c.id = w.category_id GROUP BY c.id ORDER BY c.created_at DESC LIMIT 6");
        return $this->conn->resultSet();
    }
    public function getCats()
    {
        $this->conn->query("SELECT DISTINCT * from categories");
        return $this->conn->resultSet();
    }
    public function getOne($id){
        $this->conn->query("SELECT * from categories where id = :id");
        $this->conn->bind(':id', $id);
        return $this->conn->single();

    }
}
