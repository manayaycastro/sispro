<?php

class Conexion3 extends PDO {

     private $serverName = "SIN-PC05VM02\SQLEXPRESS";
     private $connectionInfo = "ELAGUILAPRUEBA";
     private   $conn;



    public function __construct() {

        try {
      
            $this->conn = new PDO("sqlsrv:server=$this->serverName ; Database=$this->connectionInfo", "", "");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
            
            
        } catch (PDOException $e) {
            echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
            exit;
       
        }
    }

}

