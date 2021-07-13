<?php

require_once 'conexion.php';

class tipomaquina {

    private $tipmaq_id;
    private $tipmaq_titulo;
    private $usr_id;
    private $tipmaq_estado;
    private $fecha_creacion;
    private $are_id;
    private $objPdo;

    public function __construct($tipmaq_id = NULL, $tipmaq_titulo = '', $usr_id = '', $tipmaq_estado = '', $fecha_creacion = '' , $are_id = '') { // produccion 2019
        $this->tipmaq_id = $tipmaq_id;
        $this->tipmaq_titulo = $tipmaq_titulo;
        $this->usr_id = $usr_id;
        $this->tipmaq_estado = $tipmaq_estado;
        $this->fecha_creacion = $fecha_creacion;
        $this->are_id =  $are_id;
        $this->objPdo = new Conexion();
    }

    public function consultar() { // produccion 2019
        $stmt = $this->objPdo->prepare("SELECT tipmaq.*, ar.are_titulo FROM PROTIPOMAQUINA tipmaq
inner join PROMGAREAS ar on ar.are_id = tipmaq.are_id
 where tipmaq.eliminado = 0 ORDER BY tipmaq.tipmaq_id;");
        $stmt->execute();
        $tipmaq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tipmaq;
    }

    public function consultarActivos() { // produccion 2019
        $stmt = $this->objPdo->prepare(" SELECT *  , tipmaq_id AS tipmaq_id2 FROM PROTIPOMAQUINA where tipmaq_estado = '0' and eliminado = 0 ORDER BY tipmaq_id;");
        $stmt->execute();
        $tipmaq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tipmaq;
    }

    public function obtenerxId($tipmaq_id) {// produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROTIPOMAQUINA WHERE tipmaq_id =:tipmaq_id");
        $stmt->execute(array('tipmaq_id' => $tipmaq_id));
        $tipmaquina = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tipmaquina as $tip) {
            $this->setTipmaq_id($tip ['tipmaq_id']);
            $this->setTipmaq_titulo($tip ['tipmaq_titulo']);
            $this->setTipmaq_estado($tip ['tipmaq_estado']);
            $this->setUsr_id($tip ['usr_id']);
            $this->setFecha_creacion($tip ['fecha_creacion']);
            $this->setAre_id($tip ['are_id']);
        }
        return $this;
    }

    public function insertar() {// produccion 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROTIPOMAQUINA (tipmaq_titulo, tipmaq_estado, usr_id, are_id)
                                        VALUES(:tipmaq_titulo,
                                               :tipmaq_estado,
                                               :usr_id,
                                               :are_id)');
        $rows = $stmt->execute(array('tipmaq_titulo' => $this->tipmaq_titulo,
            'tipmaq_estado' => $this->tipmaq_estado,
            'usr_id' => $this->usr_id, 'are_id'=> $this->are_id)); 
    }

    public function modificar() {// produccion 2019
        $stmt = $this->objPdo->prepare('UPDATE PROTIPOMAQUINA SET 
            tipmaq_titulo=:tipmaq_titulo, tipmaq_estado=:tipmaq_estado, usr_id=:usr_id, fecha_creacion = SYSDATETIME(), are_id=:are_id
                                        WHERE tipmaq_id = :tipmaq_id');
        $rows = $stmt->execute(array('tipmaq_titulo' => $this->tipmaq_titulo,
            'tipmaq_estado' => $this->tipmaq_estado,
            'usr_id' => $this->usr_id,
            'are_id' => $this->are_id,
            'tipmaq_id' => $this->tipmaq_id));
    }

    public function eliminar($tipmaq_id) { //producción 2019
        $stmt = $this->objPdo->prepare("update  PROTIPOMAQUINA set eliminado = '1' WHERE tipmaq_id=:tipmaq_id");
        $rows = $stmt->execute(array('tipmaq_id' => $tipmaq_id));
        return $rows;
    }

    function getTipmaq_id() {
        return $this->tipmaq_id;
    }

    function getTipmaq_titulo() {
        return $this->tipmaq_titulo;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getTipmaq_estado() {
        return $this->tipmaq_estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getAre_id() {
        return $this->are_id;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setTipmaq_id($tipmaq_id) {
        $this->tipmaq_id = $tipmaq_id;
    }

    function setTipmaq_titulo($tipmaq_titulo) {
        $this->tipmaq_titulo = $tipmaq_titulo;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setTipmaq_estado($tipmaq_estado) {
        $this->tipmaq_estado = $tipmaq_estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setAre_id($are_id) {
        $this->are_id = $are_id;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }



}

?>