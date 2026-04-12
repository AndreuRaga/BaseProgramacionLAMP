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
    <?php if (isset($_SESSION['usuario_id'])): ?>
        <a href="index.php?accion=agregar">Agregar vehículo</a>
    <?php endif; ?>

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
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <th>Opciones</th>
                    <?php endif; ?>
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
                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <td>
                                <a href="index.php?accion=editar&id=<?=$vehiculo->getId()?>">Editar</a>
                                <a href="index.php?accion=eliminar&id=<?=$vehiculo->getId()?>">Eliminar</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>