<?php

namespace App\Controllers\Auth\Users;

use App;

class User {

    public $id;

    public $username;
    public $password;



    public function __construct($id, $username, $password){
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function isInstructor() {
        return false;
    }

    
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function register(){
        $this->hashPassword();
        $query = App::getApp()->getDB()->prepare('INSERT INTO users(username,password) VALUES(:username, :mdp)');
        $query->execute(array(':username' => $this->username,  ':mdp' => $this->password));
    }
}

?>