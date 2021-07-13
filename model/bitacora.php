<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bitacora
 *
 * @author adminpc
 */
require_once 'conexion.php';

class bitacora {

    private $bit_id;
    private $usr_id;
    private $bit_accion;
    private $bit_tabla;
     private $bit_host;
    private $bit_hostname;
    private $fecha_registro;
    
   
    private $objPdo;

    function __construct($bit_id= null, $usr_id='', $bit_accion='',$bit_tabla='',   $bit_host='', $bit_hostname='',$fecha_registro='') { //produccion 2019
        $this->bit_id = $bit_id;
        $this->usr_id = $usr_id;
        $this->bit_accion = $bit_accion;
        $this->bit_tabla = $bit_tabla;
       
         $this->bit_host = $bit_host=$_SERVER['REMOTE_ADDR'];
        $this->bit_hostname = $bit_hostname = gethostname();
//         $this->bit_hostname = gethostbyaddr($bit_host);
        $this->fecha_registro = $fecha_registro;
        
       
        $this->objPdo = new Conexion();
    }

    public function insertar() { //produccion 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROMGBITACORA( usr_id, bit_accion , bit_tabla, bit_host, bit_hosname) 
            VALUES (:usr_id, :bit_accion,:bit_tabla,:bit_host,:bit_hosname);');
        $rows = $stmt->execute(array('usr_id' => $this->usr_id,
            'bit_accion' => $this->bit_accion,
            'bit_tabla' => $this->bit_tabla,
            'bit_host' => $this->bit_host,
            'bit_hosname' => $this->bit_hosname));
    }

    public function consultar() {
        $stmt = $this->objPdo->prepare("
            select  bita.*, usu.usr_nickname
from PROMGBITACORA bita
inner join PROMGUSUARIOS usu on usu.usr_id  = bita.usr_id
                "
                
               );
        $stmt->execute();
        $bit = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $bit;
    }
    function getBit_id() {
        return $this->bit_id;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getBit_accion() {
        return $this->bit_accion;
    }

    function getBit_tabla() {
        return $this->bit_tabla;
    }

    function getBit_host() {
        return $this->bit_host;
    }

    function getBit_hostname() {
        return $this->bit_hostname;
    }

    function getFecha_registro() {
        return $this->fecha_registro;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setBit_id($bit_id) {
        $this->bit_id = $bit_id;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setBit_accion($bit_accion) {
        $this->bit_accion = $bit_accion;
    }

    function setBit_tabla($bit_tabla) {
        $this->bit_tabla = $bit_tabla;
    }

    function setBit_host($bit_host) {
        $this->bit_host = $bit_host;
    }

    function setBit_hostname($bit_hostname) {
        $this->bit_hostname = $bit_hostname;
    }

    function setFecha_registro($fecha_registro) {
        $this->fecha_registro = $fecha_registro;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }



}