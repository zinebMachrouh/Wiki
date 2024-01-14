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
        LEFT JOIN categories ON categories.id = wikis.category_id
        INNER JOIN users ON users.id = wikis.user_id
        WHERE wikis.removed = 0
        ORDER BY wikis.created_at DESC");
        return $this->conn->resultSet();
    }


    public function getWikisByUserId()
    {
        $this->conn->query("SELECT wikis.*, categories.title AS category, users.fname AS fname, users.lname AS lname
            FROM wikis
            INNER JOIN categories ON categories.id = wikis.category_id
            INNER JOIN users ON users.id = wikis.user_id
            WHERE wikis.removed = 0 AND wikis.user_id = :user_id
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

    public function Update($title, $content, $category_id, $id)
    {
        try {
            $this->conn->query("UPDATE wikis SET title = :title, content = :content, category_id = :category_id, created_at = :created_at WHERE id = :wiki_id");
            $this->conn->bind(':title', $title);
            $this->conn->bind(':content', $content);
            $this->conn->bind(':category_id', $category_id);
            $this->conn->bind(':wiki_id', $id);
            $current = new DateTime('now');
            $this->conn->bind(':created_at', $current->format('Y-m-d H:i:s'));

            $this->conn->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Delete($Wiki_ID)
    {
        try {
            $this->conn->query("UPDATE wikis SET removed = 1 WHERE id = :wiki_id");
            $this->conn->bind(':wiki_id', $Wiki_ID);
            $this->conn->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function Archive($Wiki_ID)
    {
        try {
            $this->conn->query("UPDATE wikis SET removed = 2 WHERE id = :wiki_id");
            $this->conn->bind(':wiki_id', $Wiki_ID);
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
    public function getWiki($id)
    {
        $this->conn->query("SELECT DISTINCT * FROM wikis INNER JOIN users ON wikis.user_id = users.id where wikis.id = :id");
        $this->conn->bind(':id', $id);
        $this->conn->execute();
        return $this->conn->single();
    }
    public function updateTags($wikiId, $tags)
    {
        $this->conn->query("DELETE FROM tag_wiki WHERE wiki_id = :id");
        $this->conn->bind(':id', $wikiId);

        $this->conn->execute();

        foreach ($tags as $tagId) {
            $this->conn->query("INSERT INTO tag_wiki (wiki_id, tag_id) VALUES (:wiki_id,:tag_id)");
            $this->conn->bind(':wiki_id', $wikiId);
            $this->conn->bind(':tag_id', $tagId);

            $this->conn->execute();
        }
    }
    public function searchData($searchInput)
    {
        $searchInput = '%' . $searchInput . '%';
        $tagInput = '%' . $searchInput;

        $query = "SELECT DISTINCT w.*, c.title
                FROM wikis w
                LEFT JOIN categories c ON w.category_id = c.id
                LEFT JOIN tag_wiki tw ON tw.wiki_id = w.id
                LEFT JOIN tags t ON tw.tag_id = t.id
                WHERE w.title LIKE :searchInput OR c.title LIKE :searchInput OR t.title LIKE :tagInput
            ";

        $this->conn->query($query);
        $this->conn->bind(':searchInput', $searchInput);
        $this->conn->bind(':tagInput', $tagInput);
        $this->conn->execute();
        return $this->conn->resultSet();
    }
}
