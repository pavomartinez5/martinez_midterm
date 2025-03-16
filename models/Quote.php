<?php
class Quote{
    //DB Information
    private $conn;
    private $table = 'quotes'; // Variable will be used in query to select the quotes table
  
    //Quote Properties
    //These fields are associated with the quotes tables located in the Database 
    public $id;
    public $quote;
    public $author_id;
    public $category_id;
    public $author;
    public $category;
  
    //Constructor DB
    public function __construct($db){
      $this->conn = $db;
    }
  
      //Get Quotes
      public function read(){
      
      //Create PostgreSQL query
      $query = 'SELECT q.id,
                      q.quote,
                      a.author,
                      c.category
                  FROM '.$this->table.' q
                  LEFT JOIN 
                      authors a ON q.author_id = a.id
                  LEFT JOIN 
                      categories c ON q.category_id = c.id
                  ORDER BY
                      q.id';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      //Execute query
      $stmt->execute();
  
      return $stmt;
    }

  //Get Single Quote
  public function read_single(){

   if(isset($_GET['id'])){
      //Create PostgreSQL query
      $query = 'SELECT q.id,
                        q.quote,
                        a.author,
                        c.category
                    FROM '.$this->table.' q
                    LEFT JOIN 
                        authors a ON q.author_id = a.id
                    LEFT JOIN 
                        categories c ON q.category_id = c.id
                    WHERE q.id = ?
                    LIMIT 1 OFFSET 0';
      
      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Bind ID
      $stmt->bindParam(1, $this->id);

    }else if(isset($_GET['author_id'])){ 

      if(isset($_GET['author_id']) && isset($_GET['category_id'])){
        //Create PostgreSQL query
        $query = 'SELECT q.id,
                        q.quote,
                        a.author,
                        c.category
                        FROM '.$this->table.' q
                        LEFT JOIN 
                            authors a ON q.author_id = a.id
                        LEFT JOIN 
                            categories c ON q.category_id = c.id
                        WHERE q.author_id = :author_id
                        AND q.category_id = :category_id
                        ORDER BY
                            q.id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(':author_id', $this->author);
        $stmt->bindParam(':category_id', $this->category);
        

      }else{

      //Create PostgreSQL query
      $query = 'SELECT q.id,
                      q.quote,
                      a.author,
                      c.category
                      FROM '.$this->table.' q
                      LEFT JOIN 
                          authors a ON q.author_id = a.id
                      LEFT JOIN 
                          categories c ON q.category_id = c.id
                      WHERE q.author_id = ?
                      ORDER BY
                          q.id';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Bind ID
      $stmt->bindParam(1, $this->author);

      }
      
    }else{
    
      //Create PostgreSQL query
      $query = 'SELECT q.id,
                      q.quote,
                      a.author,
                      c.category
                      FROM '.$this->table.' q
                      LEFT JOIN 
                          authors a ON q.author_id = a.id
                      LEFT JOIN 
                          categories c ON q.category_id = c.id
                      WHERE q.category_id = ?
                      ORDER BY
                      q.id';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Bind ID
      $stmt->bindParam(1, $this->category);

    }
  
    //Execute query
    $stmt->execute();

    //Set properties
    $this->id = ['id'];
    $this->quote = ['quote'];
    $this->author = ['author'];
    $this->category = ['category'];
    
    //Query succeeded 
    return $stmt; 
  }

  //Create Quote
  public function create(){
    //Create PostgreSQL query
    $query = 'INSERT INTO ' .$this->table.' (quote, author_id, category_id)
    VALUES 
        (:quote, :author_id, :category_id)';

    //Prepare Statement
    $stmt = $this->conn->prepare($query);

    //Clean data
    $this->quote = htmlspecialchars(strip_tags($this->quote));
    $this->author_id = htmlspecialchars(strip_tags($this->author_id));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));

    //Bind data
    $stmt->bindParam(':quote', $this->quote);
    $stmt->bindParam(':author_id', $this->author_id);
    $stmt->bindParam(':category_id', $this->category_id);

    //check if statement executes
    if($stmt->execute()){
      //Retrieve last inserted id
      $this->id = $this->conn->lastInsertId();

      //Query succeeded 
      return true;
    }else{

     //Print error if something goes wrong
     printf("Error: %s.\n", $stmt->error);
    
     //Query failed 
     return false;
    }
   } 

  //Update Quote
  public function update(){

    //Create query
    $query = 'UPDATE ' .$this->table.'
        SET
          quote = :quote,
          author_id = :author_id,
          category_id = :category_id
        WHERE 
          id = :id';

    //Prepare Statement
    $stmt = $this->conn->prepare($query);

    //Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->quote = htmlspecialchars(strip_tags($this->quote));
    $this->author_id = htmlspecialchars(strip_tags($this->author_id));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));


    //Bind data
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':quote', $this->quote);
    $stmt->bindParam(':author_id', $this->author_id);
    $stmt->bindParam(':category_id', $this->category_id);

    //Check to see if query executes  
    if(!$stmt->execute()){

      //Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false; 

    }
    
    //Check to see if any rows where updated
    if($stmt->rowCount() > 0){
        return true;
    }else{
      return false;
    }
  }

  //Delete  Quote
  public function delete(){

    //Create query
    $query = 'DELETE FROM ' .$this->table. 
    ' WHERE id = :id';

    //Prepare Statement
    $stmt = $this->conn->prepare($query);

    //Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    //Bind data
    $stmt->bindParam(':id', $this->id);

    //Check to see if query executes  
    if(!$stmt->execute()){
      //Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false; 
    }
    
    //Check to see if any rows where updated
    if($stmt->rowCount() > 0){
        return true;
    }else{
      return false;
    }
  }
  
}
?>