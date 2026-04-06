<!DOCTYPE html>
<html>
<head>
    <title>Registro de usuario</title>
</head>
<body>
    <h1>Crear nueva cuenta</h1>
    <form method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" minlength="4" required>
        <br><br>
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="index.php?accion=login">Inicia sesión aquí</a>.</p>
    <a href="index.php">Volver al inicio</a>
</body>
</html>