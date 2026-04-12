<?php
    require_once 'autoload.php';
    session_start();
    
    $gestor = new GestorPDO();
    $controllerVehiculo = new ControllerVehiculo($gestor);
    $controllerUsuario = new ControllerUsuario($gestor);

    $accion = $_GET['accion'] ?? 'index';

    switch ($accion) {
        //Gestión de usuarios
        case 'login':
            $controllerUsuario->login();
            break;
        case 'alta':
            $controllerUsuario->alta();
            break;
        case 'logout':
            $controllerUsuario->logout();
            break;
        //Gestión de vehículos. Técnica fall-through
        case 'agregar':
        case 'editar':
        case 'eliminar': 
            if (!isset($_SESSION['usuario_id'])) {
                header('Location: index.php?accion=login');
                exit();
            }
            //Si está autenticado, dejamos que ejecute la acción
            switch ($accion) {
                case 'agregar':
                    $controllerVehiculo->agregar();
                    break;
                case 'editar':
                    $controllerVehiculo->editar();
                    break;
                case 'eliminar':
                    $controllerVehiculo->eliminar();
                    break;
            }
        default:
            $controllerVehiculo->index();
            break;
    }
?>