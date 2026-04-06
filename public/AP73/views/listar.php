<html>
<head>
    <title>Proyecto: Sistema de Gestión de Flota de Vehículos</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
    <h1>Proyecto: Sistema de Gestión de Flota de Vehículos</h1>
    <div style="background-color: #f8f9fa; padding: 10px; margin-bottom: 20px;">
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <p>Bienvenido, <b><?= $_SESSION['usuario_email'] ?></b> | <a href="index.php?accion=logout">Cerrar sesión</a></p>
        <?php else: ?>
            <p><a href="index.php?accion=login">Iniciar sesión</a> | <a href="index.php?accion=alta">Registrarse</a></p>
        <?php endif; ?>
    </div>
    
    <h2>Listado de vehículos</h2>
    <a href="index.php?accion=agregar">Agregar vehículo</a>
    

    <div class="container-fluid">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de vehículo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Matrícula</th>
                    <th>Precio por día</th>
                    <th>Número de puertas</th>
                    <th>Tipo de combustible</th>
                    <th>Cilindrada</th>
                    <th>¿Incluye casco?</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arrayVehiculos as $vehiculo): ?>
                    <tr>
                        <td><?=$vehiculo->getId()?></td>
                        <?php
                        if ($vehiculo instanceof Coche) {
                            echo '<td>' . 'Coche' . '</td>';
                        } else {
                            echo '<td>' . 'Motocicleta' . '</td>';
                        }
                        echo '<td>' . $vehiculo->getMarca() . '</td>';
                        echo '<td>' . $vehiculo->getModelo() . '</td>';
                        echo '<td>' . $vehiculo->getMatricula() . '</td>';
                        echo '<td>' . $vehiculo->getPrecioDia() . '</td>';
                        if ($vehiculo instanceof Coche) {
                            echo '<td>' . $vehiculo->getNumeroPuertas() . '</td>';
                            echo '<td>' . $vehiculo->getTipoCombustible() . '</td>';
                        } else {
                            echo '<td>' . 'N/A' . '</td>';
                            echo '<td>' . 'N/A' . '</td>';
                        }

                        if ($vehiculo instanceof Motocicleta) {
                            echo '<td>' . $vehiculo->getCilindrada() . '</td>';
                            echo '<td>' . ($vehiculo->getIncluyeCasco() ? 'Sí' : 'No') . '</td>';
                        } else {
                            echo '<td>' . 'N/A' . '</td>';
                            echo '<td>' . 'N/A' . '</td>';
                        }
                        ?>
                        <td>
                            <form action="index.php?accion=editar" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?=$vehiculo->getId()?>">
                                <input type="hidden" name="tipoVehiculo" value="<?= get_class($vehiculo) ?>">
                                <label>Marca:</label>
                                <input type="text" name="marca" value="<?=$vehiculo->getMarca()?>" required>

                                <label>Modelo:</label>
                                <input type="text" name="modelo" value="<?=$vehiculo->getModelo()?>" required>
                                
                                <label>Matrícula:</label>
                                <input type="text" name="matricula" value="<?=$vehiculo->getMatricula()?>" required>
                                
                                <label>Precio por día:</label>
                                <input type="number" name="precioDia" step="0.01" value="<?=$vehiculo->getPrecioDia()?>" required>
                                
                                <?php if ($vehiculo instanceof Coche): ?>
                                <label>Número de puertas:</label>
                                <input type="number" name="numeroPuertas" value="<?=$vehiculo->getNumeroPuertas()?>">
                                
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
                                
                                <label for="incluyeCasco">¿Incluye casco?</label>
                                <input type="checkbox" id="incluyeCasco" name="incluyeCasco" <?= $vehiculo->getIncluyeCasco() ? 'checked' : '' ?>>
                                <?php endif; ?>
                                <br>
                                <input type="submit" value="Editar">
                            </form>
                            
                            <a href="index.php?accion=eliminar&id=<?=$vehiculo->getId()?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>