<?php

class User{
     //db
     private $conn;
     private $table = 'users';

    public $id;
    public $name;
    public $email;
    public $password;
    
    //constructor
    public function __construct($db){
        $this->conn = $db;
  }

  public function create(){
    $query = 'INSERT INTO ' . $this->table . ' SET name = :name,  password = :password, email = :email';

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));


        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if($stmt->execute()){
          return true;
        }


        printf('error: %s', $this->error);
        return false;
  }

  
  public function login(){
    $query = 'SELECT password, name, email FROM '.$this->table.' WHERE email = :email LIMIT 0,1';

    $stmt = $this->conn->prepare($query);

    $this->email = htmlspecialchars(strip_tags($this->email));

    $stmt->bindParam(':email', $this->email);

    $stmt->execute();

    $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($fetch);
    $password2 = $fetch['password'];

    if(password_verify($this->password, $password2)){
        return true;
      }
    
    return false;
  }
}