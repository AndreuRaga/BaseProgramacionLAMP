<?php

class GestorPDO extends Connection {
    
    public function __construct() {
        parent::__construct();
    }

    public function listar() {
        $consulta = "SELECT * FROM Person";
        $rtdo = $this->getConn()->query($consulta);
        $arrayPersonas = [];

        while ($value = $rtdo->fetch(PDO::FETCH_ASSOC)) {
            $persona = new Persona($value['id'], $value['nombre']);
            $arrayPersonas[] = $persona;
        }
        
        return $arrayPersonas;
    }
}