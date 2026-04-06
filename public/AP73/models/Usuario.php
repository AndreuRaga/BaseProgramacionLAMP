<?php
class Usuario {
    private $id;
    private $email;
    private $password;

    public function __construct($email, $password, $id = 0) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}