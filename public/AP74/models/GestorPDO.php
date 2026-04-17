<?php

class GestorPDO extends Connection {
    
    public function __construct() {
        parent::__construct();
    }

    //Gestión de vehículos
    public function listar() {
        $consulta = "SELECT * FROM flotaVehiculos";
        $rtdo = $this->getConn()->query($consulta);
        $arrayVehiculos = [];

        while ($value = $rtdo->fetch(PDO::FETCH_ASSOC)) {
            if ($value['tipoVehiculo'] === 'Coche') {
                $vehiculo = new Coche($value['id'], $value['marca'], $value['modelo'], $value['matricula'], $value['precioDia'], $value['numeroPuertas'], $value['tipoCombustible']);
            } else {
                $vehiculo = new Motocicleta($value['id'], $value['marca'], $value['modelo'], $value['matricula'], $value['precioDia'], $value['cilindrada'], $value['incluyeCasco']);
            }
            $arrayVehiculos[] = $vehiculo;
        }

        return $arrayVehiculos;
    }

    public function agregar($vehiculo) {
        // Evitar duplicados de matrícula
        $consulta = "SELECT COUNT(*) FROM flotaVehiculos WHERE matricula = :matricula";
        $stmt = $this->getConn()->prepare($consulta);
        $stmt->bindValue(':matricula', $vehiculo->getMatricula());
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        $consulta = "INSERT INTO flotaVehiculos (tipoVehiculo, marca, modelo, matricula, precioDia, numeroPuertas, tipoCombustible, cilindrada, incluyeCasco) VALUES (:tipoVehiculo, :marca, :modelo, :matricula, :precioDia, :numeroPuertas, :tipoCombustible, :cilindrada, :incluyeCasco)";
        $stmt = $this->getConn()->prepare($consulta);
        $stmt->bindValue(':tipoVehiculo', get_class($vehiculo));
        $stmt->bindValue(':marca', $vehiculo->getMarca());
        $stmt->bindValue(':modelo', $vehiculo->getModelo());
        $stmt->bindValue(':matricula', $vehiculo->getMatricula());
        $stmt->bindValue(':precioDia', $vehiculo->getPrecioDia());
        if ($vehiculo instanceof Coche) {
            $stmt->bindValue(':numeroPuertas', $vehiculo->getNumeroPuertas());
            $stmt->bindValue(':tipoCombustible', $vehiculo->getTipoCombustible());
            $stmt->bindValue(':cilindrada', null);
            $stmt->bindValue(':incluyeCasco', null);
        } else {
            $stmt->bindValue(':numeroPuertas', null);
            $stmt->bindValue(':tipoCombustible', null);
            $stmt->bindValue(':cilindrada', $vehiculo->getCilindrada());
            $stmt->bindValue(':incluyeCasco', $vehiculo->getIncluyeCasco());
        }
        return $stmt->execute();
    }

    public function buscar($id) {
        $sql = "SELECT * FROM flotaVehiculos WHERE id=$id";
        $stmt = $this->getConn()->query($sql);
 
        while ($value = $stmt->fetch(PDO::FETCH_ASSOC)){
            if ($value['tipoVehiculo'] == "Coche"){
                $vehiculo = new Coche ($value['id'], $value['marca'], $value['modelo'], $value['matricula'], $value['precioDia'], $value['numeroPuertas'], $value['tipoCombustible']);
            } else {
                $vehiculo = new Motocicleta ($value['id'], $value['marca'], $value['modelo'], $value['matricula'], $value['precioDia'], $value['cilindrada'], $value['incluyeCasco']);
            }
        return $vehiculo;
        }
    }

    public function editar($vehiculo) {
        // Evitar duplicados de matrícula (excluyendo el vehículo actual)
        $consulta = "SELECT COUNT(*) FROM flotaVehiculos WHERE matricula = :matricula AND id != :id";
        $stmt = $this->getConn()->prepare($consulta);
        $stmt->bindValue(':matricula', $vehiculo->getMatricula());
        $stmt->bindValue(':id', $vehiculo->getId());
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        $consulta = "UPDATE flotaVehiculos SET marca = :marca, modelo = :modelo, matricula = :matricula, precioDia = :precioDia, numeroPuertas = :numeroPuertas, tipoCombustible = :tipoCombustible, cilindrada = :cilindrada, incluyeCasco = :incluyeCasco WHERE id = :id";
        $stmt = $this->getConn()->prepare($consulta);
        $stmt->bindValue(':id', $vehiculo->getId());
        $stmt->bindValue(':marca', $vehiculo->getMarca());
        $stmt->bindValue(':modelo', $vehiculo->getModelo());
        $stmt->bindValue(':matricula', $vehiculo->getMatricula());
        $stmt->bindValue(':precioDia', $vehiculo->getPrecioDia());
        
        if ($vehiculo instanceof Coche) {
            $stmt->bindValue(':numeroPuertas', $vehiculo->getNumeroPuertas());
            $stmt->bindValue(':tipoCombustible', $vehiculo->getTipoCombustible());
            $stmt->bindValue(':cilindrada', null);
            $stmt->bindValue(':incluyeCasco', null);
        } else {
            $stmt->bindValue(':numeroPuertas', null);
            $stmt->bindValue(':tipoCombustible', null);
            $stmt->bindValue(':cilindrada', $vehiculo->getCilindrada());
            $stmt->bindValue(':incluyeCasco', $vehiculo->getIncluyeCasco());
        }
        return $stmt->execute();
    }

    public function eliminar($id) {
        $consulta = "DELETE FROM flotaVehiculos WHERE id = :id";
        $stmt = $this->getConn()->prepare($consulta);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
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