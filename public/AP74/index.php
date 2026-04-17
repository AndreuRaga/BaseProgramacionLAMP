<?php
    require_once 'autoload.php';
    session_start();
    
    $gestor = new GestorPDO();
    // $vehiculoController = new VehiculoController($gestor);
    $usuarioController = new UsuarioController($gestor);

    $accion = $_GET['accion'] ?? 'index';

    //--- LÓGICA DE COOKIES: RE-AUTENTICACIÓN AUTOMÁTICA ---
    //Si NO hay sesión iniciada, pero SÍ existe la cookie "usuario_login"
    if (!isset($_SESSION['usuario_id']) && isset($_COOKIE['usuario_login'])) {
        //1. Recuperamos el email que guardamos en la cookie (estaba en Base64)
        $emailRecuperado = base64_decode($_COOKIE['usuario_login']);

        //2. Buscamos al usuario en la base de datos
        $usuario = $gestor->buscarUsuarioPorEmail($emailRecuperado);

        //3. Si el usuario existe, restauramos la sesión automáticamente
        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario->getId();
            $_SESSION['usuario_email'] = $usuario->getEmail();
        } else {
            //Si la cookie es falsa o el usuario ya no existe, borramos la cookie por seguridad
            setcookie('usuario_login', '', time() - 36000, '/');
        }
    }
    //--- FIN DE LÓGICA DE COOKIES ---

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
        
        /*
        Gestión de vehículos. Técnica fall-through
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
        */
        default:
            $usuarioController->index();
            break;
    }
?>