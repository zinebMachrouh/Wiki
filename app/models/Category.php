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
}
