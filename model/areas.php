<?php

require_once 'conexion.php';

class areas {

    private $are_id;
    private $are_titulo;
    private $usr_id;
    private $are_estado;
    private $fecha_creacion; 
    private $are_referencia;
    private $objPdo;

    public function __construct($are_id = NULL, $are_titulo = '', $usr_id = '', $are_estado = '', $fecha_creacion = '', $are_referencia = '') { // produccion 2019
        $this->are_id = $are_id;
        $this->are_titulo = $are_titulo;
        $this->usr_id = $usr_id;
        $this->are_estado = $are_estado;
        $this->fecha_creacion = $fecha_creacion;
        $this->are_referencia = $are_referencia;
        $this->objPdo = new Conexion();
    }

    public function consultar() { // produccion 2019
        $stmt = $this->objPdo->prepare("SELECT a.* , r.codarea, r.descripcion FROM PROMGAREAS a
 inner join   ". $_SESSION['server_vinculado'] ."rharea r  on r.codarea = a.are_referencia     
where a.eliminado = 0 ORDER BY a.are_id;");
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $areas;
    }
    
    public function consultarreferencia() { // produccion 2019
        $stmt = $this->objPdo->prepare("
               SELECT *
FROM ". $_SESSION['server_vinculado'] ."rharea
where eliminado = '0' and codarea NOT in  (SELECT are_referencia from PROMGAREAS)
                
");
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $areas;
    }
    
        public function consultarreferenciaid() { // produccion 2019
        $stmt = $this->objPdo->prepare("
               SELECT *
FROM ". $_SESSION['server_vinculado'] ."rharea
where eliminado = '0' 
                
");
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $areas;
    }

    public function consultarActivos() { // produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROMGAREAS where are_estado = '0' and eliminado = 0 ORDER BY are_id;");
        $stmt->execute();
        $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $departamentos;
    }

    
    public function obtenerxId($area_id) {// produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROMGAREAS WHERE are_id = :area_id");
        $stmt->execute(array('area_id' => $area_id));
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($areas as $area) {
            $this->setAre_id($area ['are_id']);
            $this->setAre_titulo($area ['are_titulo']);
            $this->setAre_estado($area ['are_estado']);
            $this->setUsr_id($area ['usr_id']);
            $this->setFecha_creacion($area ['fecha_creacion']);
             $this->setAre_referencia($area ['are_referencia']);
        }
        return $this;
    }

    public function insertar() {// produccion 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROMGAREAS (are_titulo, are_estado, usr_id, are_referencia) 
                                        VALUES(:are_titulo,
                                               :are_estado,
                                               :usr_id,
                                               :are_referencia)');
        $rows = $stmt->execute(array(
            'are_titulo' => $this->are_titulo,
            'are_estado' => $this->are_estado,
            'usr_id' => $this->usr_id,
            'are_referencia' => $this->are_referencia
                
                
                ));
    }

    public function modificar() {// produccion 2019
        $stmt = $this->objPdo->prepare('UPDATE PROMGAREAS SET are_titulo=:are_titulo, are_estado=:are_estado, usr_id=:usr_id, fecha_creacion = SYSDATETIME(), are_referencia=:are_referencia
                                        WHERE are_id = :are_id');
        $rows = $stmt->execute(array('are_titulo' => $this->are_titulo,
            'are_estado' => $this->are_estado,
            'usr_id' => $this->usr_id,
            'are_id' => $this->are_id,
            'are_referencia' =>  $this-> are_referencia));
    }

    public function eliminar($area_id) { //producción 2019
        $stmt = $this->objPdo->prepare("update  PROMGAREAS set eliminado = '1' WHERE are_id=:are_id");
        $rows = $stmt->execute(array('are_id' => $area_id));
        return $rows;
    }




    function getAre_id() {
        return $this->are_id;
    }

    function getAre_titulo() {
        return $this->are_titulo;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getAre_estado() {
        return $this->are_estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setAre_id($are_id) {
        $this->are_id = $are_id;
    }

    function setAre_titulo($are_titulo) {
        $this->are_titulo = $are_titulo;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setAre_estado($are_estado) {
        $this->are_estado = $are_estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }
    function getAre_referencia() {
        return $this->are_referencia;
    }

    function setAre_referencia($are_referencia) {
        $this->are_referencia = $are_referencia;
    }


}

?>
