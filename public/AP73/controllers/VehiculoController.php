<?php

class VehiculoController {
    protected $gestor;

    public function __construct($gestor) {
        $this->gestor = $gestor;
    }

    public function index() {
        $arrayVehiculos = $this->gestor->listar();
        include 'views/listar.php';
    }

    public function agregar() {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipoVehiculo = $_POST['tipoVehiculo'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $matricula = $_POST['matricula'];
            $precioDia = $_POST['precioDia'];
            $numeroPuertas = $_POST['numeroPuertas'] ?? null;
            $tipoCombustible = $_POST['tipoCombustible'] ?? null;
            $cilindrada = $_POST['cilindrada'] ?? null;
            $incluyeCasco = isset($_POST['incluyeCasco']) ? 1 : 0;

            if ($tipoVehiculo === 'Coche') {
                $vehiculo = new Coche(0, $marca, $modelo, $matricula, $precioDia, $numeroPuertas, $tipoCombustible);
            } else {
                $vehiculo = new Motocicleta(0, $marca, $modelo, $matricula, $precioDia, $cilindrada, $incluyeCasco);
            }

            if ($this->gestor->agregar($vehiculo) == false) {
                $error = '¡Ya existe un vehículo con esa matrícula!';
            } else {
                header('Location: index.php');
                exit();
            }
        }

        include 'views/agregar.php';
    }

    public function eliminar() {
        $id = $_GET['id'];
        $this->gestor->eliminar($id);

        header('Location: index.php');
        exit();
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        $vehiculo = $this->gestor->buscar($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vehiculo->setMarca($_POST['marca']);
            $vehiculo->setModelo($_POST['modelo']);
            $vehiculo->setMatricula($_POST['matricula']);
            $vehiculo->setPrecioDia($_POST['precioDia']);
            if ($vehiculo instanceof Coche) {
                $vehiculo->setNumeroPuertas($_POST['numeroPuertas']);
                $vehiculo->setTipoCombustible($_POST['tipoCombustible']);
            } else {
                $vehiculo->setCilindrada($_POST['cilindrada']);
                $vehiculo->setIncluyeCasco(isset($_POST['incluyeCasco']) ? 1 : 0);
            }

            $this->gestor->editar($vehiculo);

            header('Location: index.php');
            exit();
        }

        include "views/editar.php";
    }
}