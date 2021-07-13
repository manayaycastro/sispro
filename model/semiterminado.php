<?php

require_once 'conexion.php';

class semiterminado {

    private $tipsem_id;
    private $tipsem_titulo;
    private $usr_id;
    private $tipsem_estado;
    private $fecha_creacion;
    private $are_id;
    private $objPdo;

    public function __construct($tipsem_id = NULL, $tipsem_titulo = '', $usr_id = '', $tipsem_estado = '', $fecha_creacion = '' , $are_id = '') { // produccion 2019
        $this->tipsem_id = $tipsem_id;
        $this->tipsem_titulo = $tipsem_titulo;
        $this->usr_id = $usr_id;
        $this->tipsem_estado = $tipsem_estado;
        $this->fecha_creacion = $fecha_creacion;
        $this->are_id =  $are_id;
        $this->objPdo = new Conexion();
    }

    public function consultar() { // produccion 2019
        $stmt = $this->objPdo->prepare("SELECT semi.*, ar.are_titulo FROM PROTIPOSEMITERMINADO semi
inner join PROMGAREAS ar on ar.are_id = semi.are_id
 where semi.eliminado = 0 ORDER BY semi.tipsem_id;");
        $stmt->execute();
        $semiter = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $semiter;
    }

    public function consultarActivos() { // produccion 2019
        $stmt = $this->objPdo->prepare("SELECT *  , tipsem_id AS tipsem_id2 FROM PROTIPOSEMITERMINADO where tipsem_estado = '0' and eliminado = 0 ORDER BY tipsem_id;");
        $stmt->execute();
        $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $departamentos;
    }

    public function obtenerxId($tipsem_id) {// produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROTIPOSEMITERMINADO WHERE tipsem_id =:tipsem_id");
        $stmt->execute(array('tipsem_id' => $tipsem_id));
        $tipsemi = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tipsemi as $tip) {
            $this->setTipsem_id($tip ['tipsem_id']);
            $this->setTipsem_titulo($tip ['tipsem_titulo']);
            $this->setTipsem_estado($tip ['tipsem_estado']);
            $this->setUsr_id($tip ['usr_id']);
            $this->setFecha_creacion($tip ['fecha_creacion']);
            $this->setAre_id($tip ['are_id']);
        }
        return $this;
    }

    public function insertar() {// produccion 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROTIPOSEMITERMINADO (tipsem_titulo, tipsem_estado, usr_id, are_id)
                                        VALUES(:tipsem_titulo,
                                               :tipsem_estado,
                                               :usr_id,
                                               :are_id)');
        $rows = $stmt->execute(array('tipsem_titulo' => $this->tipsem_titulo,
            'tipsem_estado' => $this->tipsem_estado,
            'usr_id' => $this->usr_id, 'are_id'=> $this->are_id)); 
    }

    public function modificar() {// produccion 2019
        $stmt = $this->objPdo->prepare('UPDATE PROTIPOSEMITERMINADO SET 
            tipsem_titulo=:tipsem_titulo, tipsem_estado=:tipsem_estado, usr_id=:usr_id, fecha_creacion = SYSDATETIME(), are_id=:are_id
                                        WHERE tipsem_id = :tipsem_id');
        $rows = $stmt->execute(array('tipsem_titulo' => $this->tipsem_titulo,
            'tipsem_estado' => $this->tipsem_estado,
            'usr_id' => $this->usr_id,
            'are_id' => $this->are_id,
            'tipsem_id' => $this->tipsem_id));
    }

    public function eliminar($tipsem_id) { //producción 2019
        $stmt = $this->objPdo->prepare("update  PROTIPOSEMITERMINADO set eliminado = '1' WHERE tipsem_id=:tipsem_id");
        $rows = $stmt->execute(array('tipsem_id' => $tipsem_id));
        return $rows;
    }


    function getAre_id() {
        return $this->are_id;
    }

    function setAre_id($are_id) {
        $this->are_id = $are_id;
    }

    
    function getTipsem_id() {
        return $this->tipsem_id;
    }

    function getTipsem_titulo() {
        return $this->tipsem_titulo;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getTipsem_estado() {
        return $this->tipsem_estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setTipsem_id($tipsem_id) {
        $this->tipsem_id = $tipsem_id;
    }

    function setTipsem_titulo($tipsem_titulo) {
        $this->tipsem_titulo = $tipsem_titulo;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setTipsem_estado($tipsem_estado) {
        $this->tipsem_estado = $tipsem_estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }


}

?>