<?php

class GestorPDO extends Connection {
    
    public function __construct() {
        parent::__construct();
    }

    //Gestión de usuarios
    public function registrarUsuario(Usuario $usuario) {
        try {
            $sql = "INSERT INTO Usuario (email, password) VALUES (:email, :password)";
            $stmt = $this->getConn()->prepare($sql);
            
            //Usamos los getters del objeto Usuario
            $stmt->bindValue(':email', $usuario->getEmail());
            $stmt->bindValue(':password', $usuario->getPassword());

            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage() . $e->getCode();
        }
    }

    public function buscarUsuarioPorEmail($email) {
        $sql = "SELECT * FROM Usuario WHERE email = :email LIMIT 1";
        $stmt = $this->getConn()->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $value = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //Si encontró algo, creamos y devolvemos un objeto Usuario
        if ($value) {
            return new Usuario($value['email'], $value['password'], $value['id']);
        }
        //Si no existe, devolvemos false o null
        return false;
    }
}