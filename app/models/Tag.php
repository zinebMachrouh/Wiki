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
}
