<?php
class Tag
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function getAll()
    {
        $this->conn->query("SELECT tags.title FROM tags INNER JOIN tag_wiki ON tags.id = tag_wiki.tag_id GROUP BY tag_wiki.tag_id ORDER BY COUNT(tag_wiki.wiki_id) DESC LIMIT 9");
        return $this->conn->resultSet();
    }
    public function getTags()
    {
        $this->conn->query("SELECT distinct * from tags");
        return $this->conn->resultSet();
    }
    public function getTagByWikiId($id)
    {
        $this->conn->query("SELECT distinct * from tags INNER JOIN tag_wiki ON tags.id = tag_wiki.tag_id where tag_wiki.wiki_id = :id");
        $this->conn->bind(':id', $id);

        return $this->conn->resultSet();
    }
    public function getTagsNotInWikis($id)
    {
        $this->conn->query("SELECT tags.* FROM tags WHERE NOT EXISTS (SELECT * FROM tag_wiki WHERE tag_wiki.tag_id = tags.id AND tag_wiki.wiki_id = :wiki_id)");
        $this->conn->bind(':wiki_id', $id);
        $this->conn->execute();
        return $this->conn->resultSet();
    }
    public function adminTags()
    {
        $this->conn->query(
            "SELECT t.id, t.title, 
            COUNT(w.wiki_id) AS Total_Wikis
            FROM tags t
            LEFT JOIN tag_wiki w ON t.id = w.tag_id
            GROUP BY t.id"
        );
        return $this->conn->resultSet();
    }

    public function Add($newData)
    {
        try {
            $this->conn->query("INSERT INTO tags (title) VALUES(:Title)");
            $this->conn->bind(':Title', $newData['title']);

            $this->conn->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Update($newData)
    {
        try {
            $this->conn->query("UPDATE categories SET Title = :Title WHERE id = :id");
            $this->conn->bind(':id', $newData['id']);
            $this->conn->bind(':Title', $newData['title']);

            $this->conn->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Delete($id)
    {
        try {
            $this->conn->query("DELETE FROM tags WHERE id = :id");
            $this->conn->bind(':id', $id);
            $this->conn->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
