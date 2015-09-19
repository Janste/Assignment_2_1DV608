<?php

/**
 * This class represents one user.
 * A user can have a username and password.
 * This class contains only getter and setter methods.
 */
class User {

    private $username;
    private $password;

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

}