<?php

class GestorPDO extends Connection {
    
    public function __construct() {
        parent::__construct();
    }

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

    public function eliminar($id) {
        $consulta = "DELETE FROM flotaVehiculos WHERE id = :id";
        $stmt = $this->getConn()->prepare($consulta);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function editar($id) {
        // Evitar duplicados de matrícula (excluyendo el vehículo actual)
        $consulta = "SELECT COUNT(*) FROM flotaVehiculos WHERE matricula = :matricula AND id != :id";
        $stmt = $this->getConn()->prepare($consulta);
        $stmt->bindValue(':matricula', $_POST['matricula']);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        $consulta = "UPDATE flotaVehiculos SET marca = :marca, modelo = :modelo, matricula = :matricula, precioDia = :precioDia, numeroPuertas = :numeroPuertas, tipoCombustible = :tipoCombustible, cilindrada = :cilindrada, incluyeCasco = :incluyeCasco WHERE id = :id";
        $stmt = $this->getConn()->prepare($consulta);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':marca', $_POST['marca']);
        $stmt->bindValue(':modelo', $_POST['modelo']);
        $stmt->bindValue(':matricula', $_POST['matricula']);
        $stmt->bindValue(':precioDia', $_POST['precioDia']);
        $tipoVehiculo = $_POST['tipoVehiculo'];
        if ($tipoVehiculo === 'Coche') {
            $stmt->bindValue(':numeroPuertas', $_POST['numeroPuertas']);
            $stmt->bindValue(':tipoCombustible', $_POST['tipoCombustible']);
            $stmt->bindValue(':cilindrada', null);
            $stmt->bindValue(':incluyeCasco', null);
        } else {
            $stmt->bindValue(':numeroPuertas', null);
            $stmt->bindValue(':tipoCombustible', null);
            $stmt->bindValue(':cilindrada', $_POST['cilindrada']);
            $stmt->bindValue(':incluyeCasco', isset($_POST['incluyeCasco']) ? 1 : 0);
        }
        return $stmt->execute();
    }
}