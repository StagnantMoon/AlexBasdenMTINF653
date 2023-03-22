<?php
class Author
{
    //dB stuff
    private $conn;
    private $table = 'authors';

    //datebase Author properties
    public $id;
    public $author;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
    //create query
        $query = 'SELECT * FROM ' . $this->table;

        //prepare stmt
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        //cReate query
        $query = 'SELECT *
        FROM ' . $this->table .
            ' WHERE id = ? LIMIT 1';

    //prepare statemenst
        $stmt = $this->conn->prepare($query);

        //binsd parameters
        $stmt->bindParam(1, $this->id);

        //execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //sets teh properties
        if ($row > 0) {
            $this->id = $row['id'];
            $this->author = $row['author'];
        }
    }

    public function create()
    {
        //creates the query
        $query = "INSERT INTO " . $this->table . " (author)
        VALUES (?) RETURNING id";

        //Prepare stmt
        $stmt = $this->conn->prepare($query);
        
        $this->author = htmlspecialchars(strip_tags($this->author)); // cleans data
        $stmt->bindParam(1, $this->author); //binds data

        // Get id of new create authors
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            return true;
        }
        
        printf("Error: %s.\n", $stmt->error); // Prints the earror
        return false;
    }
    public function update()
    {
        //creates the query
        $query = "UPDATE " . $this->table
            . " SET  
                author = ?
            WHERE
                id = ?";

    //prepare stmt
        $stmt = $this->conn->prepare($query);
        $this->author = htmlspecialchars(strip_tags($this->author)); //clean datas

    //Binds param
        $stmt->bindParam(1, $this->author);
        $stmt->bindParam(2, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error); //eror print
        return false;
    }

    public function delete()
    {
         //query
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";

        //prepare stmt
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id)); //clean data
        //binsd the parameters
        $stmt->bindParam(1, $this->id);
        //executes  the query
        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error); // prints the error
        return false;
    }
}
?>