<?php
    require_once 'autoload.php';
    session_start();
    
    $gestor = new GestorPDO();
    $vehiculoController = new VehiculoController($gestor);
    $usuarioController = new UsuarioController($gestor);

    $accion = $_GET['accion'] ?? 'index';

    switch ($accion) {
        //Gestión de usuarios
        case 'login':
            $usuarioController->login();
            break;
        case 'alta':
            $usuarioController->alta();
            break;
        case 'logout':
            $usuarioController->logout();
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
            if ($accion === 'agregar') {
                $vehiculoController->agregar();
            } else if ($accion === 'editar') {
                $vehiculoController->editar();
            } else if ($accion === 'eliminar') {
                $vehiculoController->eliminar();
            }
            break;
        default:
            $vehiculoController->index();
            break;
    }
?>