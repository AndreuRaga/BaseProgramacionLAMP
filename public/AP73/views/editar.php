<!DOCTYPE html>
<html>
<head>
    <title>Editar vehículo</title>
</head>
<body>
    <h1>Editar vehículo</h1>

    <form method="POST">
        <label>Marca:</label>
        <input type="text" name="marca" value="<?=$vehiculo->getMarca()?>" required>
        <br><br>
        <label>Modelo:</label>
        <input type="text" name="modelo" value="<?=$vehiculo->getModelo()?>" required>
        <br><br>
        <label>Matrícula:</label>
        <input type="text" name="matricula" value="<?=$vehiculo->getMatricula()?>" required>
        <br><br>
        <label>Precio por día:</label>
        <input type="number" name="precioDia" step="0.01" value="<?=$vehiculo->getPrecioDia()?>" required>
        <br><br>
        <?php if ($vehiculo instanceof Coche): ?>
            <label>Número de puertas:</label>
            <input type="number" name="numeroPuertas" value="<?=$vehiculo->getNumeroPuertas()?>">
            <br><br>
            <label for="tipoCombustible">Tipo de combustible:</label>
            <select id="tipoCombustible" name="tipoCombustible" >
                <option value="Diésel" <?= $vehiculo->getTipoCombustible() === 'Diésel' ? 'selected' : '' ?>>Diésel</option>
                <option value="Gasolina" <?= $vehiculo->getTipoCombustible() === 'Gasolina' ? 'selected' : '' ?>>Gasolina</option>
                <option value="Eléctrico" <?= $vehiculo->getTipoCombustible() === 'Eléctrico' ? 'selected' : '' ?>>Eléctrico</option>
                <option value="Híbrido" <?= $vehiculo->getTipoCombustible() === 'Híbrido' ? 'selected' : '' ?>>Híbrido</option>
            </select>
        <?php endif; ?>
                                    
        <?php if ($vehiculo instanceof Motocicleta): ?>
            <label>Cilindrada:</label>
            <input type="number" name="cilindrada" value="<?=$vehiculo->getCilindrada()?>">
            <br><br>
            <label for="incluyeCasco">¿Incluye casco?</label>
            <input type="checkbox" id="incluyeCasco" name="incluyeCasco" <?= $vehiculo->getIncluyeCasco() ? 'checked' : '' ?>>
        <?php endif; ?>
        <br><br>
        <input type="submit" value="Editar">
    </form>
    <br>
    <a href="index.php">Volver al listado</a>
</body>
</html>