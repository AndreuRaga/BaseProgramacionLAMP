<?php

class ControllerVehiculo {
    protected $gestor;

    public function __construct($gestor) {
        $this->gestor = $gestor;
    }

    public function index() {
        $arrayVehiculos = $this->gestor->listar();
        //var_dump($arrayVehiculos);
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->gestor->editar($_POST['id']);
            
            header('Location: index.php');
            exit();
        }
    }
}