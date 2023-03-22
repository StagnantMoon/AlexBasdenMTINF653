<?php
class Category
{
    // DataBase stuffs
    private $conn;
    private $table = 'categories';
    //category properties
    public $id;
    public $category;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
    //Creates teh query
        $query = 'SELECT * FROM ' . $this->table . ';';

        $stmt = $this->conn->prepare($query);//prepare stmt
        //Execute s th query
        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        //creates teh query
        $query = 'SELECT *
        FROM ' . $this->table .
            ' WHERE id = ? LIMIT 1;';

        $stmt = $this->conn->prepare($query); //prepare stmt
        $stmt->bindParam(1, $this->id); //bind param 1

        //executes query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //properties set
        if ($row > 0) {
            $this->id = $row['id'];
            $this->category = $row['category'];
        }
    }
//create query
    public function create()
    {
        $query = "INSERT INTO " . $this->table . " (category)
        VALUES (?) RETURNING id";

        
        $stmt = $this->conn->prepare($query); //prepare stmt
        $this->category = htmlspecialchars(strip_tags($this->category)); // clean tghe data
        $stmt->bindParam(1, $this->category); // binds param
        // Get id
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            return true;
        }

        printf("Error: %s.\n", $stmt->error); // print errors
        return false;
    } // public function create done

    public function update()
    {
        //creates the query
        $query = "UPDATE " . $this->table
            . " SET  
                category = ?
            WHERE
                id = ?";

        $stmt = $this->conn->prepare($query);    //prep stmt
        $this->category = htmlspecialchars(strip_tags($this->category)); //clean data

       //prarmeter bind
        $stmt->bindParam(1, $this->category);
        $stmt->bindParam(2, $this->id);

        if ($stmt->execute()) 
        {
            return true;
        }
        printf("Error: %s.\n", $stmt->error); // prints error message

        return false;
    } // puplic function update

    public function delete()
    {
        //query
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";

        $stmt = $this->conn->prepare($query); //prepare stmt
        $this->id = htmlspecialchars(strip_tags($this->id)); // clean data

        // binds teh parameters
        $stmt->bindParam(1, $this->id);

        //executes query
        if ($stmt->execute()) 
        {
            return true;
        }

       
        printf("Error: %s.\n", $stmt->error); //print error message

        return false;
    } // end pulbic function delete
}
?>