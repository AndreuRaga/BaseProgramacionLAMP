<?php
    require_once 'autoload.php';
    session_start();
    
    $gestor = new GestorPDO();
    
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
            setcookie('color_fondo', '', time() - 36000, '/');
        }
    }
    if (isset($_SESSION['usuario_id']) && isset($_COOKIE['color_fondo'])) {
        $_SESSION['color_fondo'] = base64_decode($_COOKIE['color_fondo']);
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
        case 'cambiar_fondo':
            $usuarioController->cambiarFondo();
            break;
        default:
            $usuarioController->index();
            break;
    }
?>