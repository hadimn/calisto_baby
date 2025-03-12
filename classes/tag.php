<?php
class Tag
{
    private $conn;
    private $table_name = "tags";

    public $tag_id;
    public $name;
    public $description;
    public $image;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (name, description, image) VALUES (:name, :description, :image)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image", $this->image);

        return $stmt->execute();
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description, image = :image WHERE tag_id = :tag_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":tag_id", $this->tag_id);

        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE tag_id = :tag_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tag_id", $this->tag_id);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Failed to delete tag.");
        }
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE tag_id = :tag_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tag_id", $this->tag_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>