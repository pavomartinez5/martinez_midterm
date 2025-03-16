<?php
class Category{
  //DB Information
  private $conn;
  private $table = 'categories'; // Variable will be used in query to select the categories table

  //Post Properties
  //These fields are associated with the categories tables located in the Database 
  public $id;
  public $category;

  //Constructor DB
  public function __construct($db){
    $this->conn = $db;
  }

    //Get Categories
    public function read(){
    
    //Create PostgreSQL query
    $query = 'SELECT c.id, c.category FROM ' . $this->table . ' c ORDER BY id';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    //Execute query
    $stmt->execute();

    return $stmt;
  }

  //Get Single Category
  public function read_single(){
    //Create PostgreSQL query
    $query = 'SELECT c.id, c.category FROM ' . $this->table . ' c 
              WHERE c.id = ?
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
      $this->category = $row['category'];
      
      //Query succeeded category exist
      return true; 

    }else{
      
      // Explicity set category to null
      $this->category = null;

      //Indicate query failure category did not exist
      return false; 
    }
  }

  //Create Category
  public function create(){
    //Create PostgreSQL query
    $query = 'INSERT INTO ' .$this->table.' (category) VALUES (:category)';

    //Prepare Statement
    $stmt = $this->conn->prepare($query);

    //Clean data
    $this->category = htmlspecialchars(strip_tags($this->category));

    //Bind data
    $stmt->bindParam(':category', $this->category);

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
  
  //Update Category
  public function update(){

    //Create query
    $query = 'UPDATE ' .$this->table.'
        SET
            category = :category
        WHERE
            id = :id';

    //Prepare Statement
    $stmt = $this->conn->prepare($query);

    //Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->category = htmlspecialchars(strip_tags($this->category));

    //Bind data
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':category', $this->category);

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

   //Delete  Category
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