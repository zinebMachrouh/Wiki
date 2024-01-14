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
    public function getOne($id)
    {
        $this->conn->query("SELECT * from categories where id = :id");
        $this->conn->bind(':id', $id);
        return $this->conn->single();
    }
    public function getArchived()
    {
        $this->conn->query(
            "SELECT c.id, c.title, c.description, 
            COUNT(w.id) AS Total_Wikis,
            SUM(CASE WHEN w.removed = 2 THEN 1 ELSE 0 END) AS Archived_Count
            FROM categories c
            LEFT JOIN wikis w ON c.id = w.category_id
            GROUP BY c.id"
        );
        return $this->conn->resultSet();
    }
    public function Add($newData)
    {
        $titleRegex = '/^[a-zA-Z0-9\s]+$/';
        $descriptionRegex = '/^[a-zA-Z0-9\s\W]+$/';
        try {
            if (preg_match($titleRegex, $newData['title']) && preg_match($descriptionRegex, $newData['description'])) {
                $this->conn->query("INSERT INTO categories (title, description) VALUES(:Title, :Description)");
                $this->conn->bind(':Title', $newData['title']);
                $this->conn->bind(':Description', $newData['description']);
            }
            $this->conn->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Update($newData)
    {
        $titleRegex = '/^[a-zA-Z0-9\s]+$/';
        $descriptionRegex = '/^[a-zA-Z0-9\s\W]+$/';

        try {
            if (preg_match($titleRegex, $newData['title']) && preg_match($descriptionRegex, $newData['description'])) {

                $this->conn->query("UPDATE categories SET Title = :Title, Description = :Description, created_at = :created_at WHERE id = :id");
                $this->conn->bind(':id', $newData['id']);
                $this->conn->bind(':Title', $newData['title']);
                $this->conn->bind(':Description', $newData['description']);
                $current = new DateTime('now');
                $this->conn->bind(':created_at', $current->format('Y-m-d H:i:s'));

                $this->conn->execute();
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Delete($Category_ID)
    {
        try {
            $this->conn->query("DELETE FROM categories WHERE id = :Category_ID");
            $this->conn->bind(':Category_ID', $Category_ID);
            $this->conn->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
