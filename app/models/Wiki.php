<?php
class Wiki
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function getAll()
    {
        $this->conn->query("SELECT wikis.*, categories.title AS category, users.fname AS fname, users.lname AS lname
            FROM wikis
            INNER JOIN categories ON categories.id = wikis.category_id
            INNER JOIN users ON users.id = wikis.user_id
            WHERE wikis.deleted = 0 AND wikis.archived = 0
            ORDER BY wikis.created_at DESC");
        return $this->conn->resultSet();
    }

    public function getWikisByUserId()
    {
        $this->conn->query("SELECT wikis.*, categories.title AS category, users.fname AS fname, users.lname AS lname
            FROM wikis
            INNER JOIN categories ON categories.id = wikis.category_id
            INNER JOIN users ON users.id = wikis.user_id
            WHERE wikis.deleted = 0 AND wikis.archived = 0 AND wikis.user_id = :user_id
            ORDER BY wikis.created_at DESC");
            $this->conn->bind(':user_id', $_SESSION['user_id']);
        return $this->conn->resultSet();
    }

    public function Add($wiki)
    {
        try {
            $this->conn->query("INSERT INTO Wikis(title, content, user_id, category_id) VALUES( :title, :content, :user_id ,:category_id)");
            $this->conn->bind(':title', $wiki['title']);
            $this->conn->bind(':content', $wiki['content']);
            $this->conn->bind(':user_id', $_SESSION['user_id']);
            $this->conn->bind(':category_id', $wiki['category_id']);

            $this->conn->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Update($wiki)
    {
        try {
            $this->conn->query("UPDATE wikis SET title = :title, content = :content, category_id = :category_id");
            $this->conn->bind(':title', $wiki->title);
            $this->conn->bind(':content', $wiki->content);
            $this->conn->bind(':category_id', $wiki->category_id);

            $this->conn->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Delete($Wiki_ID)
    {
        try {
            $this->conn->query("DELETE FROM wikis WHERE id = :Wiki_ID");
            $this->conn->bind(':Wiki_ID', $Wiki_ID);
            $this->conn->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function attachTag($wiki_id, $tag_id)
    {
        $this->conn->query("INSERT INTO tag_wiki(tag_id, wiki_id) VALUES(:tag_id,:wiki_id)");
        $this->conn->bind(':wiki_id', $wiki_id);
        $this->conn->bind(':tag_id', $tag_id);
        $this->conn->execute();
    }

}
