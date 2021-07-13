<?php

require_once 'conexion.php';

class artsemiterminado {

    private $artsemi_id;
    private $artsemi_descripcion;
    private $col_id;
//    private $eliminado;
    private $tipsem_id;
    
    private $form_id;
    
    private $usr_id;
    private $artsemi_estado;
    private $fecha_creacion;
    private $objPdo;

    public function __construct( //producción 2019
            $artsemi_id = NULL, 
            $artsemi_descripcion = '', 
            $col_id = '', 
//            $eliminado = '', 
            $tipsem_id = '', 
            $form_id = '',
            $usr_id = '', 
            $artsemi_estado = '', 
            $fecha_creacion = ''
    ) {
        $this->artsemi_id = $artsemi_id;
        $this->artsemi_descripcion = $artsemi_descripcion;
        $this->col_id = $col_id;
//        $this->eliminado = $eliminado;
        $this->tipsem_id = $tipsem_id;
        $this->form_id = $form_id;
        
        $this->usr_id = $usr_id;
        $this->artsemi_estado = $artsemi_estado;
        $this->fecha_creacion = $fecha_creacion;


        $this->objPdo = new Conexion();
    }

    
    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("
	select artsemi.* , tip.tipsem_titulo--, col.col_titulo, form.form_identificacion
from PROARTSEMITERMINADO artsemi
--inner join PROCOLORES col on col.col_id = artsemi.col_id
inner join PROTIPOSEMITERMINADO tip on tip.tipsem_id= artsemi.tipsem_id
--inner join PROFORMULACION form on form.form_id = artsemi.form_id
where artsemi.ELIMINADO = '0' 
                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }
    
        public function consultar2() { //producción 2019
        $stmt = $this->objPdo->prepare("
	select artsemi.* , tip.tipsem_titulo--, col.col_titulo, form.form_identificacion
from PROARTSEMITERMINADO artsemi
--inner join PROCOLORES col on col.col_id = artsemi.col_id
inner join PROTIPOSEMITERMINADO tip on tip.tipsem_id= artsemi.tipsem_id
--inner join PROFORMULACION form on form.form_id = artsemi.form_id
where artsemi.ELIMINADO = '0'  AND artsemi.tipsem_id = '1'  AND artsemi.artsemi_estado='0'
                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }
        public function consultarXsemiterminado($idsemi) { //producción 2019
        $stmt = $this->objPdo->prepare("
	select artsemi.* , tip.tipsem_titulo--, col.col_titulo, form.form_identificacion
from PROARTSEMITERMINADO artsemi
--inner join PROCOLORES col on col.col_id = artsemi.col_id
inner join PROTIPOSEMITERMINADO tip on tip.tipsem_id= artsemi.tipsem_id
--inner join PROFORMULACION form on form.form_id = artsemi.form_id
where artsemi.ELIMINADO = '0'  and artsemi.tipsem_id ='$idsemi'
                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }
    
  

    public function obtenerxId($artsemi_id) { //producción 2019
        $stmt = $this->objPdo->prepare('SELECT artsemi_id, artsemi_descripcion, 
            col_id, tipsem_id,form_id, usr_id, artsemi_estado
 
   FROM PROARTSEMITERMINADO WHERE artsemi_id = :artsemi_id');
        $stmt->execute(array('artsemi_id' => $artsemi_id));
        $artsemiter = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($artsemiter as $artsemi) {
            $this->setArtsemi_id ($artsemi['artsemi_id']);
            $this->setArtsemi_descripcion($artsemi['artsemi_descripcion']);
            $this->setCol_id($artsemi['col_id']);
//            $this->setEliminado($item['eliminado']);
            $this->setTipsem_id($artsemi['tipsem_id']);
             $this->setForm_id($artsemi['form_id']);
            $this->setUsr_id($artsemi['usr_id']);
            $this->setArtsemi_estado($artsemi['artsemi_estado']);

        }
        return $this;
    }

    
     public function insertar() {  //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROARTSEMITERMINADO 
            (artsemi_descripcion, 
            col_id,
           
            tipsem_id, 
            form_id,
            usr_id,  
            artsemi_estado) 
                                        VALUES(:artsemi_descripcion,
                                               :col_id,
                                              
                                               :tipsem_id,
                                               :form_id,
                                               :usr_id,
                                               :artsemi_estado)');
        $rows = $stmt->execute(array(
            'artsemi_descripcion' => $this->artsemi_descripcion,
            'col_id' => $this->col_id,
//            'eliminado' => $this->eliminado,
            'tipsem_id' => $this->tipsem_id,
            'form_id' => $this->form_id,
            'usr_id' => $this->usr_id,
            'artsemi_estado' => $this->artsemi_estado));
    }
    
    
    
    public function modificar() { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROARTSEMITERMINADO SET 

            col_id=:col_id, 
         
            tipsem_id=:tipsem_id,
            form_id=:form_id,
            usr_id=:usr_id, 
            artsemi_estado=:artsemi_estado, 
            fecha_creacion = SYSDATETIME()         
            WHERE artsemi_id = :artsemi_id");
        $rows = $stmt->execute(array(
    
            'col_id' => $this->col_id,
//            'eliminado' => $this->eliminado,
            'tipsem_id' => $this->tipsem_id,
            'form_id' => $this->form_id,
            'usr_id' => $this->usr_id,
            'artsemi_estado' => $this->artsemi_estado,
            'artsemi_id' => $this->artsemi_id));
    }


      public function eliminar($artsemi_id) { //producción 2019
        $stmt = $this->objPdo->prepare("update  PROARTSEMITERMINADO set eliminado = '1' WHERE artsemi_id=:artsemi_id");
        $rows = $stmt->execute(array('artsemi_id' => $artsemi_id));
        return $rows;
    }

            public function consultarcol() { //producción 2019
        $stmt = $this->objPdo->prepare("
select *
from procolores
where col_estado = '0'
                
                ");
        $stmt->execute();
        $form = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $form;
    }
    
    
                public function consultaruso() { //producción 2019
        $stmt = $this->objPdo->prepare("
select *
from PROTIPOUSO
where tipuso_estado = '0'
                
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
    
    public function nuevoIdRegistro() { //producción 2019
        $stmt = $this->objPdo->prepare("
        select top 1 (artsemi_id) as id
from PROARTSEMITERMINADO
order by  artsemi_id desc
                
                ");
        $stmt->execute();
        $ultimoid = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $ultimoid;
    }
    
  public function insertarValores($artic, $itemcarac, $valoritem, $usr, $estado) { //producción 2019
        $stmt = $this->objPdo->prepare("insert into   PROVALITEMSCARACT  (artsemi_id,itemcaracsemi_id, valitemcarac_valor, usr_id, estado) values ('$artic','$itemcarac','$valoritem', '$usr', '$estado')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
     public function modificarValores($id, $itemcarac ,  $valor, $usr, $estado) { //producción 2019
        $stmt = $this->objPdo->prepare("update PROVALITEMSCARACT
set valitemcarac_valor = '$valor' , usr_id = '$usr', estado = '$estado'
where artsemi_id = '$id' and itemcaracsemi_id = '$itemcarac'");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
        public function ValidarSemiterminado($art) { //producción 2019
        $stmt = $this->objPdo->prepare("
     select *
	from PROVALITEMSCARACT
	where artsemi_id = '$art'
                
                ");
        $stmt->execute();
        $ultimoid = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $ultimoid;
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
  case when tabla02.artsemimaq_velinicial is null then '0' else  tabla02.artsemimaq_velinicial end as  artsemimaq_velinicial,
    case when tabla02.artsemimaq_puestapunto is null then '0' else  tabla02.artsemimaq_puestapunto end as  artsemimaq_puestapunto,
   case when tabla02.artsemimaq_estado  is null then '' else  tabla02.artsemimaq_estado  end as  artsemimaq_estado
, tabla02.artsemimaq_numbob

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
			where artsemi_id = '$idsemit' and eliminado = '0'


			)tabla02
			on tabla02.maq_id = tabla01.maq_id
ORDER BY tabla01.maq_id


                
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
    
     public function registrar_maq_semiterminadoTela($estado,$numcintas,$semi_id,$maq_id,$usuario,$eliminado,$velocInicial,$puestapunto) { // produccion 2019
        $stmt = $this->objPdo->prepare("
 insert into PROARTSEMIMAQUINA
(artsemimaq_estado,artsemimaq_numbob,artsemi_id,maq_id,usr_id,eliminado, artsemimaq_velinicial ,artsemimaq_puestapunto)
values ('$estado','$numcintas','$semi_id','$maq_id','$usuario','$eliminado','$velocInicial','$puestapunto')
 ");
        
        $semiter = $stmt->execute();
        return $semiter;
    }
    
        public function update_maq_semiterminadoTela($artsemimaq_id) { // produccion 2019
        $stmt = $this->objPdo->prepare("
 update    PROARTSEMIMAQUINA set eliminado = '1'
where artsemimaq_id = '$artsemimaq_id'
 ");
        
        $semiter = $stmt->execute();
        return $semiter;
    }
    
    
          public function Lista_ProcesoXartic($art) { // produccion 2019
        $stmt = $this->objPdo->prepare("
	select tabla01.artsemi_id, tabla01.form_id, tabla01.valitemcarac_valor,tabla01.itemcaracsemi_id,
	case when tabla01.itemcaracsemi_id = '70' then 
concat('<a class=".'"blue"'."  data-semit=".'"2"'." onclick=".'"false"'."  href=".'"#"'." data-asignarmaq =".'"'."', tabla01.artsemi_id, "."'".'"'." id=".'"asignarmaqtel"'."> <i class=".'"ace-icon fa fa-film bigger-130"'."></i> </a>')
		  when tabla01.itemcaracsemi_id = '71' then 
concat('<a class=".'"blue"'." data-semit=".'"3"'." onclick=".'"false"'."  href=".'"#"'." data-asignarmaq =".'"'."', tabla01.artsemi_id, "."'".'"'." id=".'"asignarmaqlam"'."> <i class=".'"ace-icon fa fa-qrcode bigger-130"'."></i> </a>')                 
		   when tabla01.itemcaracsemi_id = '72' then 
concat('<a class=".'"blue"'." data-semit=".'"4"'." onclick=".'"false"'."  href=".'"#"'." data-asignarmaq =".'"'."', tabla01.artsemi_id, "."'".'"'." id=".'"asignarmaqimp"'."> <i class=".'"ace-icon fa fa-print bigger-130"'."></i> </a>')                  
		    when tabla01.itemcaracsemi_id = '73' then 
concat('<a class=".'"blue"'." data-semit=".'"5"'." onclick=".'"false"'."  href=".'"#"'." data-asignarmaq =".'"'."', tabla01.artsemi_id, "."'".'"'." id=".'"asignarmaqconv"'."> <i class=".'"ace-icon fa fa-th-large bigger-130"'."></i> </a>')                   
			 when tabla01.itemcaracsemi_id = '74' then 
concat('<a class=".'"blue"'." data-semit=".'"6"'." onclick=".'"false"'."  href=".'"#"'." data-asignarmaq =".'"'."', tabla01.artsemi_id, "."'".'"'." id=".'"asignarmaqbast"'."> <i class=".'"ace-icon fa fa-file bigger-130"'."></i> </a>')                         
			  when tabla01.itemcaracsemi_id = '75' then 
concat('<a class=".'"blue"'." data-semit=".'"7"'." onclick=".'"false"'."  href=".'"#"'." data-asignarmaq =".'"'."', tabla01.artsemi_id, "."'".'"'." id=".'"asignarmaqprens"'."> <i class=".'"ace-icon fa fa-gavel bigger-130"'."></i> </a>')                        
		else '0' end as etiqueta
	 from 
	(
	 select VAL.valitemcarac_id, VAL.artsemi_id, VAL.itemcaracsemi_id, VAL.valitemcarac_valor,CARACSEMI.itemcaracsemi_descripcion,clasi.clasem_id,
		 clasi.clasem_titulo , semi.form_id
		 from PROVALITEMSCARACT VAL
		 INNER JOIN PROITEMCARACTSEMITERMINADO CARACSEMI ON CARACSEMI.itemcaracsemi_id = VAL.itemcaracsemi_id
		 inner join PROCLASIFSEMITERMINADO clasi on clasi.clasem_id = CARACSEMI.clasem_id
		 inner join PROARTSEMITERMINADO semi on semi.artsemi_id= VAL.artsemi_id
		 where clasi.clasem_id = '14'  and semi.artsemi_id ='$art') tabla01
 ");
        $stmt->execute();
        $semiter = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $semiter;
    }
    
    
    
              public function Lista_ProcesoXarticParch($art) { // produccion 2019
        $stmt = $this->objPdo->prepare("
	select tabla01.artsemi_id, tabla01.form_id, tabla01.valitemcarac_valor,tabla01.itemcaracsemi_id,
	case when tabla01.itemcaracsemi_id = '106' then 
concat('<a class=".'"blue"'."  data-semit=".'"2"'." onclick=".'"false"'."  href=".'"#"'." data-asignarmaq =".'"'."', tabla01.artsemi_id, "."'".'"'." id=".'"asignarmaqtel"'."> <i class=".'"ace-icon fa fa-film bigger-130"'."></i> </a>')
		  when tabla01.itemcaracsemi_id = '107' then 
concat('<a class=".'"blue"'." data-semit=".'"3"'." onclick=".'"false"'."  href=".'"#"'." data-asignarmaq =".'"'."', tabla01.artsemi_id, "."'".'"'." id=".'"asignarmaqlam"'."> <i class=".'"ace-icon fa fa-qrcode bigger-130"'."></i> </a>')                 
		   when tabla01.itemcaracsemi_id = '108' then 
concat('<a class=".'"blue"'." data-semit=".'"4"'." onclick=".'"false"'."  href=".'"#"'." data-asignarmaq =".'"'."', tabla01.artsemi_id, "."'".'"'." id=".'"asignarmaqimp"'."> <i class=".'"ace-icon fa fa-print bigger-130"'."></i> </a>')                  
		    when tabla01.itemcaracsemi_id = '109' then 
concat('<a class=".'"blue"'." data-semit=".'"8"'." onclick=".'"false"'."  href=".'"#"'." data-asignarmaq =".'"'."', tabla01.artsemi_id, "."'".'"'." id=".'"asignarmaqconv"'."> <i class=".'"ace-icon fa fa-th-large bigger-130"'."></i> </a>')                   
			 when tabla01.itemcaracsemi_id = '74' then 
concat('<a class=".'"blue"'." data-semit=".'"6"'." onclick=".'"false"'."  href=".'"#"'." data-asignarmaq =".'"'."', tabla01.artsemi_id, "."'".'"'." id=".'"asignarmaqbast"'."> <i class=".'"ace-icon fa fa-file bigger-130"'."></i> </a>')                         
			  when tabla01.itemcaracsemi_id = '75' then 
concat('<a class=".'"blue"'." data-semit=".'"7"'." onclick=".'"false"'."  href=".'"#"'." data-asignarmaq =".'"'."', tabla01.artsemi_id, "."'".'"'." id=".'"asignarmaqprens"'."> <i class=".'"ace-icon fa fa-gavel bigger-130"'."></i> </a>')                        
		else '0' end as etiqueta
	 from 
	(
	 select VAL.valitemcarac_id, VAL.artsemi_id, VAL.itemcaracsemi_id, VAL.valitemcarac_valor,CARACSEMI.itemcaracsemi_descripcion,clasi.clasem_id,
		 clasi.clasem_titulo , semi.form_id
		 from PROVALITEMSCARACT VAL
		 INNER JOIN PROITEMCARACTSEMITERMINADO CARACSEMI ON CARACSEMI.itemcaracsemi_id = VAL.itemcaracsemi_id
		 inner join PROCLASIFSEMITERMINADO clasi on clasi.clasem_id = CARACSEMI.clasem_id
		 inner join PROARTSEMITERMINADO semi on semi.artsemi_id= VAL.artsemi_id
		 where clasi.clasem_id = '14'  and semi.artsemi_id ='$art') tabla01
 ");
        $stmt->execute();
        $semiter = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $semiter;
    }
    
    
    
            public function Lista_Art_x_lote($semi_art) { // produccion 2019
        $stmt = $this->objPdo->prepare("
	select tabla01.*, tabla2.artlot_cantinicial, tabla2.artlot_cantfinal, tabla2.artlot_cajfinal, tabla2.artlot_bobfinal 
		, cast (tabla2.fecha_creacion as date )  as fecha_ingreso , datediff (day,cast (tabla2.fecha_creacion as date ), getdate()) as dias_trans         
from
		(
		select promov_lote, SUM(promov_cant_mov) as suma
		from PROMOVIMIENTOPRODUC where --cast (promov_fecmov as date ) < '2021-06-20'  AND 
		 cast (promov_fecmov as date ) > '2020-10-03' and artsemi_id = '$semi_art' and eliminado='0'
		group by  promov_lote
		)tabla01 
		inner join (
			select * from PROARTLOTE
			where  artsemi_id ='$semi_art'  and
			  CAST(fecha_creacion as date )>'2020-10-03' and eliminado= '0'

			)tabla2 on tabla2.artlot_numerolot = tabla01.promov_lote
		where tabla01.suma !=0
 ");
        $stmt->execute();
        $semiter = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $semiter;
    }
    
                public function Produccion_x_turno($fecini, $fecfin,$estado) { // produccion 2019
                    $sql ="
		select tabla02.*, art.artsemi_descripcion 
		from (
			SELECT artsemi_id, SUM(promov_cant_mov) AS suma,fechaproduccion, turno
			FROM (
			select * 
				,CASE
                                 WHEN  cast (CONVERT(varchar, fecha_creacion,8 ) as time) >= cast ( '06:00:00' as  time)  and  cast (CONVERT(varchar, fecha_creacion,8 ) as time) <= cast ( '13:59:59' as  time)  then 'Mañana'
                                 when cast (CONVERT(varchar, fecha_creacion,8 ) as time) >= cast ( '14:00:00' as  time)  and  cast (CONVERT(varchar, fecha_creacion,8 ) as time) <= cast ( '21:59:59' as  time)  then 'Tarde'
                                  else 'Noche' end as  turno

                                  ,CASE
                                 WHEN  cast (CONVERT(varchar, fecha_creacion,8 ) as time) >= cast ( '06:00:00' as  time)  and  cast (CONVERT(varchar, fecha_creacion,8 ) as time) <= cast ( '13:59:59' as  time)  then 
                                 CAST (fecha_creacion as date) 
                                 when cast (CONVERT(varchar, fecha_creacion,8 ) as time) >= cast ( '14:00:00' as  time)  and  cast (CONVERT(varchar, fecha_creacion,8 ) as time) <= cast ( '21:59:59' as  time)  then 
                                 CAST (fecha_creacion as date) 
                                  when cast (CONVERT(varchar, fecha_creacion,8 ) as time) >= cast ( '22:00:00' as  time)  and  cast (CONVERT(varchar, fecha_creacion,8 ) as time) <= cast ( '23:59:59' as  time)  then 
                                 CAST (fecha_creacion as date) 
                                  else   CAST ( DATEADD(DAY,-1,fecha_creacion ) AS DATE )
                                  end as  fechaproduccion
				from PROMOVIMIENTOPRODUC
				WHERE eliminado='0' AND tipdoc_id = '2'
				)TABLA01
				GROUP BY artsemi_id,fechaproduccion,turno
		--ORDER BY artsemi_id
	     ) tabla02
		 inner join PROARTSEMITERMINADO art on art.artsemi_id = tabla02.artsemi_id
		 where tabla02.fechaproduccion >= '$fecini' and tabla02.fechaproduccion <= '$fecfin'
		-- order by fechaproduccion, artsemi_id
 ";
            if($estado == 'Mañana'){
                $sql .=" and turno = '$estado' order by fechaproduccion, artsemi_id ";
            } elseif($estado == 'Tarde'){
                 $sql .=" and turno = '$estado' order by fechaproduccion, artsemi_id ";
            }elseif($estado == 'Noche'){
                 $sql .=" and turno = '$estado' order by fechaproduccion, artsemi_id ";
            }elseif($estado == 'Todos'){
                 $sql .=" order by fechaproduccion, artsemi_id ";
            }       
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $semiter = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $semiter;
    }
    
    
    function getArtsemi_id() {
        return $this->artsemi_id;
    }

    function getArtsemi_descripcion() {
        return $this->artsemi_descripcion;
    }

    function getCol_id() {
        return $this->col_id;
    }

    function getTipsem_id() {
        return $this->tipsem_id;
    }

    function getForm_id() {
        return $this->form_id;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getArtsemi_estado() {
        return $this->artsemi_estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setArtsemi_id($artsemi_id) {
        $this->artsemi_id = $artsemi_id;
    }

    function setArtsemi_descripcion($artsemi_descripcion) {
        $this->artsemi_descripcion = $artsemi_descripcion;
    }

    function setCol_id($col_id) {
        $this->col_id = $col_id;
    }

    function setTipsem_id($tipsem_id) {
        $this->tipsem_id = $tipsem_id;
    }

    function setForm_id($form_id) {
        $this->form_id = $form_id;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setArtsemi_estado($artsemi_estado) {
        $this->artsemi_estado = $artsemi_estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }


    

 

    
 
    
  
    
    
    
}

?>
