<html>
<head>
    <title>Welcome to LAMP Infrastructure</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <?php
            require_once 'autoload.php';
            echo "<h1>Hello, Welcome DAW Student!</h1>";
            $gestor = new GestorPDO();

            echo '<table class="table table-striped">';
            echo '<thead><tr><th>id</th><th>name</th></tr></thead>';
            //Consulta de datos
            $arrayPersonas = $gestor->listar();
            foreach ($arrayPersonas as $persona) {
                echo '<td>' . $persona->getId() . '</td>';
                echo '<td>' . $persona->getNombre() . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        ?>
</body>
</html>