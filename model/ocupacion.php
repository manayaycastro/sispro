<?php

require_once 'conexion.php';

class Ocupacion {

    private $goc_id;
    private $goc_descripcion;
    private $goc_estado;
    private $usr_id;
    private $goc_fechareg;
     private $eliminado;
    private $objPdo;

    public function __construct($goc_id = NULL, $goc_descripcion = '', $goc_estado = '', $usr_id = '', $goc_fechareg = '', $eliminado = '') {
        $this->goc_id = $goc_id;
        $this->goc_descripcion = $goc_descripcion;
        $this->goc_estado = $goc_estado;
        $this->usr_id = $usr_id;
        $this->goc_fechareg = $goc_fechareg;
        $this->eliminado = $eliminado;
        $this->objPdo = new Conexion();
    }

    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("SELECT goc_id, goc_descripcion, goc_estado, usr_id, goc_fechareg FROM PROMGGRUPOOCUP where eliminado = '0'
                                        ORDER BY goc_id;");
        $stmt->execute();
        $grupoocup = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $grupoocup;
    }
    
        public function obtenerxId($goc_id) {//producción 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROMGGRUPOOCUP WHERE goc_id = :goc_id and  eliminado = '0' " );
        $stmt->execute(array('goc_id' => $goc_id));
        $grupoocups = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($grupoocups as $grupoocup) {
            $this->setGoc_id($grupoocup['goc_id']);
            $this->setGoc_descripcion($grupoocup['goc_descripcion']);
            $this->setGoc_estado($grupoocup['goc_estado']);
            $this->setUsr_id($grupoocup['usr_id']);
            $this->setGoc_fechareg($grupoocup['goc_fechareg']);
        }
        return $this;
    }
    
       public function modificar() {//producción 2019
        $stmt = $this->objPdo->prepare('UPDATE PROMGGRUPOOCUP SET goc_descripcion=:goc_descripcion, goc_estado=:goc_estado, usr_id=:usr_id, goc_fechareg = SYSDATETIME()
                                        WHERE goc_id = :goc_id');
        $rows = $stmt->execute(array('goc_descripcion' => $this->goc_descripcion,
                                    'goc_estado' => $this->goc_estado,
                                    'usr_id' => $this->usr_id,
                                    'goc_id' => $this->goc_id));
    }
    
    
    public function insertar() { //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROMGGRUPOOCUP (goc_descripcion, goc_estado, usr_id, eliminado) 
                                        VALUES(:goc_descripcion,
                                               :goc_estado,
                                               :usr_id,
                                               :eliminado)');
        $rows = $stmt->execute(array('goc_descripcion' => $this->goc_descripcion,
                                    'goc_estado' => $this->goc_estado,
                                    'usr_id' => $this->usr_id,
                                    'eliminado' => $this->eliminado));
    }
    
         public function validarocupacioncount($id) { //producción 2019
        $stmt = $this->objPdo->prepare("
         select *
from PROMGGRUPOOCUP ocu
inner join PROMGEMPLEADOS e  on e.goc_id = ocu.goc_id
where ocu.eliminado = '0' and ocu.goc_id = '$id'


                                   ");
        $stmt->execute();
        $ocupacion = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ocupacion;
    }
    
    
    public function eliminar($goc_id) { //producción 2019
        $stmt = $this->objPdo->prepare("update  PROMGGRUPOOCUP set eliminado = '1'  WHERE goc_id = :goc_id");
        $rows = $stmt->execute(array('goc_id' => $goc_id));
        return $rows;
    }
    
    
    
    
    
    
    
    
    
    
    
    public function consultarActivos() {
        $stmt = $this->objPdo->prepare("SELECT goc_id, goc_descripcion, goc_estado, usr_id, goc_fechareg FROM grupoocup
                                        WHERE goc_estado = '1' ORDER BY goc_descripcion;");
        $stmt->execute();
        $grupoocup = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $grupoocup;
    }





    public function obtenerNombrexId($goc_id) {
        $stmt = $this->objPdo->prepare('SELECT goc_descripcion FROM grupoocup WHERE goc_id = :goc_id');
        $stmt->execute(array('goc_id' => $goc_id));
        $grupoocups = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $grupoocups[0]->goc_descripcion;
    }

    
    
 

    public function getGoc_id() {
        return $this->goc_id;
    }

    public function setGoc_id($goc_id) {
        $this->goc_id = $goc_id;
    }

    public function getGoc_descripcion() {
        return $this->goc_descripcion;
    }

    public function setGoc_descripcion($goc_descripcion) {
        $this->goc_descripcion = $goc_descripcion;
    }

    public function getGoc_estado() {
        return $this->goc_estado;
    }

    public function setGoc_estado($goc_estado) {
        $this->goc_estado = $goc_estado;
    }

    public function getUsr_id() {
        return $this->usr_id;
    }

    public function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    public function getGoc_fechareg() {
        return $this->goc_fechareg;
    }

    public function setGoc_fechareg($goc_fechareg) {
        $this->goc_fechareg = $goc_fechareg;
    }
    function getEliminado() {
        return $this->eliminado;
    }

    function setEliminado($eliminado) {
        $this->eliminado = $eliminado;
    }



}

?>