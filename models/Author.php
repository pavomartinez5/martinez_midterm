<?php
class Author{
  //DB Information 
  private $conn;
  private $table = 'authors'; // Variable will be used in query to select the authors table

  //Author Properties
  //These fields are associated with the authors tables located in the Database 
  public $id;
  public $author;

  //Constructor DB
  public function __construct($db){
    $this->conn = $db;
  }

    //Get Authors
    public function read(){
    
    //Create PostgreSQL query
    $query = 'SELECT a.id, a.author FROM ' . $this->table . ' a ORDER BY id';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    //Execute query
    $stmt->execute();

    return $stmt;
  }

  //Get Single Author
  public function read_single(){
    //Create PostgreSQL query
    $query = 'SELECT a.id, a.author FROM ' . $this->table . ' a 
              WHERE a.id = ?
              LIMIT 1 OFFSET 0';
    
    //Prepare statement
    $stmt = $this->conn->prepare($query);

    //Bind ID
    $stmt->bindParam(1, $this->id);

  
    //Execute query
    $stmt->execute();

    //Return associate array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //check if record was found 
    if($row){

    //Set properties
    $this->author = $row['author'];
    
    //Query succeeded author exist
    return true; 
    }else{
      // Explicity set author to null
      $this->author = null;

      //Indicate query failure author did not exist
      return false; 
    }
  }

    //Create Author
  public function create(){
    //Create PostgreSQL query
    $query = 'INSERT INTO ' .$this->table.' (author) VALUES (:author)';

    //Prepare Statement
    $stmt = $this->conn->prepare($query);

    //Clean data
    $this->author = htmlspecialchars(strip_tags($this->author));

    //Bind data
    $stmt->bindParam(':author', $this->author);

    //Execute query executes
    if($stmt ->execute()){

      //Retrieve last inserted id
      $this->id = $this->conn->lastInsertId();
      return true;
    }

    //Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;

  }  

  //Update Author
  public function update(){

    //Create query
    $query = 'UPDATE ' .$this->table.'
        SET
            author = :author
        WHERE
            id = :id';

    //Prepare Statement
    $stmt = $this->conn->prepare($query);

    //Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->author = htmlspecialchars(strip_tags($this->author));

    //Bind data
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':author', $this->author);

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

  //Delete  Author
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