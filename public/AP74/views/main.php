<html>
<head>
    <title>AP74. Recordar datos mediante cookies</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body  style="background-color: <?= (isset($_SESSION['usuario_id']) && isset($_SESSION['color_fondo'])) ? $_SESSION['color_fondo'] : '#ffffff' ?>;">
    <h1>AP74. Recordar datos mediante cookies</h1>
    <div style="background-color: #f8f9fa; padding: 10px; margin-bottom: 20px;">
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <p>Bienvenido, <b><?= $_SESSION['usuario_email'] ?></b> | <a href="index.php?accion=logout">Cerrar sesión</a></p>
        <?php else: ?>
            <p><a href="index.php?accion=login">Iniciar sesión</a> | <a href="index.php?accion=alta">Registrarse</a></p>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['usuario_id'])): ?>
    <form method="POST" action="index.php?accion=cambiar_fondo">
        <button type="submit">Cambiar fondo</button>
        <input type="color" id="colorPicker" name="colorPicker">
    </form>
    <?php endif; ?>
</body>
</html>