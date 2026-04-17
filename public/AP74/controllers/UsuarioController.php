<?php
class UsuarioController {
    protected $gestor;

    public function __construct($gestor) {
        $this->gestor = $gestor;
    }

    public function index() {
        include 'views/main.php';
    }

    public function alta() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $passwordPlana = $_POST['password'];

            //1. Hasheamos la contraseña
            $passwordHash = password_hash($passwordPlana, PASSWORD_DEFAULT);
            
            //2. Creamos el objeto Usuario (sin ID, porque es nuevo)
            $nuevoUsuario = new Usuario($email, $passwordHash);

            //3. Pasamos el objeto al gestor
            $this->gestor->registrarUsuario($nuevoUsuario);
            
            header('Location: index.php?accion=login');
            exit();
        }

        include 'views/alta.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $passwordPlana = $_POST['password'];
            $recordarme = isset($_POST['recordarme']);

            //1. Buscamos al usuario (ahora devuelve un objeto Usuario o false)
            $usuario = $this->gestor->buscarUsuarioPorEmail($email);

            //2. Usamos los Getters del objeto para la validación
            if ($usuario && password_verify($passwordPlana, $usuario->getPassword())) {
                //Login correcto
                $_SESSION['usuario_id'] = $usuario->getId();
                $_SESSION['usuario_email'] = $usuario->getEmail();

                //3. Gestion de cookies para "Recordarme"
                if ($recordarme) {
                    //Creamos un token único (pudes guardarlo en BD para más seguridad)
                    $token = base64_encode($usuario->getEmail());

                    // Seteamos la cookie: dura 30 días
                    setcookie(
                        'usuario_login',
                        $token,
                        [
                            'expires' => time() + (86400 * 30), // 30 días
                            'path' => '/',
                            'httponly' => true, // Seguridad: No accesible por JavaScript
                            'samesite' => 'Strict'
                        ]
                    );
                }

                header('Location: index.php');
                exit();
            } else {
                $error = "Credenciales incorrectas";
            }
        }

        include 'views/login.php';
    }

    public function logout() {
        //Vaciamos las variables de sesión
        $_SESSION = [];

        //Destruimos la sesión completamente
        session_destroy();

        //Eliminamos la cookie al cerrar sesión
        if (isset($_COOKIE['usuario_login'])) {
            setcookie('usuario_login', '', time() - 3600000, '/');
        }

        //Redirigimos al inicio
        header('Location: index.php?accion=login');
        exit();
    }

    public function cambiarFondo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['colorPicker'])) {
            $colorSeleccionado = $_POST['colorPicker'];
            $_SESSION['color_fondo'] = $colorSeleccionado;

            // Guardamos el color en una cookie para persistencia a largo plazo
            setcookie(
                'color_fondo',
                base64_encode($colorSeleccionado),
                [
                    'expires' => time() + (86400 * 30), // 30 días
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]
            );
        }

        header('Location: index.php');
        exit();
    }
}