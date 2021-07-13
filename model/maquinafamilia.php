<?php

require_once 'conexion.php';

class maquinafamilia {

    private $maqfami_id;

    private $maq_id;
    
    private $tipmaq_id;
    
    private $usr_id;
    private $maqfami_estado;
    private $fecha_creacion;
    private $objPdo;

    public function __construct( //producción 2020
            $maqfami_id = NULL, $maq_id = '', $tipmaq_id = '',  $usr_id = '',  $maqfami_estado = '',  $fecha_creacion = '') {
        $this->maqfami_id = $maqfami_id;

        $this->maq_id = $maq_id;
        $this->tipmaq_id = $tipmaq_id;
        
        $this->usr_id = $usr_id;
        $this->maqfami_estado = $maqfami_estado;
        $this->fecha_creacion = $fecha_creacion;


        $this->objPdo = new Conexion();
    }

    
    public function consultar() { //producción 2020
        $stmt = $this->objPdo->prepare("
	
select maqfam.* , maq.maq_nombre, tipmaq.tipmaq_titulo
from PROMAQUINAFAMILIA maqfam
inner join PROMGMAQUINA maq on maq.maq_id = maqfam.maq_id
inner join PROTIPOMAQUINA tipmaq on tipmaq.tipmaq_id = maqfam.tipmaq_id
where maqfam.ELIMINADO = '0'
                
                ");
        $stmt->execute();
        $maqfamilia = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $maqfamilia;
    }
    
  

    public function obtenerxId($maqfami_id) { //producción 2020
        $stmt = $this->objPdo->prepare('SELECT maqfami_id, 
            maq_id,tipmaq_id, usr_id, maqfami_estado
 
   FROM PROMAQUINAFAMILIA WHERE maqfami_id =:maqfami_id');
        $stmt->execute(array('maqfami_id' => $maqfami_id));
        $artsemiter = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($artsemiter as $artsemi) {
            $this->setMaqfami_id ($artsemi['maqfami_id']);
            $this->setMaq_id($artsemi['maq_id']);
             $this->setTipmaq_id($artsemi['tipmaq_id']);
            $this->setUsr_id($artsemi['usr_id']);
            $this->setMaqfami_estado($artsemi['maqfami_estado']);

        }
        return $this;
    }

    
     public function insertar() {  //producción 2020
        $stmt = $this->objPdo->prepare('INSERT INTO PROMAQUINAFAMILIA 
            (maq_id, 
            tipmaq_id,
            usr_id,  
            maqfami_estado) 
                                        VALUES(:maq_id,
                                               :tipmaq_id,
                                               :usr_id,
                                               :maqfami_estado)');
        $rows = $stmt->execute(array(
            'maq_id' => $this->maq_id,
            'tipmaq_id' => $this->tipmaq_id,
            'usr_id' => $this->usr_id,
            'maqfami_estado' => $this->maqfami_estado));
    }
    
    
    
    public function modificar() { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROMAQUINAFAMILIA SET 
            maq_id=:maq_id,
            tipmaq_id=:tipmaq_id,
            usr_id=:usr_id, 
            maqfami_estado=:maqfami_estado, 
            fecha_creacion = SYSDATETIME()         
            WHERE maqfami_id = :maqfami_id");
        $rows = $stmt->execute(array(
            
            'maq_id' => $this->maq_id,
            'tipmaq_id' => $this->tipmaq_id,
            'usr_id' => $this->usr_id,
            'maqfami_estado' => $this->maqfami_estado,
            'maqfami_id' => $this->maqfami_id));
    }


      public function eliminar($maqfami_id) { //producción 2020
        $stmt = $this->objPdo->prepare("update  PROMAQUINAFAMILIA set eliminado = '1' WHERE maqfami_id=:maqfami_id");
        $rows = $stmt->execute(array('maqfami_id' => $maqfami_id));
        return $rows;
    }

    
      public function insertarValores($id, $itemcarac, $valoritem, $usr, $estado) { //producción 2020
        $stmt = $this->objPdo->prepare("insert into   PROVALITEMSCARACTTIPMAQUINA 
            (maqfami_id,itemcaractipmaq_id, valitemcaractipmaq_valor, usr_id, estado) 
                values ('$id','$itemcarac','$valoritem', '$usr', '$estado')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
     public function modificarValores($id, $itemcarac ,  $valor, $usr, $estado) { //producción 2019
        $stmt = $this->objPdo->prepare("update PROVALITEMSCARACTTIPMAQUINA
set valitemcaractipmaq_valor = '$valor' , usr_id = '$usr', estado = '$estado'
where maqfami_id = '$id' and itemcaractipmaq_id = '$itemcarac'");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
        public function nuevoIdRegistro() { //producción 2020
        $stmt = $this->objPdo->prepare("
        select top 1 (maqfami_id) as id
from PROMAQUINAFAMILIA
order by  maqfami_id desc
                
                ");
        $stmt->execute();
        $ultimoid = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $ultimoid;
    }

        public function Validarmaquinafamilia($id) { //producción 2020
        $stmt = $this->objPdo->prepare("
     select *
	from PROVALITEMSCARACTTIPMAQUINA
	where maqfami_id = '$id'
                
                ");
        $stmt->execute();
        $regis = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $regis;
    }
    
                public function consultarafirmacion() { //producción 2019
        $stmt = $this->objPdo->prepare("
select *
from PROAFIRMACION
where afi_estado = '0'
                
                ");
        $stmt->execute();
        $form = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $form;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        public function consultarprueba($id) { //producción 2019
        $stmt = $this->objPdo->prepare("
select artsemi.*, col.col_titulo, tip.tipsem_titulo, form.form_identificacion
from PROARTSEMITERMINADO artsemi
inner join PROCOLORES col on col.col_id = artsemi.col_id
inner join PROTIPOSEMITERMINADO tip on tip.tipsem_id= artsemi.tipsem_id
inner join PROFORMULACION form on form.form_id = artsemi.form_id
where artsemi.artsemi_estado = '0' and   artsemi.artsemi_id = '$id'

                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }
    

    
    
      public function consultarUltimoSemiID() { // produccion 2019
        $stmt = $this->objPdo->prepare("
            select top 1 *
from PROARTSEMITERMINADO
order by artsemi_id desc
 ");
        $stmt->execute();
        $semiter = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $semiter;
    }
    
                        public function AsignarMaquinaporTipoSemniterminado($idsemit ,$tipsemi_id ) { //producción 2019 , sustiruido por la funcion anterior
        $stmt = $this->objPdo->prepare("



select tabla01.*,
case when tabla02.artsemimaq_id is null then '' else  tabla02.artsemimaq_id end as  artsemimaq_id,
case when tabla02.artsemi_id is null then '' else  tabla02.artsemi_id end as  artsemi_id,
  case when tabla02.artsemimaq_numbob is null then '' else  tabla02.artsemimaq_numbob end as  artsemimaq_numbob,
   case when tabla02.artsemimaq_estado  is null then '' else  tabla02.artsemimaq_estado  end as  artsemimaq_estado


from (
			 select maq.maq_id, maq.maq_nombre, tipsemi.tipsem_id, maq.maq_estado 

			from PROMGMAQUINA maq
			inner join PROMGAREAS ar on ar.are_id = maq.are_id
			inner join PROTIPOSEMITERMINADO tipsemi on tipsemi.are_id = ar.are_id

			where tipsemi.tipsem_id = '$tipsemi_id' and maq_estado = '0'
		) tabla01
left join (
						select *
			from PROARTSEMIMAQUINA 
			where artsemi_id = '$idsemit' --and maq_id = '1'


			)tabla02
			on tabla02.maq_id = tabla01.maq_id



                
                ");
        $stmt->execute();
        $maquinasxsemiterminado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $maquinasxsemiterminado;
    }

        
      public function registrar_maq_semiterminado($estado,$numcintas,$semi_id,$maq_id,$usuario,$eliminado) { // produccion 2019
        $stmt = $this->objPdo->prepare("
 insert into PROARTSEMIMAQUINA
(artsemimaq_estado,artsemimaq_numbob,artsemi_id,maq_id,usr_id,eliminado)
values ('$estado','$numcintas','$semi_id','$maq_id','$usuario','$eliminado')
 ");
        
        $semiter = $stmt->execute();
        return $semiter;
    }
    
        public function update_maq_semiterminado($artsemimaq_id) { // produccion 2019
        $stmt = $this->objPdo->prepare("
 delete from  PROARTSEMIMAQUINA
where artsemimaq_id = '$artsemimaq_id'
 ");
        
        $semiter = $stmt->execute();
        return $semiter;
    }
    

         public function Lista_maq_semiterminado($semi_id) { // produccion 2019
        $stmt = $this->objPdo->prepare("
select semi_maq.*, maq.maq_nombre
from PROARTSEMIMAQUINA semi_maq
inner join PROMGMAQUINA maq  on maq.maq_id = semi_maq.maq_id
where semi_maq.artsemi_id = '$semi_id' and semi_maq.eliminado = '0' and semi_maq.artsemimaq_estado = '0'
 ");
        $stmt->execute();
        $semiter = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $semiter;
    }
   
    
    
    
    
    
  
    
    function getMaqfami_id() {
        return $this->maqfami_id;
    }

    function getMaq_id() {
        return $this->maq_id;
    }

    function getTipmaq_id() {
        return $this->tipmaq_id;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getMaqfami_estado() {
        return $this->maqfami_estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setMaqfami_id($maqfami_id) {
        $this->maqfami_id = $maqfami_id;
    }

    function setMaq_id($maq_id) {
        $this->maq_id = $maq_id;
    }

    function setTipmaq_id($tipmaq_id) {
        $this->tipmaq_id = $tipmaq_id;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setMaqfami_estado($maqfami_estado) {
        $this->maqfami_estado = $maqfami_estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }

  
    
}

?>