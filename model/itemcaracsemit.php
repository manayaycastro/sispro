<?php

require_once 'conexion.php';

class itemcarcsemiterminado {

    private $itemcaracsemi_id;
    private $itemcaracsemi_descripcion;
    private $itemcaracsemi_pocision;
//    private $eliminado;
    private $tipsem_id;
    
    private $clasem_id;
    
    private $usr_id;
    private $itemcaracsemi_estado;
    private $fecha_creacion;
    
    private $itemcaracsemi_tipodato;
    private $itemcaracsemi_tabla;
    private $itemcaracsemi_tabla_id;
    private $itemcaracsemi_tabla_descripcion;
   
    private $objPdo;

    public function __construct( //producción 2019
            $itemcaracsemi_id = NULL, 
            $itemcaracsemi_descripcion = '', 
            $itemcaracsemi_pocision = '', 
//            $eliminado = '', 
            $tipsem_id = '', 
            $clasem_id = '',
            $usr_id = '', 
            $itemcaracsemi_estado = '', 
            
            $itemcaracsemi_tipodato = '', 
            $itemcaracsemi_tabla = '', 
            $itemcaracsemi_tabla_id = '', 
            $itemcaracsemi_tabla_descripcion = '', 

            
            
            $fecha_creacion = ''
    ) {
        $this->itemcaracsemi_id = $itemcaracsemi_id;
        $this->itemcaracsemi_descripcion = $itemcaracsemi_descripcion;
        $this->itemcaracsemi_pocision = $itemcaracsemi_pocision;
//        $this->eliminado = $eliminado;
        $this->tipsem_id = $tipsem_id;
        $this->clasem_id = $clasem_id;
        
        $this->usr_id = $usr_id;
        $this->itemcaracsemi_estado = $itemcaracsemi_estado;
        $this->fecha_creacion = $fecha_creacion;

        $this->itemcaracsemi_tipodato = $itemcaracsemi_tipodato;
        $this->itemcaracsemi_tabla = $itemcaracsemi_tabla;
        $this->itemcaracsemi_tabla_id = $itemcaracsemi_tabla_id;
        $this->itemcaracsemi_tabla_descripcion = $itemcaracsemi_tabla_descripcion;

        $this->objPdo = new Conexion();
    }

    
    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("
SELECT item.* ,  tip.tipsem_titulo,  clasif.clasem_titulo
FROM  PROITEMCARACTSEMITERMINADO item
inner join PROTIPOSEMITERMINADO tip on tip.tipsem_id = item.tipsem_id
inner join PROCLASIFSEMITERMINADO clasif on clasif.clasem_id = item.clasem_id
where item.eliminado = '0' 
                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }

    public function obtenerxId($itemcaracsemi_id) { //producción 2019
        $stmt = $this->objPdo->prepare('SELECT itemcaracsemi_id, itemcaracsemi_descripcion, 
            itemcaracsemi_pocision, 
      tipsem_id,clasem_id, usr_id, itemcaracsemi_estado, itemcaracsemi_tipodato , itemcaracsemi_tabla, itemcaracsemi_tabla_id, itemcaracsemi_tabla_descripcion
 
   FROM PROITEMCARACTSEMITERMINADO WHERE itemcaracsemi_id = :itemcaracsemi_id');
        $stmt->execute(array('itemcaracsemi_id' => $itemcaracsemi_id));
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($itemcara as $item) {
            $this->setItemcaracsemi_id ($item['itemcaracsemi_id']);
            $this->setItemcaracsemi_descripcion($item['itemcaracsemi_descripcion']);
            $this->setItemcaracsemi_pocision($item['itemcaracsemi_pocision']);
//            $this->setEliminado($item['eliminado']);
            $this->setTipsem_id($item['tipsem_id']);
             $this->setClasem_id($item['clasem_id']);
            $this->setUsr_id($item['usr_id']);
            
            $this->setItemcaracsemi_estado($item['itemcaracsemi_estado']);
            
            $this->setItemcaracsemi_tipodato($item['itemcaracsemi_tipodato']);
            $this->setItemcaracsemi_tabla($item['itemcaracsemi_tabla']);
            $this->setItemcaracsemi_tabla_id($item['itemcaracsemi_tabla_id']);
            $this->setItemcaracsemi_tabla_descripcion($item['itemcaracsemi_tabla_descripcion']);
                    
               

        }
        return $this;
    }

    
     public function insertar() {  //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROITEMCARACTSEMITERMINADO 
            (itemcaracsemi_descripcion, 
            itemcaracsemi_pocision,
           
            tipsem_id, 
            clasem_id,
            usr_id,  
            itemcaracsemi_estado,
            itemcaracsemi_tipodato,
            itemcaracsemi_tabla,
            itemcaracsemi_tabla_id,
            itemcaracsemi_tabla_descripcion
            ) 
                                        VALUES(:itemcaracsemi_descripcion,
                                               :itemcaracsemi_pocision,
                                              
                                               :tipsem_id,
                                               :clasem_id,
                                               :usr_id,
                                               :itemcaracsemi_estado,
                                               :itemcaracsemi_tipodato,
                                               :itemcaracsemi_tabla,
                                               :itemcaracsemi_tabla_id,
                                               :itemcaracsemi_tabla_descripcion)');
        $rows = $stmt->execute(array(
            'itemcaracsemi_descripcion' => $this->itemcaracsemi_descripcion,
            'itemcaracsemi_pocision' => $this->itemcaracsemi_pocision,
//            'eliminado' => $this->eliminado,
            'tipsem_id' => $this->tipsem_id,
            'clasem_id' => $this->clasem_id,
            'usr_id' => $this->usr_id,
            'itemcaracsemi_estado' => $this->itemcaracsemi_estado,
            'itemcaracsemi_tipodato' => $this->itemcaracsemi_tipodato,
            'itemcaracsemi_tabla' => $this->itemcaracsemi_tabla,
            'itemcaracsemi_tabla_id'=>  $this->itemcaracsemi_tabla_id,
            'itemcaracsemi_tabla_descripcion'=>  $this->itemcaracsemi_tabla_descripcion));
    }
    
    
    
    public function modificar() { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROITEMCARACTSEMITERMINADO SET 
            itemcaracsemi_descripcion=:itemcaracsemi_descripcion, 
            itemcaracsemi_pocision=:itemcaracsemi_pocision, 
         
            tipsem_id=:tipsem_id,
            clasem_id=:clasem_id,
            usr_id=:usr_id, 
            itemcaracsemi_estado=:itemcaracsemi_estado, 
              itemcaracsemi_tipodato=:itemcaracsemi_tipodato, 
            itemcaracsemi_tabla=:itemcaracsemi_tabla, 
            itemcaracsemi_tabla_id=:itemcaracsemi_tabla_id, 
            itemcaracsemi_tabla_descripcion=:itemcaracsemi_tabla_descripcion,
            
            fecha_creacion = SYSDATETIME()
            
          
            WHERE itemcaracsemi_id = :itemcaracsemi_id");
        $rows = $stmt->execute(array(
            'itemcaracsemi_descripcion' => $this->itemcaracsemi_descripcion,
            'itemcaracsemi_pocision' => $this->itemcaracsemi_pocision,
//            'eliminado' => $this->eliminado,
            'tipsem_id' => $this->tipsem_id,
            'clasem_id' => $this->clasem_id,
            'usr_id' => $this->usr_id,
            'itemcaracsemi_estado' => $this->itemcaracsemi_estado,
            
            'itemcaracsemi_tipodato' => $this->itemcaracsemi_tipodato,
            'itemcaracsemi_tabla' => $this->itemcaracsemi_tabla,
            'itemcaracsemi_tabla_id'=>  $this->itemcaracsemi_tabla_id,
            'itemcaracsemi_tabla_descripcion'=>  $this->itemcaracsemi_tabla_descripcion,
            
            
            'itemcaracsemi_id' => $this->itemcaracsemi_id));
    }


      public function eliminar($itemcaracsemi_id) { //producción 2019
        $stmt = $this->objPdo->prepare("update  PROITEMCARACTSEMITERMINADO set eliminado = '1' WHERE itemcaracsemi_id=:itemcaracsemi_id");
        $rows = $stmt->execute(array('itemcaracsemi_id' => $itemcaracsemi_id));
        return $rows;
    }
    
    
    
        public function consultaritemXtipo($id) { //producción 2019
        $stmt = $this->objPdo->prepare("

   SELECT item.* ,  tip.tipsem_titulo,  clasif.clasem_titulo
FROM  PROITEMCARACTSEMITERMINADO item
inner join PROTIPOSEMITERMINADO tip on tip.tipsem_id = item.tipsem_id
inner join PROCLASIFSEMITERMINADO clasif on clasif.clasem_id = item.clasem_id
where item.eliminado = '0'and tip.tipsem_id = '$id'
                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }
    
    public function consultaritemXtipoFinal($id, $art) { //producción 2019
        $stmt = $this->objPdo->prepare("

select tabla01.*, 
        case when tabla3.valitemcarac_id is null then '' else  tabla3.valitemcarac_id end  valitemcarac_id,
        --case when tabla3.itemcaracsemi_id is null then '' else tabla3.itemcaracsemi_id end  itemcaracsemi_id, 
        case when tabla3.valitemcarac_valor is null then '' else tabla3.valitemcarac_valor end  valitemcarac_valor
 from
            (
                SELECT item.* ,  tip.tipsem_titulo,  clasif.clasem_titulo
               FROM  PROITEMCARACTSEMITERMINADO item
               inner join PROTIPOSEMITERMINADO tip on tip.tipsem_id = item.tipsem_id
               inner join PROCLASIFSEMITERMINADO clasif on clasif.clasem_id = item.clasem_id
               where item.eliminado = '0'and tip.tipsem_id = '$id' and item.itemcaracsemi_estado = '0'
             ) as tabla01
left join 
            (select *from 
            (select val.valitemcarac_id,val.itemcaracsemi_id, val.valitemcarac_valor from PROARTSEMITERMINADO art 
            left join PROVALITEMSCARACT val on val.artsemi_id = art.artsemi_id
            where art.artsemi_id = '$art') tabla2  
            ) tabla3 on tabla3.itemcaracsemi_id = tabla01.itemcaracsemi_id


                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }
    
            public function consultaritemXtipoXclase($id) { //producción 2019
        $stmt = $this->objPdo->prepare("

SELECT DISTINCT classe.clasem_titulo, classe.clasem_id

FROM 
(
 SELECT item.* ,  tip.tipsem_titulo,  clasif.clasem_titulo
FROM  PROITEMCARACTSEMITERMINADO item
inner join PROTIPOSEMITERMINADO tip on tip.tipsem_id = item.tipsem_id
inner join PROCLASIFSEMITERMINADO clasif on clasif.clasem_id = item.clasem_id
where item.eliminado = '0'and tip.tipsem_id = '$id'
) AS classe
                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }
    
        public function ValidarItemCaracSemit($id) { //producción 2019
        $stmt = $this->objPdo->prepare("
            	select *
	from PROVALITEMSCARACT
	where itemcaracsemi_id = '$id'
                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }

    
    
    function getItemcaracsemi_tipodato() {
        return $this->itemcaracsemi_tipodato;
    }

    function getItemcaracsemi_tabla() {
        return $this->itemcaracsemi_tabla;
    }

    function getItemcaracsemi_tabla_id() {
        return $this->itemcaracsemi_tabla_id;
    }

    function getItemcaracsemi_tabla_descripcion() {
        return $this->itemcaracsemi_tabla_descripcion;
    }

    function setItemcaracsemi_tipodato($itemcaracsemi_tipodato) {
        $this->itemcaracsemi_tipodato = $itemcaracsemi_tipodato;
    }

    function setItemcaracsemi_tabla($itemcaracsemi_tabla) {
        $this->itemcaracsemi_tabla = $itemcaracsemi_tabla;
    }

    function setItemcaracsemi_tabla_id($itemcaracsemi_tabla_id) {
        $this->itemcaracsemi_tabla_id = $itemcaracsemi_tabla_id;
    }

    function setItemcaracsemi_tabla_descripcion($itemcaracsemi_tabla_descripcion) {
        $this->itemcaracsemi_tabla_descripcion = $itemcaracsemi_tabla_descripcion;
    }

        
    
    function getItemcaracsemi_id() {
        return $this->itemcaracsemi_id;
    }

    function getItemcaracsemi_descripcion() {
        return $this->itemcaracsemi_descripcion;
    }

    function getItemcaracsemi_pocision() {
        return $this->itemcaracsemi_pocision;
    }

    function getEliminado() {
        return $this->eliminado;
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

    function getItemcaracsemi_estado() {
        return $this->itemcaracsemi_estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setItemcaracsemi_id($itemcaracsemi_id) {
        $this->itemcaracsemi_id = $itemcaracsemi_id;
    }

    function setItemcaracsemi_descripcion($itemcaracsemi_descripcion) {
        $this->itemcaracsemi_descripcion = $itemcaracsemi_descripcion;
    }

    function setItemcaracsemi_pocision($itemcaracsemi_pocision) {
        $this->itemcaracsemi_pocision = $itemcaracsemi_pocision;
    }

    function setEliminado($eliminado) {
        $this->eliminado = $eliminado;
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

    function setItemcaracsemi_estado($itemcaracsemi_estado) {
        $this->itemcaracsemi_estado = $itemcaracsemi_estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }

 
    

 

    
 
    
  
    
    
    
}

?>