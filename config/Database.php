<?php
class Database{
        /* 
        //-----Local testing development-----------------
        //Azure Data Studio  postgreSQL localhost DB Params 
        private $host = 'localhost';
        private $port = '5432';
        private $db_name = 'quotesdb';
        private $username = 'postgres';
        private $password = 'postgres';
        private $conn; 


        //Azure Data Studio postgreSQL localhost DB Connect
        public function connect(){

            $this->conn = null;
            
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";

            try{

                $this->conn = new PDO($dsn, $this->username, $this->password);

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            }catch(PDOException $e){

                //echo for tutorial, but log the error for production

                echo 'Connection Error: ' .$e->getMessage();
            }
            return $this->conn;

        } */

       /* ------------------------------------------------------------------- */
       
        //-----Connected to render
        //Azure Data Studio  postgreSQL render server host DB Params
        private $conn;
        private $host;
        private $port = 5432;
        private $db_name;
        private $username;
        private $password;
       

        //Azure Data Studio postgreSQL render constructor to connect to .htaccess file
        public function __construct(){
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
            $this->db_name = getenv('DBNAME');
            $this->host = getenv('HOST');
            $this->port = getenv('PORT');
        }

        //Azure Data Studio postgreSQL render server host DB Connect
        public function connect(){
            //instead of $this->conn = null;
            if($this->conn){
                //connection already exists, return it
                return $this->conn;
            }else{

                $dsn = "pgsql:host={$this->host};port={$this->port}; dbname={$this->db_name}";

                try{

                    $this->conn = new PDO($dsn, $this->username, $this->password);    
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
    
                }catch(PDOException $e){
    
                    //echo for tutorial, but log the error for production
                    echo 'Connection Error: ' .$e->getMessage();
                }

            }
        }
}
?>