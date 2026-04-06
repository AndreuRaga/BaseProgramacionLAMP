<?php
class ControllerUsuario {
    protected $gestor;

    public function __construct($gestor) {
        $this->gestor = $gestor;
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
}