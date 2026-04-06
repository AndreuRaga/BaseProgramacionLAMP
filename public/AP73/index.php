<?php
    require_once 'autoload.php';
    
    $gestor = new GestorPDO();
    $controller = new ControllerVehiculo($gestor);

    $accion = $_GET['accion'] ?? 'index';

    switch ($accion) {
        //Gestión de usuarios
        case 'login':
            $controller->login();
            break;
        case 'alta':
            $controller->alta();
            break;
        case 'logout':
            $controller->logout();
            break;
        //Gestión de vehículos
        case 'editar':
            $controller->editar();
            break;
        case 'eliminar':
            $controller->eliminar();
            break;
        case 'agregar':
            $controller->agregar();
            break;
        default:
            $controller->index();
            break;
    }
?>