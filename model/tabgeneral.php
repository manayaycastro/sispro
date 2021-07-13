<?php

require_once 'conexion.php';

class tabgeneral {

    private $tabgen_id;
    private $tabgen_nombre;
    private $usuario_creacion;
    private $estado;
    private $fecha_creacion; 
     private $tabgen_identificador; 
  
    private $objPdo;

    public function __construct($tabgen_id = NULL, $tabgen_nombre = '', $usuario_creacion = '', $estado = '', $fecha_creacion = '',$tabgen_identificador = '') { 
        $this->tabgen_id = $tabgen_id;
        $this->tabgen_nombre = $tabgen_nombre;
        $this->usuario_creacion = $usuario_creacion;
        $this->estado = $estado;
        $this->fecha_creacion = $fecha_creacion;
          $this->tabgen_identificador = $tabgen_identificador;
       
        $this->objPdo = new Conexion();
    }

    public function consultar() { 
        $stmt = $this->objPdo->prepare("
select * from PROTABLAGEN
where   eliminado = '0'

");
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $areas;
    }
    

    public function consultarActivos() {
        $stmt = $this->objPdo->prepare("SELECT * FROM PROTABLAGEN where estado = '0' and eliminado = 0 ORDER BY tabgen_id;");
        $stmt->execute();
        $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $departamentos;
    }

    
    public function obtenerxId($tabgen_id) {
        $stmt = $this->objPdo->prepare("SELECT * FROM PROTABLAGEN WHERE tabgen_id = :tabgen_id");
        $stmt->execute(array('tabgen_id' => $tabgen_id));
        $tabgen = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tabgen as $lis) {
            $this->setTabgen_id($lis ['tabgen_id']);
            $this->setTabgen_nombre($lis ['tabgen_nombre']);
            $this->setEstado($lis ['estado']);
            $this->setUsuario_creacion($lis ['usuario_creacion']);
            $this->setFecha_creacion($lis ['fecha_creacion']);
             $this->setTabgen_identificador($lis ['tabgen_identificador']);
            
        }
        return $this;
    }

    public function insertar() {
        $stmt = $this->objPdo->prepare('INSERT INTO PROTABLAGEN (tabgen_nombre, estado, usuario_creacion, tabgen_identificador) 
                                        VALUES(:tabgen_nombre,
                                               :estado,
                                               :usuario_creacion,
                                               :tabgen_identificador)');
        $rows = $stmt->execute(array(
            'tabgen_nombre' => $this->tabgen_nombre,
            'estado' => $this->estado,
            'usuario_creacion' => $this->usuario_creacion,
            'tabgen_identificador' => $this->tabgen_identificador
                
                
                ));
    }

    public function modificar() {
        $stmt = $this->objPdo->prepare('UPDATE PROTABLAGEN SET tabgen_nombre=:tabgen_nombre, estado=:estado, usuario_creacion=:usuario_creacion, fecha_creacion = SYSDATETIME(), tabgen_identificador=:tabgen_identificador
                                        WHERE tabgen_id = :tabgen_id');
        $rows = $stmt->execute(array('tabgen_nombre' => $this->tabgen_nombre,
            'estado' => $this->estado,
            'usuario_creacion' => $this->usuario_creacion,
            'tabgen_id' => $this->tabgen_id,
            'tabgen_identificador' =>  $this-> tabgen_identificador));
    }

    public function eliminar($tabgen_id) { 
        $stmt = $this->objPdo->prepare("update  PROTABLAGEN set eliminado = '1' WHERE tabgen_id=:tabgen_id");
        $rows = $stmt->execute(array('tabgen_id' => $tabgen_id));
        return $rows;
    }
    
    
       public function consultarActivosXtabGen($id) {
        $stmt = $this->objPdo->prepare("SELECT * FROM PROTABLAGENDET where estado = '0' and eliminado = 0  and tabgen_id =  '$id'  ORDER BY tabgen_id;");
        $stmt->execute();
        $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $departamentos;
    }
    
        
       public function consultarActivosXid($id) {
        $stmt = $this->objPdo->prepare("SELECT * FROM PROTABLAGEN where    tabgen_id =  '$id'  ORDER BY tabgen_id;");
        $stmt->execute();
        $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $departamentos;
    }
    
            public function insertardet($tabgen_id, $tabgendet_nombre,$usuario_nickname) { 
$stmt = $this->objPdo->prepare("
    insert into PROTABLAGENDET (tabgen_id,tabgendet_nombre,tabgendet_valor,tabgendet_unimed,usuario_creacion)
VALUES ('$tabgen_id','$tabgendet_nombre','1','1',$usuario_nickname)");
$rows = $stmt->execute(array());
return $rows;
    }

    function getTabgen_id() {
        return $this->tabgen_id;
    }

    function getTabgen_nombre() {
        return $this->tabgen_nombre;
    }

    function getUsuario_creacion() {
        return $this->usuario_creacion;
    }

    function getEstado() {
        return $this->estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setTabgen_id($tabgen_id) {
        $this->tabgen_id = $tabgen_id;
    }

    function setTabgen_nombre($tabgen_nombre) {
        $this->tabgen_nombre = $tabgen_nombre;
    }

    function setUsuario_creacion($usuario_creacion) {
        $this->usuario_creacion = $usuario_creacion;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }

    function getTabgen_identificador() {
        return $this->tabgen_identificador;
    }

    function setTabgen_identificador($tabgen_identificador) {
        $this->tabgen_identificador = $tabgen_identificador;
    }



}

?>
