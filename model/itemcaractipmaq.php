<?php

require_once 'conexion.php';

class itemcaractipmaquina {

    private $itemcaractipmaq_id;
    private $itemcaractipmaq_descripcion;
    private $itemcaractipmaq_pocision;
//    private $eliminado;
    private $tipmaq_id;
    
    private $clatipmaq_id;
    
    private $usr_id;
    private $itemcaractipmaq_estado;
    private $fecha_creacion;
    
    private $itemcaractipmaq_tipodato;
    private $itemcaractipmaq_tabla;
    private $itemcaractipmaq_tabla_id;
    private $itemcaractipmaq_tabla_descripcion;
   
    private $objPdo;

    public function __construct( //producción 2020
            $itemcaractipmaq_id = NULL, 
            $itemcaractipmaq_descripcion = '', 
            $itemcaractipmaq_pocision = '', 
//            $eliminado = '', 
            $tipmaq_id = '', 
            $clatipmaq_id = '',
            $usr_id = '', 
            $itemcaractipmaq_estado = '', 
            
            $itemcaractipmaq_tipodato = '', 
            $itemcaractipmaq_tabla = '', 
            $itemcaractipmaq_tabla_id = '', 
            $itemcaractipmaq_tabla_descripcion = '', 

            
            
            $fecha_creacion = ''
    ) {
        $this->itemcaractipmaq_id = $itemcaractipmaq_id;
        $this->itemcaractipmaq_descripcion = $itemcaractipmaq_descripcion;
        $this->itemcaractipmaq_pocision = $itemcaractipmaq_pocision;
//        $this->eliminado = $eliminado;
        $this->tipmaq_id = $tipmaq_id;
        $this->clatipmaq_id = $clatipmaq_id;
        
        $this->usr_id = $usr_id;
        $this->itemcaractipmaq_estado = $itemcaractipmaq_estado;
        $this->fecha_creacion = $fecha_creacion;

        $this->itemcaractipmaq_tipodato = $itemcaractipmaq_tipodato;
        $this->itemcaractipmaq_tabla = $itemcaractipmaq_tabla;
        $this->itemcaractipmaq_tabla_id = $itemcaractipmaq_tabla_id;
        $this->itemcaractipmaq_tabla_descripcion = $itemcaractipmaq_tabla_descripcion;

        $this->objPdo = new Conexion();
    }

    
    public function consultar() { //producción 2020
        $stmt = $this->objPdo->prepare("
SELECT item.* ,  tip.tipmaq_titulo,  clasif.clatipmaq_titulo
FROM  PROITEMCARACTTIPMAQUINA item
inner join PROTIPOMAQUINA tip on tip.tipmaq_id = item.tipmaq_id
inner join PROCLASIFTIPOMAQUINA clasif on clasif.clatipmaq_id = item.clatipmaq_id
where item.eliminado = '0' 
                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }

    public function obtenerxId($itemcaractipmaq_id) { //producción 2020
        $stmt = $this->objPdo->prepare('
            SELECT itemcaractipmaq_id, itemcaractipmaq_descripcion, 
            itemcaractipmaq_pocision, tipmaq_id, clatipmaq_id, usr_id,
            itemcaractipmaq_estado, itemcaractipmaq_tipodato , 
            itemcaractipmaq_tabla, itemcaractipmaq_tabla_id, 
            itemcaractipmaq_tabla_descripcion
 
   FROM PROITEMCARACTTIPMAQUINA WHERE itemcaractipmaq_id = :itemcaractipmaq_id');
        $stmt->execute(array('itemcaractipmaq_id' => $itemcaractipmaq_id));
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($itemcara as $item) {
            $this->setItemcaractipmaq_id ($item['itemcaractipmaq_id']);
            $this->setItemcaractipmaq_descripcion($item['itemcaractipmaq_descripcion']);
            $this->setItemcaractipmaq_pocision($item['itemcaractipmaq_pocision']);
//            $this->setEliminado($item['eliminado']);
            $this->setTipmaq_id($item['tipmaq_id']);
             $this->setClatipmaq_id($item['clatipmaq_id']);
            $this->setUsr_id($item['usr_id']);
            
            $this->setItemcaractipmaq_estado($item['itemcaractipmaq_estado']);
            
            $this->setItemcaractipmaq_tipodato($item['itemcaractipmaq_tipodato']);
            $this->setItemcaractipmaq_tabla($item['itemcaractipmaq_tabla']);
            $this->setItemcaractipmaq_tabla_id($item['itemcaractipmaq_tabla_id']);
            $this->setItemcaractipmaq_tabla_descripcion($item['itemcaractipmaq_tabla_descripcion']);
                    
               

        }
        return $this;
    }

    
     public function insertar() {  //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROITEMCARACTTIPMAQUINA 
            (itemcaractipmaq_descripcion, 
            itemcaractipmaq_pocision,
           
            tipmaq_id, 
            clatipmaq_id,
            usr_id,  
            itemcaractipmaq_estado,
            itemcaractipmaq_tipodato,
            itemcaractipmaq_tabla,
            itemcaractipmaq_tabla_id,
            itemcaractipmaq_tabla_descripcion
            ) 
                    VALUES(:itemcaractipmaq_descripcion,
                           :itemcaractipmaq_pocision,

                           :tipmaq_id,
                           :clatipmaq_id,
                           :usr_id,
                           :itemcaractipmaq_estado,
                           :itemcaractipmaq_tipodato,
                           :itemcaractipmaq_tabla,
                           :itemcaractipmaq_tabla_id,
                           :itemcaractipmaq_tabla_descripcion)');
        $rows = $stmt->execute(array(
            'itemcaractipmaq_descripcion' => $this->itemcaractipmaq_descripcion,
            'itemcaractipmaq_pocision' => $this->itemcaractipmaq_pocision,
//            'eliminado' => $this->eliminado,
            'tipmaq_id' => $this->tipmaq_id,
            'clatipmaq_id' => $this->clatipmaq_id,
            'usr_id' => $this->usr_id,
            'itemcaractipmaq_estado' => $this->itemcaractipmaq_estado,
            'itemcaractipmaq_tipodato' => $this->itemcaractipmaq_tipodato,
            'itemcaractipmaq_tabla' => $this->itemcaractipmaq_tabla,
            'itemcaractipmaq_tabla_id'=>  $this->itemcaractipmaq_tabla_id,
            'itemcaractipmaq_tabla_descripcion'=>  $this->itemcaractipmaq_tabla_descripcion));
    }
    
    
    
    public function modificar() { //producción 2020
        $stmt = $this->objPdo->prepare("UPDATE PROITEMCARACTTIPMAQUINA SET 
            itemcaractipmaq_descripcion=:itemcaractipmaq_descripcion, 
            itemcaractipmaq_pocision=:itemcaractipmaq_pocision, 
         
            tipmaq_id=:tipmaq_id,
            clatipmaq_id=:clatipmaq_id,
            usr_id=:usr_id, 
            itemcaractipmaq_tipodato=:itemcaractipmaq_tipodato, 
            itemcaractipmaq_estado=:itemcaractipmaq_estado, 
            itemcaractipmaq_tabla=:itemcaractipmaq_tabla, 
            itemcaractipmaq_tabla_id=:itemcaractipmaq_tabla_id, 
            itemcaractipmaq_tabla_descripcion=:itemcaractipmaq_tabla_descripcion,
            
            fecha_creacion = SYSDATETIME()
            
          
            WHERE itemcaractipmaq_id = :itemcaractipmaq_id");
        $rows = $stmt->execute(array(
            'itemcaractipmaq_descripcion' => $this->itemcaractipmaq_descripcion,
            'itemcaractipmaq_pocision' => $this->itemcaractipmaq_pocision,
//            'eliminado' => $this->eliminado,
            'tipmaq_id' => $this->tipmaq_id,
            'clatipmaq_id' => $this->clatipmaq_id,
            'usr_id' => $this->usr_id,
            'itemcaractipmaq_estado' => $this->itemcaractipmaq_estado,
            
            'itemcaractipmaq_tipodato' => $this->itemcaractipmaq_tipodato,
            'itemcaractipmaq_tabla' => $this->itemcaractipmaq_tabla,
            'itemcaractipmaq_tabla_id'=>  $this->itemcaractipmaq_tabla_id,
            'itemcaractipmaq_tabla_descripcion'=>  $this->itemcaractipmaq_tabla_descripcion,
            
            'itemcaractipmaq_id' => $this->itemcaractipmaq_id));
    }


      public function eliminar($itemcaractipmaq_id) { //producción 2020
        $stmt = $this->objPdo->prepare("update  PROITEMCARACTTIPMAQUINA set eliminado = '1' WHERE itemcaractipmaq_id=:itemcaractipmaq_id");
        $rows = $stmt->execute(array('itemcaractipmaq_id' => $itemcaractipmaq_id));
        return $rows;
    }
    
    
 
     public function consultaritemXtipo($id) { //producción 2020
        $stmt = $this->objPdo->prepare("

SELECT item.* ,  tip.tipmaq_titulo,  clasif.clatipmaq_titulo
FROM  PROITEMCARACTTIPMAQUINA item
inner join PROTIPOMAQUINA tip on tip.tipmaq_id = item.tipmaq_id
inner join PROCLASIFTIPOMAQUINA clasif on clasif.clatipmaq_id = item.clatipmaq_id
where item.eliminado = '0'and tip.tipmaq_id = '$id'
                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }
    
   
    
    
    public function consultaritemXtipoFinal($id, $art) { //producción 2020
        $stmt = $this->objPdo->prepare("



select tabla01.*, 
        case when tabla3.valitemcaractipmaq_id is null then '' else  tabla3.valitemcaractipmaq_id end  valitemcaractipmaq_id,
        --case when tabla3.itemcaracsemi_id is null then '' else tabla3.itemcaracsemi_id end  itemcaracsemi_id, 
        case when tabla3.valitemcaractipmaq_valor is null then '' else tabla3.valitemcaractipmaq_valor end  valitemcaractipmaq_valor
 from
            (
                SELECT item.* ,  tip.tipmaq_titulo,  clasif.clatipmaq_titulo
               FROM  PROITEMCARACTTIPMAQUINA item
               inner join PROTIPOMAQUINA tip on tip.tipmaq_id = item.tipmaq_id
               inner join PROCLASIFTIPOMAQUINA clasif on clasif.clatipmaq_id = item.clatipmaq_id
               where item.eliminado = '0'and tip.tipmaq_id = '$id' and item.itemcaractipmaq_estado = '0'
             ) as tabla01
left join 
            (select * from 
            (select val.valitemcaractipmaq_id,val.itemcaractipmaq_id, val.valitemcaractipmaq_valor 
			from PROMAQUINAFAMILIA maqfam 
            left join PROVALITEMSCARACTTIPMAQUINA val on val.maqfami_id = maqfam.maqfami_id
            where maqfam.maqfami_id = '$art') tabla2  
            ) tabla3 on tabla3.itemcaractipmaq_id = tabla01.itemcaractipmaq_id
                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }
    
    public function consultaritemXtipoXclase($id) { //producción 2020
        $stmt = $this->objPdo->prepare("

SELECT DISTINCT classe.clatipmaq_titulo, classe.clatipmaq_id

FROM 
(
 SELECT item.* ,  tip.tipmaq_titulo,  clasif.clatipmaq_titulo
 FROM  PROITEMCARACTTIPMAQUINA item
inner join PROTIPOMAQUINA tip on tip.tipmaq_id = item.tipmaq_id
 inner join PROCLASIFTIPOMAQUINA clasif on clasif.clatipmaq_id = item.clatipmaq_id
where item.eliminado = '0'and tip.tipmaq_id = '$id'
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

    
    
    function getItemcaractipmaq_id() {
        return $this->itemcaractipmaq_id;
    }

    function getItemcaractipmaq_descripcion() {
        return $this->itemcaractipmaq_descripcion;
    }

    function getItemcaractipmaq_pocision() {
        return $this->itemcaractipmaq_pocision;
    }

    function getTipmaq_id() {
        return $this->tipmaq_id;
    }

    function getClatipmaq_id() {
        return $this->clatipmaq_id;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getItemcaractipmaq_estado() {
        return $this->itemcaractipmaq_estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getItemcaractipmaq_tipodato() {
        return $this->itemcaractipmaq_tipodato;
    }

    function getItemcaractipmaq_tabla() {
        return $this->itemcaractipmaq_tabla;
    }

    function getItemcaractipmaq_tabla_id() {
        return $this->itemcaractipmaq_tabla_id;
    }

    function getItemcaractipmaq_tabla_descripcion() {
        return $this->itemcaractipmaq_tabla_descripcion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setItemcaractipmaq_id($itemcaractipmaq_id) {
        $this->itemcaractipmaq_id = $itemcaractipmaq_id;
    }

    function setItemcaractipmaq_descripcion($itemcaractipmaq_descripcion) {
        $this->itemcaractipmaq_descripcion = $itemcaractipmaq_descripcion;
    }

    function setItemcaractipmaq_pocision($itemcaractipmaq_pocision) {
        $this->itemcaractipmaq_pocision = $itemcaractipmaq_pocision;
    }

    function setTipmaq_id($tipmaq_id) {
        $this->tipmaq_id = $tipmaq_id;
    }

    function setClatipmaq_id($clatipmaq_id) {
        $this->clatipmaq_id = $clatipmaq_id;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setItemcaractipmaq_estado($itemcaractipmaq_estado) {
        $this->itemcaractipmaq_estado = $itemcaractipmaq_estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setItemcaractipmaq_tipodato($itemcaractipmaq_tipodato) {
        $this->itemcaractipmaq_tipodato = $itemcaractipmaq_tipodato;
    }

    function setItemcaractipmaq_tabla($itemcaractipmaq_tabla) {
        $this->itemcaractipmaq_tabla = $itemcaractipmaq_tabla;
    }

    function setItemcaractipmaq_tabla_id($itemcaractipmaq_tabla_id) {
        $this->itemcaractipmaq_tabla_id = $itemcaractipmaq_tabla_id;
    }

    function setItemcaractipmaq_tabla_descripcion($itemcaractipmaq_tabla_descripcion) {
        $this->itemcaractipmaq_tabla_descripcion = $itemcaractipmaq_tabla_descripcion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }


    

 

    
 
    
  
    
    
    
}

?>