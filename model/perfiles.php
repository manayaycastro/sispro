<?php

require_once 'Conexion.php';

class NombrePerfil {

    private $per_id;
    private $per_descr;
    private $per_estado;
    private $usr_id;
    private $per_fechareg;
    private $eliminado;
    private $objPdo;

    public function __construct($per_id = NULL, $per_descr = '', $per_estado = '', $usr_id = '', $per_fechareg = '', $eliminado = '') {
        $this->per_id = $per_id;
        $this->per_descr = $per_descr;
        $this->per_estado = $per_estado;
        $this->usr_id = $usr_id;
        $this->per_fechareg = $per_fechareg;
        $this->eliminado = $eliminado;
        $this->objPdo = new Conexion();
    }

    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROMGPERFILUSUARIO where eliminado = '0'
                                         ORDER BY per_descr");
        $stmt->execute();
        $perf = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $perf;
    }
    
       public function obtenerxId($per_id) {  //producción 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROMGPERFILUSUARIO WHERE per_id = :per_id and  eliminado = '0'");
        $stmt->execute(array('per_id' => $per_id));
        $perfs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($perfs as $perf) {
                $this->setPer_id($perf['per_id']);
                $this->setPer_descr($perf['per_descr']);
                $this->setPer_estado($perf['per_estado']);
                $this->setUsr_id($perf['usr_id']);
                $this->setPer_fechareg($perf['per_fechareg']);
            }
            return $this;
    }
    
        public function modificar() {  //producción 2019
        $stmt = $this->objPdo->prepare('UPDATE PROMGPERFILUSUARIO SET per_descr=:per_descr, per_estado=:per_estado, usr_id=:usr_id, per_fechareg = SYSDATETIME()
                                        WHERE per_id = :per_id');
        $rows = $stmt->execute(array('per_descr' => $this->per_descr,
                                    'per_estado' => $this->per_estado,
                                    'usr_id' => $this->usr_id,
                                    'per_id' => $this->per_id));
    }
    
    
        public function insertar() { //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROMGPERFILUSUARIO (per_descr, per_estado, usr_id, eliminado) 
                                        VALUES(:per_descr,
                                               :per_estado,
                                               :usr_id,
                                               :eliminado)');
        $rows = $stmt->execute(array('per_descr' => $this->per_descr,
                                     'per_estado' => $this->per_estado,
                                     'usr_id' => $this->usr_id,
                                     'eliminado' => $this->eliminado));
    }
    
        public function validarperfilusuariocount($id) { //producción 2019
        $stmt = $this->objPdo->prepare("
          SELECT * 
	FROM PROMGPERFILUSUARIO pu
	inner join PROMGUSUARIOS u on u.per_id = pu.per_id
	where pu.eliminado ='0' AND PU.per_id = '$id'

                                   ");
        $stmt->execute();
        $perfiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $perfiles;
    }
    
        public function eliminar($per_id) {  //producción 2019
        $stmt = $this->objPdo->prepare("update PROMGPERFILUSUARIO set eliminado = '1'  WHERE per_id = :per_id");
        $rows = $stmt->execute(array('per_id' => $per_id));
        return $rows;
    }
    
    
    
    
    
    
    
    
    public function consultarActivos() {
        $stmt = $this->objPdo->prepare("SELECT * FROM PROMGPERFILUSUARIO 
                                        WHERE per_estado = '1' 
                                        ORDER BY per_descr;");
        $stmt->execute();
        $perf = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $perf;
    }




 

       


    
    public function getPer_id() {
        return $this->per_id;
    }

    public function setPer_id($per_id) {
        $this->per_id = $per_id;
    }

    public function getPer_descr() {
        return $this->per_descr;
    }

    public function setPer_descr($per_descr) {
        $this->per_descr = $per_descr;
    }

    public function getPer_estado() {
        return $this->per_estado;
    }

    public function setPer_estado($per_estado) {
        $this->per_estado = $per_estado;
    }

    public function getUsr_id() {
        return $this->usr_id;
    }

    public function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    public function getPer_fechareg() {
        return $this->per_fechareg;
    }

    public function setPer_fechareg($per_fechareg) {
        $this->per_fechareg = $per_fechareg;
    }
    function getEliminado() {
        return $this->eliminado;
    }

    function setEliminado($eliminado) {
        $this->eliminado = $eliminado;
    }


}

?>