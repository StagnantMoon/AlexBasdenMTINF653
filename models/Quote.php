<?php
class Quote
{
    //Database Stuff
    private $conn;
    private $table = 'quotes';
    //Category properties
    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        
        $query = 'SELECT q.id, q.quote, a.author as author_name,
        c.category as category_name 
        FROM quotes q 
        LEFT JOIN authors a ON q.author_id = a.id 
        LEFT JOIN categories c ON q.category_id = c.id
        ORDER BY q.id ASC';
        $stmt = $this->conn->prepare($query);     
        $stmt->execute();

        return $stmt;
    } // end function read()

    public function read_single()
    {
        $query = 'SELECT q.id, q.quote, a.author as author_name,
    c.category as category_name 
      FROM quotes q 
      LEFT JOIN authors a ON q.author_id = a.id 
      LEFT JOIN categories c ON q.category_id = c.id
      WHERE q.id = ?';

        $stmt = $this->conn->prepare($query); //prep stmt
        $stmt->bindParam(1, $this->id); // binds param
        $stmt->execute(); // execute query

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row > 0)
         {
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author_id = $row['author_name'];
            $this->category_id = $row['category_name'];
        }// end if property sets
    }// end read_single

    public function create()
    {
        //query
        $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id)
            VALUES (:quote, :author_id, :category_id) RETURNING id';

        $stmt = $this->conn->prepare($query); // prepare statement

    //Cleans the datas
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

    //BINDS teh data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        // Execute query
        if ($stmt->execute())  // get new id 
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            return true;
        }

        printf("Error: %s.\n", $stmt->error); // priunt error

        return false;
    }
    public function update()
    {
        // query
        $query = 'UPDATE ' . $this->table . ' 
          SET
            quote = ?,
            author_id = ?,
            category_id = ?
          WHERE
            id = ?';

        $stmt = $this->conn->prepare($query); //prep statement

        //Cleans thes data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //this BINDS data
        $stmt->bindParam(1, $this->quote);
        $stmt->bindParam(2, $this->author_id);
        $stmt->bindParam(3, $this->category_id);
        $stmt->bindParam(4, $this->id);

     
        if ($stmt->execute() && $stmt->rowCount() > 0) // executes the query
        {
            return true;
        }
        return false;
    }
    public function delete()
    {
        
        $query = 'DELETE FROM ' . $this->table .
            ' WHERE id = ?';

        
        $stmt = $this->conn->prepare($query); // prepare statement
        $this->id = htmlspecialchars(strip_tags($this->id)); //clean id

        $stmt->bindParam(1, $this->id); // bind the data

        
        if ($stmt->execute() && $stmt->rowCount() > 0) //executes query
        {
            return true;
        }

        return false;
    }
}
?>
