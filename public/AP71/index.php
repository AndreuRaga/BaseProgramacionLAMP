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
            $connection = new Connection();
            //Consulta de datos
            $query = 'SELECT * From Person';
            $stmt = $connection->getConn()->query($query);

            echo '<table class="table table-striped">';
            echo '<thead><tr><th>id</th><th>name</th></tr></thead>';
            while ($value = $stmt->fetch(PDO::FETCH_ASSOC)){
                echo '<tr>';
                foreach ($value as $element){
                    echo '<td>' . $element . '</td>';
                }

                echo '</tr>';
            }
            echo '</table>';
        ?>
</body>
</html>