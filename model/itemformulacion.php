<?php

require_once 'conexion.php';

class itemformulacion {

    private $itemform_id;
    private $itemform_descripcion;
    private $itemform_pocision;
//    private $eliminado;
    private $tipsem_id;
    
    private $clasem_id;
    
    private $usr_id;
    private $itemform_estado;
    private $fecha_creacion;
    private $objPdo;

    public function __construct( //producción 2019
            $itemform_id = NULL, 
            $itemform_descripcion = '', 
            $itemform_pocision = '', 
//            $eliminado = '', 
            $tipsem_id = '', 
            $clasem_id = '',
            $usr_id = '', 
            $itemform_estado = '', 
            $fecha_creacion = ''
    ) {
        $this->itemform_id = $itemform_id;
        $this->itemform_descripcion = $itemform_descripcion;
        $this->itemform_pocision = $itemform_pocision;
//        $this->eliminado = $eliminado;
        $this->tipsem_id = $tipsem_id;
        $this->clasem_id = $clasem_id;
        
        $this->usr_id = $usr_id;
        $this->itemform_estado = $itemform_estado;
        $this->fecha_creacion = $fecha_creacion;


        $this->objPdo = new Conexion();
    }

    
    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("
SELECT item.* ,  tip.tipsem_titulo,  clasif.clasem_titulo
FROM  PROITEMFORMULACION item
inner join PROTIPOSEMITERMINADO tip on tip.tipsem_id = item.tipsem_id
inner join PROCLASIFSEMITERMINADO clasif on clasif.clasem_id = item.clasem_id
where item.eliminado = '0' 
                
                ");
        $stmt->execute();
        $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $item;
    }
    
  

    public function obtenerxId($itemform_id) { //producción 2019
        $stmt = $this->objPdo->prepare('SELECT itemform_id, itemform_descripcion, 
            itemform_pocision, 
      tipsem_id,clasem_id, usr_id, itemform_estado
 
   FROM PROITEMFORMULACION WHERE itemform_id = :itemform_id');
        $stmt->execute(array('itemform_id' => $itemform_id));
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($itemcara as $item) {
            $this->setItemform_id($item['itemform_id']);
            $this->setItemform_descripcion($item['itemform_descripcion']);
            $this->setItemform_pocision($item['itemform_pocision']);
//            $this->setEliminado($item['eliminado']);
            $this->setTipsem_id($item['tipsem_id']);
             $this->setClasem_id($item['clasem_id']);
            $this->setUsr_id($item['usr_id']);
            $this->setItemform_estado($item['itemform_estado']);

        }
        return $this;
    }

    
     public function insertar() {  //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROITEMFORMULACION 
            (itemform_descripcion, 
            itemform_pocision,
           
            tipsem_id, 
            clasem_id,
            usr_id,  
            itemform_estado) 
                                        VALUES(:itemform_descripcion,
                                               :itemform_pocision,
                                              
                                               :tipsem_id,
                                               :clasem_id,
                                               :usr_id,
                                               :itemform_estado)');
        $rows = $stmt->execute(array(
            'itemform_descripcion' => $this->itemform_descripcion,
            'itemform_pocision' => $this->itemform_pocision,
//            'eliminado' => $this->eliminado,
            'tipsem_id' => $this->tipsem_id,
            'clasem_id' => $this->clasem_id,
            'usr_id' => $this->usr_id,
            'itemform_estado' => $this->itemform_estado));
    }
    
    
    
    public function modificar() { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROITEMFORMULACION SET 
            itemform_descripcion=:itemform_descripcion, 
            itemform_pocision=:itemform_pocision, 
         
            tipsem_id=:tipsem_id,
            clasem_id=:clasem_id,
            usr_id=:usr_id, 
            itemform_estado=:itemform_estado, 
            fecha_creacion = SYSDATETIME()         
            WHERE itemform_id = :itemform_id");
        $rows = $stmt->execute(array(
            'itemform_descripcion' => $this->itemform_descripcion,
            'itemform_pocision' => $this->itemform_pocision,
//            'eliminado' => $this->eliminado,
            'tipsem_id' => $this->tipsem_id,
            'clasem_id' => $this->clasem_id,
            'usr_id' => $this->usr_id,
            'itemform_estado' => $this->itemform_estado,
            'itemform_id' => $this->itemform_id));
    }


      public function eliminar($itemform_id) { //producción 2019
        $stmt = $this->objPdo->prepare("update  PROITEMFORMULACION set eliminado = '1' WHERE itemform_id=:itemform_id");
        $rows = $stmt->execute(array('itemform_id' => $itemform_id));
        return $rows;
    }

    
    

 
    function getItemform_id() {
        return $this->itemform_id;
    }

    function getItemform_descripcion() {
        return $this->itemform_descripcion;
    }

    function getItemform_pocision() {
        return $this->itemform_pocision;
    }

    function getTipsem_id() {
        return $this->tipsem_id;
    }

    function getClasem_id() {
        return $this->clasem_id;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getItemform_estado() {
        return $this->itemform_estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setItemform_id($itemform_id) {
        $this->itemform_id = $itemform_id;
    }

    function setItemform_descripcion($itemform_descripcion) {
        $this->itemform_descripcion = $itemform_descripcion;
    }

    function setItemform_pocision($itemform_pocision) {
        $this->itemform_pocision = $itemform_pocision;
    }

    function setTipsem_id($tipsem_id) {
        $this->tipsem_id = $tipsem_id;
    }

    function setClasem_id($clasem_id) {
        $this->clasem_id = $clasem_id;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setItemform_estado($itemform_estado) {
        $this->itemform_estado = $itemform_estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }


    
 
    
  
    
    
    
}

?>