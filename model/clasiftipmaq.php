<?php

require_once 'conexion.php';

class clasiftipmaq {

    private $clatipmaq_id;
    private $clatipmaq_titulo;
    private $usr_id;
    private $clatipmaq_estado;
    private $fecha_creacion;
    private $objPdo;

    public function __construct($clatipmaq_id = NULL, $clatipmaq_titulo = '', $usr_id = '', $clatipmaq_estado = '', $fecha_creacion = '') { // produccion 2019
        $this->clatipmaq_id = $clatipmaq_id;
        $this->clatipmaq_titulo = $clatipmaq_titulo;
        $this->usr_id = $usr_id;
        $this->clatipmaq_estado = $clatipmaq_estado;
        $this->fecha_creacion = $fecha_creacion;
        $this->objPdo = new Conexion();
    }

    public function consultar() { // produccion 2020
        $stmt = $this->objPdo->prepare("SELECT * FROM PROCLASIFTIPOMAQUINA
                where eliminado = 0 ORDER BY clatipmaq_id;");
        $stmt->execute();
        $clatipmaq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $clatipmaq;
    }

    public function consultarActivos() { // produccion 2020
        $stmt = $this->objPdo->prepare("SELECT * FROM PROCLASIFTIPOMAQUINA where clatipmaq_estado = '0' and eliminado = 0 ORDER BY clatipmaq_id;");
        $stmt->execute();
        $clatipmaq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $clatipmaq;
    }

    public function obtenerxId($clatipmaq_id) {// produccion 2020
        $stmt = $this->objPdo->prepare("SELECT * FROM PROCLASIFTIPOMAQUINA WHERE clatipmaq_id =:clatipmaq_id");
        $stmt->execute(array('clatipmaq_id' => $clatipmaq_id));
        $clasifclatipmaq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($clasifclatipmaq as $clasif) {
            $this->setClatipmaq_id($clasif ['clatipmaq_id']);
            $this->setClatipmaq_titulo($clasif ['clatipmaq_titulo']);
            $this->setClatipmaq_estado($clasif ['clatipmaq_estado']);
            $this->setUsr_id($clasif ['usr_id']);
            $this->setFecha_creacion($clasif ['fecha_creacion']);
        }
        return $this;
    }

    public function insertar() {// produccion 2020
        $stmt = $this->objPdo->prepare('INSERT INTO PROCLASIFTIPOMAQUINA (clatipmaq_titulo, clatipmaq_estado, usr_id) 
                                        VALUES(:clatipmaq_titulo,
                                               :clatipmaq_estado,
                                               :usr_id)');
        $rows = $stmt->execute(array('clatipmaq_titulo' => $this->clatipmaq_titulo,
            'clatipmaq_estado' => $this->clatipmaq_estado,
            'usr_id' => $this->usr_id));
    }

    public function modificar() {// produccion 2020
        $stmt = $this->objPdo->prepare('UPDATE PROCLASIFTIPOMAQUINA SET 
            clatipmaq_titulo=:clatipmaq_titulo, clatipmaq_estado=:clatipmaq_estado, usr_id=:usr_id, fecha_creacion = SYSDATETIME()
                                        WHERE clatipmaq_id = :clatipmaq_id');
        $rows = $stmt->execute(array('clatipmaq_titulo' => $this->clatipmaq_titulo,
            'clatipmaq_estado' => $this->clatipmaq_estado,
            'usr_id' => $this->usr_id,
            'clatipmaq_id' => $this->clatipmaq_id));
    }

    public function eliminar($clasem_id) { //producción 2020
        $stmt = $this->objPdo->prepare("update  PROCLASIFTIPOMAQUINA set eliminado = '1' WHERE clatipmaq_id=:clatipmaq_id");
        $rows = $stmt->execute(array('clasem_id' => $clasem_id));
        return $rows;
    }


    function getClatipmaq_id() {
        return $this->clatipmaq_id;
    }

    function getClatipmaq_titulo() {
        return $this->clatipmaq_titulo;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getClatipmaq_estado() {
        return $this->clatipmaq_estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setClatipmaq_id($clatipmaq_id) {
        $this->clatipmaq_id = $clatipmaq_id;
    }

    function setClatipmaq_titulo($clatipmaq_titulo) {
        $this->clatipmaq_titulo = $clatipmaq_titulo;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setClatipmaq_estado($clatipmaq_estado) {
        $this->clatipmaq_estado = $clatipmaq_estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }



}

?>