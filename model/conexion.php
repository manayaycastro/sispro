<?php

class Conexion extends PDO {

    private $serverName = "SIN-PC05VM02\SQLEXPRESS";
    private $connectionInfo = "DBPRODUCCION";

    //  private $conn;

    public function __construct() {

        try {

            parent::__construct("sqlsrv:server=$this->serverName ; Database=$this->connectionInfo", "", "");
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
            exit;
        }
    }

}
