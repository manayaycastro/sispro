<?php

require_once 'conexion.php';

class paradatipo {

    private $tippar_id;
    private $tippar_titulo;
    private $usr_id;
    private $tippar_estado;
    private $fecha_creacion;
    private $objPdo;

    public function __construct($tippar_id = NULL, $tippar_titulo = '', $usr_id = '', $tippar_estado = '', $fecha_creacion = '') { // produccion 2019
        $this->tippar_id = $tippar_id;
        $this->tippar_titulo = $tippar_titulo;
        $this->usr_id = $usr_id;
        $this->tippar_estado = $tippar_estado;
        $this->fecha_creacion = $fecha_creacion;
        $this->objPdo = new Conexion();
    }

    
    
    
    public function consultar() { // produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROMGTIPOPARADA  where eliminado = 0 ORDER BY tippar_id;");
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $areas;
    }
   
    
    
    
    public function consultarActivos() { // produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROMGTIPOPARADA where tippar_estado = '0' ORDER BY tippar_id;");
        $stmt->execute();
        $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $departamentos;
    }
    
    
      public function obtenerxId($tippar_id) {// produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROMGTIPOPARADA WHERE tippar_id = :tippar_id");
        $stmt->execute(array('tippar_id' => $tippar_id));
        $tipparadas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($tipparadas as $tipparada) {
                $this->setTippar_id($tipparada ['tippar_id']);
                $this->setTippar_titulo($tipparada ['tippar_titulo']);
                $this->setTippar_estado($tipparada ['tippar_estado']);
                $this->setUsr_id($tipparada ['usr_id']);
                $this->setFecha_creacion($tipparada ['fecha_creacion']);
            }
            return $this;
    }
        
 
    public function insertar() {// produccion 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROMGTIPOPARADA (tippar_titulo, tippar_estado, usr_id) 
                                        VALUES(:tippar_titulo,
                                               :tippar_estado,
                                               :usr_id)');
        $rows = $stmt->execute(array('tippar_titulo' => $this->tippar_titulo,
                                     'tippar_estado' => $this->tippar_estado,
                                     'usr_id' => $this->usr_id));
    }

    public function modificar() {// produccion 2019
        $stmt = $this->objPdo->prepare('UPDATE PROMGTIPOPARADA SET tippar_titulo=:tippar_titulo, tippar_estado=:tippar_estado, usr_id=:usr_id, fecha_creacion = SYSDATETIME()
                                        WHERE tippar_id =:tippar_id');
        $rows = $stmt->execute(array('tippar_titulo' => $this->tippar_titulo,
                                    'tippar_estado' => $this->tippar_estado,
                                    'usr_id' => $this->usr_id,
                                    'tippar_id' => $this->tippar_id));
    }
    
    
    
        public function eliminar($tippar_id) { //producción 2019
        $stmt = $this->objPdo->prepare("update  PROMGTIPOPARADA set eliminado = '1' WHERE tippar_id=:tippar_id");
        $rows = $stmt->execute(array('tippar_id' => $tippar_id));
        return $rows;
    }
 
    
    
    
    function getTippar_id() {
        return $this->tippar_id;
    }

    function getTippar_titulo() {
        return $this->tippar_titulo;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getTippar_estado() {
        return $this->tippar_estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setTippar_id($tippar_id) {
        $this->tippar_id = $tippar_id;
    }

    function setTippar_titulo($tippar_titulo) {
        $this->tippar_titulo = $tippar_titulo;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setTippar_estado($tippar_estado) {
        $this->tippar_estado = $tippar_estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }


 
    
    
}

?>