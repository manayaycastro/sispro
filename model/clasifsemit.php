<?php

require_once 'conexion.php';

class clasifsemit {

    private $clasem_id;
    private $clasem_titulo;
    private $usr_id;
    private $clasem_estado;
    private $fecha_creacion;
    private $objPdo;

    public function __construct($clasem_id = NULL, $clasem_titulo = '', $usr_id = '', $clasem_estado = '', $fecha_creacion = '') { // produccion 2019
        $this->clasem_id = $clasem_id;
        $this->clasem_titulo = $clasem_titulo;
        $this->usr_id = $usr_id;
        $this->clasem_estado = $clasem_estado;
        $this->fecha_creacion = $fecha_creacion;
        $this->objPdo = new Conexion();
    }

    public function consultar() { // produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROCLASIFSEMITERMINADO
                where eliminado = 0 ORDER BY clasem_id;");
        $stmt->execute();
        $semiter = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $semiter;
    }

    public function consultarActivos() { // produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROCLASIFSEMITERMINADO where clasem_estado = '0' and eliminado = 0 ORDER BY clasem_id;");
        $stmt->execute();
        $semiter = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $semiter;
    }

    public function obtenerxId($clasem_id) {// produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROCLASIFSEMITERMINADO WHERE clasem_id =:clasem_id");
        $stmt->execute(array('clasem_id' => $clasem_id));
        $clasifsemiter = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($clasifsemiter as $clasif) {
            $this->setClasem_id($clasif ['clasem_id']);
            $this->setClasem_titulo($clasif ['clasem_titulo']);
            $this->setClasem_estado($clasif ['clasem_estado']);
            $this->setUsr_id($clasif ['usr_id']);
            $this->setFecha_creacion($clasif ['fecha_creacion']);
        }
        return $this;
    }

    public function insertar() {// produccion 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROCLASIFSEMITERMINADO (clasem_titulo, clasem_estado, usr_id) 
                                        VALUES(:clasem_titulo,
                                               :clasem_estado,
                                               :usr_id)');
        $rows = $stmt->execute(array('clasem_titulo' => $this->clasem_titulo,
            'clasem_estado' => $this->clasem_estado,
            'usr_id' => $this->usr_id));
    }

    public function modificar() {// produccion 2019
        $stmt = $this->objPdo->prepare('UPDATE PROCLASIFSEMITERMINADO SET 
            clasem_titulo=:clasem_titulo, clasem_estado=:clasem_estado, usr_id=:usr_id, fecha_creacion = SYSDATETIME()
                                        WHERE clasem_id = :clasem_id');
        $rows = $stmt->execute(array('clasem_titulo' => $this->clasem_titulo,
            'clasem_estado' => $this->clasem_estado,
            'usr_id' => $this->usr_id,
            'clasem_id' => $this->clasem_id));
    }

    public function eliminar($clasem_id) { //producción 2019
        $stmt = $this->objPdo->prepare("update  PROCLASIFSEMITERMINADO set eliminado = '1' WHERE clasem_id=:clasem_id");
        $rows = $stmt->execute(array('clasem_id' => $clasem_id));
        return $rows;
    }


    function getClasem_id() {
        return $this->clasem_id;
    }

    function getClasem_titulo() {
        return $this->clasem_titulo;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getClasem_estado() {
        return $this->clasem_estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setClasem_id($clasem_id) {
        $this->clasem_id = $clasem_id;
    }

    function setClasem_titulo($clasem_titulo) {
        $this->clasem_titulo = $clasem_titulo;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setClasem_estado($clasem_estado) {
        $this->clasem_estado = $clasem_estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }





}

?>