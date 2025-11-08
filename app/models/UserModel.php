<?php

class userModel {
    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=poleposition;charset=utf8', 'root', '');
    }
 
    // Busca en la tabla 'usuarios' por 'username'
    public function getUserByEmail($username) {    
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE username = ?");
        $query->execute([$username]);
    
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        return $user;
    }
}