<!DOCTYPE html>
<html>
<head>
    <title>Proyecto: Sistema de Gestión de Flota de Vehículos</title>
</head>
<body>
    <h1>Agregar vehículo</h1>

    <?php if ($error != null): ?>
        <p style="color: red;"><strong><?= $error ?></strong></p>
    <?php endif; ?>

    <form action="index.php?accion=agregar" method="post">
        <label for="tipoVehiculo">Tipo de vehículo:</label>
        <select id="tipoVehiculo" name="tipoVehiculo" required>
            <option value="Coche">Coche</option>
            <option value="Motocicleta">Motocicleta</option>
        </select>
        <br><br>
        <label>Marca:</label>
        <input type="text" name="marca" required>
        <br><br>
        <label>Modelo:</label>
        <input type="text" name="modelo" required>
        <br><br>
        <label>Matrícula:</label>
        <input type="text" name="matricula" required>
        <br><br>
        <label>Precio por día:</label>
        <input type="number" name="precioDia" step="0.01" required>
        <br><br>
        <label>Número de puertas (coches):</label>
        <input type="number" name="numeroPuertas">
        <br><br>
        <label for="tipoCombustible">Tipo de combustible (coches):</label>
        <select id="tipoCombustible" name="tipoCombustible">
            <option value="Diésel">Diésel</option>
            <option value="Gasolina">Gasolina</option>
            <option value="Eléctrico">Eléctrico</option>
            <option value="Híbrido">Híbrido</option>
        </select>
        <br><br>
        <label>Cilindrada (motos):</label>
        <input type="number" name="cilindrada">
        <br><br>
        <label for="incluyeCasco">¿Incluye casco? (motos):</label>
        <input type="checkbox" id="incluyeCasco" name="incluyeCasco">
        <br><br>
        <a href="index.php">Volver</a>
        <input type="submit" value="Guardar">
    </form>
</body>
</html>