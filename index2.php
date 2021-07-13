<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $serverName = "SIN-PC05VM02\SQLEXPRESS";
        $connectionInfo = "ELAGUILAPRUEBA";
        $conn;
        try {
            $conn = new PDO("sqlsrv:server=$serverName ; Database=$connectionInfo", "", "");
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
            exit;
        }
        if ($conn) {
            echo "Conexión establecida.<br />";
        } else {
            echo "Conexión no se pudo establecer.<br />";
            die(print_r(sqlsrv_errors(), true));
        }

        date_default_timezone_set('America/Lima');

        function d($array) {
            echo "<pre>";
            print_r($array);
            echo "</pre>";
            exit();
        }
        ?>



        ?>
    </body>
</html>
