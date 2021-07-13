<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'conexion.php';
//require_once 'model/artsemiterminado.php';
class articulocaractecnicas{
    
    private $objPdo;
   
    public function __construct() {
        $this->objPdo= new Conexion();
    }

     public function listaClasificacion($tipsemi) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
       
select  tabla01.clasem_id, tabla01.clasem_titulo, COUNT(tabla01.clasem_id) as cantregistro
from 

( select clasi.* 
from PROITEMCARACTSEMITERMINADO items
inner join PROCLASIFSEMITERMINADO clasi on clasi.clasem_id = items.clasem_id
where items.tipsem_id = '$tipsemi' and items.itemcaracsemi_estado = '0'
 ) tabla01
 group by  tabla01.clasem_id, tabla01.clasem_titulo

    ");
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $lista;
    }
    
    
         public function listaItems() { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
       select *
from PROITEMCARACTSEMITERMINADO
where tipsem_id = '2' and itemcaracsemi_estado = '0'
order by clasem_id, itemcaracsemi_pocision

    ");
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $lista;
    }
    
      public function consultaritemXtipoFinal( $art,$tipsemi) { //producción 2019
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
               where item.eliminado = '0'and tip.tipsem_id = '$tipsemi' and item.itemcaracsemi_estado = '0'
             ) as tabla01
left join 
            (select *from 
            (select val.valitemcarac_id,val.itemcaracsemi_id, val.valitemcarac_valor from PROARTSEMITERMINADO art 
            left join PROVALITEMSCARACT val on val.artsemi_id = art.artsemi_id
            where art.artsemi_id = '$art') tabla2  
            ) tabla3 on tabla3.itemcaracsemi_id = tabla01.itemcaracsemi_id

order by tabla01.clasem_id, tabla01.itemcaracsemi_pocision
                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
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
    
     function listacombo($itemcaracsemi_tabla, $id) {//producción 2019
        $lista = [];
        $consultar = new articulocaractecnicas();
        if ($itemcaracsemi_tabla == 'colores') {

            $lista = $consultar->consultarcol();
        } else if ($itemcaracsemi_tabla == 'formulacionlam') {
            
            $lista = $consultar->consultarFormulacion();
        }else if ($itemcaracsemi_tabla == 'diseno') {
            
            $lista = $consultar->consultarDiseno();
         
        } else if ($itemcaracsemi_tabla == 'colimp') {
            
            $lista = $consultar->consultarColImp();
         
        } else if ($itemcaracsemi_tabla == 'cinta') {

            $lista = $consultar->consultarCinta();
            
        }else if ($itemcaracsemi_tabla == 'parche') {

            $lista = $consultar->consultarParche();
        }else if ($itemcaracsemi_tabla == 'claseb') {

            $lista = $consultar->consultarARTclaseB();
        }else if ($itemcaracsemi_tabla == 'picar') {

            $lista = $consultar->consultarARTclaseB();
        }else if ($itemcaracsemi_tabla == 'costura') {

            $lista = $consultar->consultarARTclaseB();
        }else{

            $lista = $consultar->consultarTablaGeneral($itemcaracsemi_tabla);
        }
        return $lista;
    }

    public function consultar($tipsem_id) { //producción 2019
        $stmt = $this->objPdo->prepare("
	select artsemi.* , tip.tipsem_titulo--, col.col_titulo, form.form_identificacion
from PROARTSEMITERMINADO artsemi
--inner join PROCOLORES col on col.col_id = artsemi.col_id
inner join PROTIPOSEMITERMINADO tip on tip.tipsem_id= artsemi.tipsem_id
--inner join PROFORMULACION form on form.form_id = artsemi.form_id
where artsemi.ELIMINADO = '0'  AND tip.tipsem_id= '$tipsem_id'
                
                ");
        $stmt->execute();
        $itemcara = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $itemcara;
    }
    
             public function consultarCinta() { //producción 2019
        $stmt = $this->objPdo->prepare("
 SELECT * FROM PROARTSEMITERMINADO WHERE tipsem_id = '1' and artsemi_estado = '0'
                
                ");
        $stmt->execute();
        $form = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $form;
    }
               public function consultarTablaGeneral($id) { //producción 2019
        $stmt = $this->objPdo->prepare("
select det.* from PROTABLAGENDET det
inner join PROTABLAGEN gen on gen.tabgen_id = det.tabgen_id
where gen.tabgen_identificador = '$id'          
                ");
        $stmt->execute();
        $form = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $form;
    }
    
                public function consultarFormulacion() { //producción 2019
        $stmt = $this->objPdo->prepare("
select * from PROFORMULACION
where tipsem_id = '3'      
                ");
        $stmt->execute();
        $form = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $form;
    }
                    public function consultarDiseno() { //producción 2019
        $stmt = $this->objPdo->prepare("
SELECT * FROM PRODISENOS   
                ");
        $stmt->execute();
        $form = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $form;
    }
    
                     public function consultarColImp() { //producción 2019
        $stmt = $this->objPdo->prepare("
select colimp_id, CONCAT(colimp_nombre,' ( ',colimp_linea,' ) ',' ( ',colimp_proveedor,' )') as datos from PROCOLORESIMP 
                ");
        $stmt->execute();
        $form = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $form;
    }
    
    
                 public function consultarParche() { //producción 2019
        $stmt = $this->objPdo->prepare("
select * from PROARTSEMITERMINADO  where tipsem_id = '8' and eliminado = '0'
                
                ");
        $stmt->execute();
        $form = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $form;
    }
    
    
                     public function consultarClaseB_REVISAR($artsemi) { //producción 2019
        $stmt = $this->objPdo->prepare("
select * from PROARTSEMITERMINADO  where tipsem_id = '8' and eliminado = '0'
                
                ");
        $stmt->execute();
        $form = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $form;
    }
    
    
          public function consultarARTclaseB() { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
       
SELECT DISTINCT codart, descripcion 
 FROM 
(

SELECT ART.codart, concat (ART.codalt,' ', ART.descripcion) as descripcion
 FROM ". $_SESSION['server_vinculado']."ALARTALM REL
INNER JOIN ". $_SESSION['server_vinculado']."ALART ART ON ART.codart = REL.codart
WHERE LEN(ART.codalt)>7 AND ( ART.codclase = '0090'  OR ART.codclase = '0120' )
)TABLAFIN
        

    ");
        $stmt->execute();
        $diseno = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $diseno;
    }
    
         public function listaArtCintTrama() { // 
        $stmt = $this->objPdo->prepare("
 select datos.*,
detformtrama.* ,'Trama' as tipo

from (

	select tabla01.* , TRAMA.codformulacion CODFORM, TRAMA.artsemi_descripcion DESCCINTA
	from
	(
			select tabla1.* , semi.artsemi_descripcion,semi.form_id as codsiempresoft
			from ( 
					select PivotTable.artsemi_id, convert(decimal (12,0),PivotTable.[13]) as codtramasac,
					convert(decimal (12,0),PivotTable.[14]) as codurdimbresac 
					--,convert(decimal (12,0),PivotTable.[85] )as tramaparc, 
					--convert(decimal (12,0),PivotTable.[86] )as urdimbreparc
					from (
							select  artsemi_id,itemcaracsemi_id, 
							case when valitemcarac_valor is null then 0 
							when valitemcarac_valor = '' then 0 
							when  TRY_CAST ( valitemcarac_valor as decimal(15,2))  is not null  then cast ( valitemcarac_valor as decimal(15,2))
							else 0
							 end as decimal1  from PROVALITEMSCARACT
							where  ( itemcaracsemi_id = '13' or itemcaracsemi_id= '14'
					-- or itemcaracsemi_id= '85' or itemcaracsemi_id= '86'
			 ) --and artsemi_id = '113' 
			) as tabla01 pivot(avg(decimal1) for itemcaracsemi_id in ([13],[14]
			--,[85],[86]
			) )as PivotTable
			)tabla1
			inner join PROARTSEMITERMINADO semi on semi.artsemi_id = tabla1.artsemi_id
			WHERE semi.tipsem_id ='2' and semi.eliminado= '0' and semi.artsemi_estado= '0' and semi.form_id>0
	)tabla01

	left join (
			SELECT TABLA01.*, semi.artsemi_descripcion FROM
			(
			select PivotTable.artsemi_id, convert(decimal (12,0),PivotTable.[5]) as codformulacion
			from (
			select  artsemi_id,itemcaracsemi_id, 
			case when valitemcarac_valor is null then 0 
			when valitemcarac_valor = '' then 0 
			when  TRY_CAST ( valitemcarac_valor as decimal(15,2))  is not null  then cast ( valitemcarac_valor as decimal(15,2))
			else 0
			 end as decimal1  from PROVALITEMSCARACT
			where  ( itemcaracsemi_id = '5' ) 
			) as tabla01 pivot(avg(decimal1) for itemcaracsemi_id in ([5]) )as PivotTable)TABLA01
			inner join PROARTSEMITERMINADO semi on semi.artsemi_id = TABLA01.artsemi_id
			WHERE semi.tipsem_id ='1' and semi.eliminado= '0' and semi.artsemi_estado= '0'

	)TRAMA ON TRAMA.artsemi_id =tabla01.codtramasac

	)datos

left join (
				
select 
 PivotTable.[form_id], form_identificacion,
case when  PivotTable.[Polipropileno] is null then 0 else PivotTable.[Polipropileno] end as polipropileno ,
case when  PivotTable.[Carbonato] is null then 0 else PivotTable.[Carbonato] end as carbonato,
case when PivotTable.[Masterbach] is null then 0 else  PivotTable.[Masterbach] end as masterbach,
case when PivotTable.[Reciclado] is null then 0 else PivotTable.[Reciclado] end as reciclado,
case when PivotTable.[Estabilizador UV] is null then 0 else PivotTable.[Estabilizador UV] end  as estabilizador ,
case when PivotTable.[Antifibrilante]  is null then 0 else PivotTable.[Antifibrilante] end as antifibrilante
 from (
	select 
	--tabla03.itemform_id,
	 tabla03.itemform_descripcion,
	  tabla03.form_identificacion,
	 -- tabla03.tipsem_id,
	   tabla03.valor,
	 case when tabla03.form_id is null then '0' else tabla03.form_id  end as form_id
 --,case when tabla03.estadoform is null then '0' else tabla03.estadoform  end as estadoformul,
--case when tabla03.form_identificacion is null then '0' else tabla03.form_identificacion end as nombreformulaci
 from
		(	 select items.* , 
			 case when valor.valitemform_valor is null then 0 else cast (valor.valitemform_valor as decimal (15,2)) end as valor,
			 valor.estadoform,valor.form_identificacion,valor.form_id
			 --case when valor.estadoform is null then valor.estadoform else valor.estadoform  end as estadoformul,
			 --case when valor.form_identificacion is null then valor.form_identificacion else valor.form_identificacion end as nombreformulaci
			 from (
					 select form.*, formulacion.form_identificacion, formulacion.estado estadoform
					 from PROVALITEMFORM form
					 inner join PROFORMULACION formulacion on formulacion.form_id = form.form_id
					 where form.estado= '0' and formulacion.eliminado='0'
					-- and form.form_id = '74'
					 )valor
		inner join
			 (
			

			 SELECT itemform_id, itemform_descripcion,tipsem_id
					 FROM PROITEMFORMULACION
					 where itemform_estado='0' and eliminado= '0' and tipsem_id ='1'
			 )items on items.itemform_id= valor.itemform_id 

			 )tabla03
)tabla04
pivot(
sum ([valor]) for [itemform_descripcion] in ([Polipropileno],[Carbonato],[Masterbach],[Reciclado],[Estabilizador UV],[Antifibrilante]
		) )as PivotTable
	

	
			)detformtrama on detformtrama.form_id =datos.CODFORM      


    ");
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $lista;
    }
    
    
         public function listaArtCintUrdimbre() { // 
        $stmt = $this->objPdo->prepare("
       
select datos.*

,detformurdimbre.* , 'Urdimbre' as tipo

from (

	select tabla01.* , URDIMBRE.codformulacion CODFORM ,URDIMBRE.artsemi_descripcion DESCCINTA
	from
	(
			select tabla1.* , semi.artsemi_descripcion,semi.form_id as codsiempresoft
			from ( 
					select PivotTable.artsemi_id, convert(decimal (12,0),PivotTable.[13]) as codtramasac,
					convert(decimal (12,0),PivotTable.[14]) as codurdimbresac 
					--,convert(decimal (12,0),PivotTable.[85] )as tramaparc, 
					--convert(decimal (12,0),PivotTable.[86] )as urdimbreparc
					from (
							select  artsemi_id,itemcaracsemi_id, 
							case when valitemcarac_valor is null then 0 
							when valitemcarac_valor = '' then 0 
							when  TRY_CAST ( valitemcarac_valor as decimal(15,2))  is not null  then cast ( valitemcarac_valor as decimal(15,2))
							else 0
							 end as decimal1  from PROVALITEMSCARACT
							where  ( itemcaracsemi_id = '13' or itemcaracsemi_id= '14'
					-- or itemcaracsemi_id= '85' or itemcaracsemi_id= '86'
			 ) --and artsemi_id = '113' 
			) as tabla01 pivot(avg(decimal1) for itemcaracsemi_id in ([13],[14]
			--,[85],[86]
			) )as PivotTable
			)tabla1
			inner join PROARTSEMITERMINADO semi on semi.artsemi_id = tabla1.artsemi_id
			WHERE semi.tipsem_id ='2' and semi.eliminado= '0' and semi.artsemi_estado= '0' and semi.form_id>0
	)tabla01

	left join (
			SELECT TABLA01.*, semi.artsemi_descripcion FROM
			(
			select PivotTable.artsemi_id, convert(decimal (12,0),PivotTable.[5]) as codformulacion
			from (
			select  artsemi_id,itemcaracsemi_id, 
					case when valitemcarac_valor is null then 0 
					when valitemcarac_valor = '' then 0 
					when  TRY_CAST ( valitemcarac_valor as decimal(15,2))  is not null  then cast ( valitemcarac_valor as decimal(15,2))
					else 0
					 end as decimal1  
			from PROVALITEMSCARACT
			where  ( itemcaracsemi_id = '5' ) 
			) as tabla01 pivot(avg(decimal1) for itemcaracsemi_id in ([5]) )as PivotTable)TABLA01
			inner join PROARTSEMITERMINADO semi on semi.artsemi_id = TABLA01.artsemi_id
			WHERE semi.tipsem_id ='1' and semi.eliminado= '0' and semi.artsemi_estado= '0'

	)URDIMBRE ON URDIMBRE.artsemi_id =tabla01.codurdimbresac

	)datos
	
left join (
				
select 
 PivotTable.[form_id], form_identificacion,
case when  PivotTable.[Polipropileno] is null then 0 else PivotTable.[Polipropileno] end as polipropileno ,
case when  PivotTable.[Carbonato] is null then 0 else PivotTable.[Carbonato] end as carbonato,
case when PivotTable.[Masterbach] is null then 0 else  PivotTable.[Masterbach] end as masterbach,
case when PivotTable.[Reciclado] is null then 0 else PivotTable.[Reciclado] end as reciclado,
case when PivotTable.[Estabilizador UV] is null then 0 else PivotTable.[Estabilizador UV] end  as estabilizador ,
case when PivotTable.[Antifibrilante]  is null then 0 else PivotTable.[Antifibrilante] end as antifibrilante
 from (
	select 
	--tabla03.itemform_id,
	 tabla03.itemform_descripcion,
	 tabla03.form_identificacion,
	 -- tabla03.tipsem_id,
	   tabla03.valor,
	 case when tabla03.form_id is null then '0' else tabla03.form_id  end as form_id
 --,case when tabla03.estadoform is null then '0' else tabla03.estadoform  end as estadoformul,
--case when tabla03.form_identificacion is null then '0' else tabla03.form_identificacion end as nombreformulaci
 from
		(	 select items.* , 
			 case when valor.valitemform_valor is null then 0 else cast (valor.valitemform_valor as decimal (15,2)) end as valor,
			 valor.estadoform,valor.form_identificacion,valor.form_id
			 --case when valor.estadoform is null then valor.estadoform else valor.estadoform  end as estadoformul,
			 --case when valor.form_identificacion is null then valor.form_identificacion else valor.form_identificacion end as nombreformulaci
			 from (
					 select form.*, formulacion.form_identificacion, formulacion.estado estadoform
					 from PROVALITEMFORM form
					 inner join PROFORMULACION formulacion on formulacion.form_id = form.form_id
					 where form.estado= '0' and formulacion.eliminado='0'
					-- and form.form_id = '74'
					 )valor
		inner join
			 (
			

			 SELECT itemform_id, itemform_descripcion,tipsem_id
					 FROM PROITEMFORMULACION
					 where itemform_estado='0' and eliminado= '0' and tipsem_id ='1'
			 )items on items.itemform_id= valor.itemform_id 

			 )tabla03
)tabla04
pivot(
sum ([valor]) for [itemform_descripcion] in ([Polipropileno],[Carbonato],[Masterbach],[Reciclado],[Estabilizador UV],[Antifibrilante]
		) )as PivotTable
	

	
			)detformurdimbre on detformurdimbre.form_id =datos.CODFORM





    ");
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $lista;
    }
    
       public function listaArtCintTramaUrdimbre() { // 
        $stmt = $this->objPdo->prepare("

select * from (
 select datos.*,
detformtrama.*, 'Trama' as tipo

from (

	select tabla01.* , TRAMA.codformulacion CODFORM, TRAMA.artsemi_descripcion DESCCINTA
	from
	(
			select tabla1.* , semi.artsemi_descripcion,semi.form_id as codsiempresoft
			from ( 
					select PivotTable.artsemi_id, convert(decimal (12,0),PivotTable.[13]) as codcin
					--,convert(decimal (12,0),PivotTable.[14]) as codurdimbresac 
					--,convert(decimal (12,0),PivotTable.[85] )as tramaparc, 
					--convert(decimal (12,0),PivotTable.[86] )as urdimbreparc
					from (
							select  artsemi_id,itemcaracsemi_id, 
							case when valitemcarac_valor is null then 0 
							when valitemcarac_valor = '' then 0 
							when  TRY_CAST ( valitemcarac_valor as decimal(15,2))  is not null  then cast ( valitemcarac_valor as decimal(15,2))
							else 0
							 end as decimal1  from PROVALITEMSCARACT
							where  ( itemcaracsemi_id = '13' or itemcaracsemi_id= '14'
					-- or itemcaracsemi_id= '85' or itemcaracsemi_id= '86'
			 ) --and artsemi_id = '113' 
			) as tabla01 pivot(avg(decimal1) for itemcaracsemi_id in ([13],[14]
			--,[85],[86]
			) )as PivotTable
			)tabla1
			inner join PROARTSEMITERMINADO semi on semi.artsemi_id = tabla1.artsemi_id
			WHERE semi.tipsem_id ='2' and semi.eliminado= '0' and semi.artsemi_estado= '0' and semi.form_id>0
	)tabla01

	left join (
			SELECT TABLA01.*, semi.artsemi_descripcion FROM
			(
			select PivotTable.artsemi_id, convert(decimal (12,0),PivotTable.[5]) as codformulacion
			from (
			select  artsemi_id,itemcaracsemi_id, 
			case when valitemcarac_valor is null then 0 
			when valitemcarac_valor = '' then 0 
			when  TRY_CAST ( valitemcarac_valor as decimal(15,2))  is not null  then cast ( valitemcarac_valor as decimal(15,2))
			else 0
			 end as decimal1  from PROVALITEMSCARACT
			where  ( itemcaracsemi_id = '5' ) 
			) as tabla01 pivot(avg(decimal1) for itemcaracsemi_id in ([5]) )as PivotTable)TABLA01
			inner join PROARTSEMITERMINADO semi on semi.artsemi_id = TABLA01.artsemi_id
			WHERE semi.tipsem_id ='1' and semi.eliminado= '0' and semi.artsemi_estado= '0'

	)TRAMA ON TRAMA.artsemi_id =tabla01.codcin

	)datos

left join (
				
select 
 PivotTable.[form_id], form_identificacion,
case when  PivotTable.[Polipropileno] is null then 0 else PivotTable.[Polipropileno] end as polipropileno ,
case when  PivotTable.[Carbonato] is null then 0 else PivotTable.[Carbonato] end as carbonato,
case when PivotTable.[Masterbach] is null then 0 else  PivotTable.[Masterbach] end as masterbach,
case when PivotTable.[Reciclado] is null then 0 else PivotTable.[Reciclado] end as reciclado,
case when PivotTable.[Estabilizador UV] is null then 0 else PivotTable.[Estabilizador UV] end  as estabilizador ,
case when PivotTable.[Antifibrilante]  is null then 0 else PivotTable.[Antifibrilante] end as antifibrilante
 from (
	select 
	--tabla03.itemform_id,
	 tabla03.itemform_descripcion,
	  tabla03.form_identificacion,
	 -- tabla03.tipsem_id,
	   tabla03.valor,
	 case when tabla03.form_id is null then '0' else tabla03.form_id  end as form_id
 --,case when tabla03.estadoform is null then '0' else tabla03.estadoform  end as estadoformul,
--case when tabla03.form_identificacion is null then '0' else tabla03.form_identificacion end as nombreformulaci
 from
		(	 select items.* , 
			 case when valor.valitemform_valor is null then 0 else cast (valor.valitemform_valor as decimal (15,2)) end as valor,
			 valor.estadoform,valor.form_identificacion,valor.form_id
			 --case when valor.estadoform is null then valor.estadoform else valor.estadoform  end as estadoformul,
			 --case when valor.form_identificacion is null then valor.form_identificacion else valor.form_identificacion end as nombreformulaci
			 from (
					 select form.*, formulacion.form_identificacion, formulacion.estado estadoform
					 from PROVALITEMFORM form
					 inner join PROFORMULACION formulacion on formulacion.form_id = form.form_id
					 where form.estado= '0' and formulacion.eliminado='0'
					-- and form.form_id = '74'
					 )valor
		inner join
			 (
			

			 SELECT itemform_id, itemform_descripcion,tipsem_id
					 FROM PROITEMFORMULACION
					 where itemform_estado='0' and eliminado= '0' and tipsem_id ='1'
			 )items on items.itemform_id= valor.itemform_id 

			 )tabla03
)tabla04
pivot(
sum ([valor]) for [itemform_descripcion] in ([Polipropileno],[Carbonato],[Masterbach],[Reciclado],[Estabilizador UV],[Antifibrilante]
		) )as PivotTable
	

	
			)detformtrama on detformtrama.form_id =datos.CODFORM      

union

select datos.*

,detformurdimbre.* , 'Urdimbre' as tipo

from (

	select tabla01.* , URDIMBRE.codformulacion CODFORM ,URDIMBRE.artsemi_descripcion DESCCINTA
	from
	(
			select tabla1.* , semi.artsemi_descripcion,semi.form_id as codsiempresoft
			from ( 
					select PivotTable.artsemi_id,-- convert(decimal (12,0),PivotTable.[13]) as codtramasac,
					convert(decimal (12,0),PivotTable.[14]) as codcin
					--,convert(decimal (12,0),PivotTable.[85] )as tramaparc, 
					--convert(decimal (12,0),PivotTable.[86] )as urdimbreparc
					from (
							select  artsemi_id,itemcaracsemi_id, 
							case when valitemcarac_valor is null then 0 
							when valitemcarac_valor = '' then 0 
							when  TRY_CAST ( valitemcarac_valor as decimal(15,2))  is not null  then cast ( valitemcarac_valor as decimal(15,2))
							else 0
							 end as decimal1  from PROVALITEMSCARACT
							where  ( itemcaracsemi_id = '13' or itemcaracsemi_id= '14'
					-- or itemcaracsemi_id= '85' or itemcaracsemi_id= '86'
			 ) --and artsemi_id = '113' 
			) as tabla01 pivot(avg(decimal1) for itemcaracsemi_id in ([13],[14]
			--,[85],[86]
			) )as PivotTable
			)tabla1
			inner join PROARTSEMITERMINADO semi on semi.artsemi_id = tabla1.artsemi_id
			WHERE semi.tipsem_id ='2' and semi.eliminado= '0' and semi.artsemi_estado= '0' and semi.form_id>0
	)tabla01

	left join (
			SELECT TABLA01.*, semi.artsemi_descripcion FROM
			(
			select PivotTable.artsemi_id, convert(decimal (12,0),PivotTable.[5]) as codformulacion
			from (
			select  artsemi_id,itemcaracsemi_id, 
					case when valitemcarac_valor is null then 0 
					when valitemcarac_valor = '' then 0 
					when  TRY_CAST ( valitemcarac_valor as decimal(15,2))  is not null  then cast ( valitemcarac_valor as decimal(15,2))
					else 0
					 end as decimal1  
			from PROVALITEMSCARACT
			where  ( itemcaracsemi_id = '5' ) 
			) as tabla01 pivot(avg(decimal1) for itemcaracsemi_id in ([5]) )as PivotTable)TABLA01
			inner join PROARTSEMITERMINADO semi on semi.artsemi_id = TABLA01.artsemi_id
			WHERE semi.tipsem_id ='1' and semi.eliminado= '0' and semi.artsemi_estado= '0'

	)URDIMBRE ON URDIMBRE.artsemi_id =tabla01.codcin

	)datos
	
left join (
				
select 
 PivotTable.[form_id], form_identificacion,
case when  PivotTable.[Polipropileno] is null then 0 else PivotTable.[Polipropileno] end as polipropileno ,
case when  PivotTable.[Carbonato] is null then 0 else PivotTable.[Carbonato] end as carbonato,
case when PivotTable.[Masterbach] is null then 0 else  PivotTable.[Masterbach] end as masterbach,
case when PivotTable.[Reciclado] is null then 0 else PivotTable.[Reciclado] end as reciclado,
case when PivotTable.[Estabilizador UV] is null then 0 else PivotTable.[Estabilizador UV] end  as estabilizador ,
case when PivotTable.[Antifibrilante]  is null then 0 else PivotTable.[Antifibrilante] end as antifibrilante
 from (
	select 
	--tabla03.itemform_id,
	 tabla03.itemform_descripcion,
	 tabla03.form_identificacion,
	 -- tabla03.tipsem_id,
	   tabla03.valor,
	 case when tabla03.form_id is null then '0' else tabla03.form_id  end as form_id
 --,case when tabla03.estadoform is null then '0' else tabla03.estadoform  end as estadoformul,
--case when tabla03.form_identificacion is null then '0' else tabla03.form_identificacion end as nombreformulaci
 from
		(	 select items.* , 
			 case when valor.valitemform_valor is null then 0 else cast (valor.valitemform_valor as decimal (15,2)) end as valor,
			 valor.estadoform,valor.form_identificacion,valor.form_id
			 --case when valor.estadoform is null then valor.estadoform else valor.estadoform  end as estadoformul,
			 --case when valor.form_identificacion is null then valor.form_identificacion else valor.form_identificacion end as nombreformulaci
			 from (
					 select form.*, formulacion.form_identificacion, formulacion.estado estadoform
					 from PROVALITEMFORM form
					 inner join PROFORMULACION formulacion on formulacion.form_id = form.form_id
					 where form.estado= '0' and formulacion.eliminado='0'
					-- and form.form_id = '74'
					 )valor
		inner join
			 (
			

			 SELECT itemform_id, itemform_descripcion,tipsem_id
					 FROM PROITEMFORMULACION
					 where itemform_estado='0' and eliminado= '0' and tipsem_id ='1'
			 )items on items.itemform_id= valor.itemform_id 

			 )tabla03
)tabla04
pivot(
sum ([valor]) for [itemform_descripcion] in ([Polipropileno],[Carbonato],[Masterbach],[Reciclado],[Estabilizador UV],[Antifibrilante]
		) )as PivotTable
	

	
			)detformurdimbre on detformurdimbre.form_id =datos.CODFORM
			)datos
			order by datos.artsemi_id, datos.tipo




    ");
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $lista;
    }
    
}
/* PRODUCCION PRENSA
 * 
 * SELECT * FROM ALART
WHERE LEN(codalt)>7 AND ( codclase = '0090'  OR codclase = '0120' )
 * SELECT ART.codart, concat (ART.codalt,' ', ART.descripcion) as descripcion
 FROM ALARTALM REL
INNER JOIN ALART ART ON ART.codart = REL.codart
WHERE REL.codalm = '006' AND descripcion LIKE 'CLASE%'
 * from ". $_SESSION['server_vinculado']."alart art
SELECT DATOS.*,
CASE WHEN  VALITEM.valitemcarac_valor IS NULL THEN '0'
WHEN  VALITEM.valitemcarac_valor LIKE '%[A-Z]%' THEN '0'
ELSE  VALITEM.valitemcarac_valor
END AS peso_producto

 FROM (
select totalped.* ,produccion.*
from (

select fil.* , VD.desart, CAST ( VD.cantped  AS INT ) cantped, SEMI.artsemi_id, SEMI.tipsem_id, VD.codart
from (

		SELECT prefila_op as numop, SUM(prefila_cantidad_fin) sumcantidad, SUM(prefila_peso) sumpeso
		,prefila_tipo as tipo
		 FROM PROPRENSAFILAS

		WHERE eliminado= '0' AND atendido = '1' and prefila_op = '52031' 
		GROUP BY prefila_op, prefila_tipo
		)  fil
		INNER JOIN  [192.168.10.242].[ELAGUILA].[DBO].VEPEDIDOD VD ON VD.nroped = fil.numop
		INNER JOIN PROARTSEMITERMINADO SEMI ON SEMI.form_id = VD.codart 
) totalped  
inner join (
		SELECT  prefila_op as numop_par, SUM(prefila_cantidad_fin) sumcantidad_par, SUM(prefila_peso) sumpeso_par
		,prefila_tipo as tipo_par, fechaproduccion
		FROM (
								select FIL.*  , CAST (fil.fecha_modif as date) fecha , CONVERT(varchar, fil.fecha_modif,8 ) as hora
						,CASE
						 WHEN  cast (CONVERT(varchar, fil.fecha_modif,8 ) as time) >= cast ( '06:00:00' as  time)  and  cast (CONVERT(varchar, fil.fecha_modif,8 ) as time) <= cast ( '13:59:59' as  time)  then 'Mañana'
						 when cast (CONVERT(varchar, fil.fecha_modif,8 ) as time) >= cast ( '14:00:00' as  time)  and  cast (CONVERT(varchar, fil.fecha_modif,8 ) as time) <= cast ( '21:59:59' as  time)  then 'Tarde'
						  else 'Noche' end as  turno

						  ,CASE
						 WHEN  cast (CONVERT(varchar, fil.fecha_modif,8 ) as time) >= cast ( '06:00:00' as  time)  and  cast (CONVERT(varchar, fil.fecha_modif,8 ) as time) <= cast ( '13:59:59' as  time)  then 
						 CAST (fil.fecha_modif as date) 
						 when cast (CONVERT(varchar, fil.fecha_modif,8 ) as time) >= cast ( '14:00:00' as  time)  and  cast (CONVERT(varchar, fil.fecha_modif,8 ) as time) <= cast ( '21:59:59' as  time)  then 
						 CAST (fil.fecha_modif as date) 
						  when cast (CONVERT(varchar, fil.fecha_modif,8 ) as time) >= cast ( '22:00:00' as  time)  and  cast (CONVERT(varchar, fil.fecha_modif,8 ) as time) <= cast ( '23:59:59' as  time)  then 
						 CAST (fil.fecha_modif as date) 
						  else   CAST ( DATEADD(DAY,-1,fil.fecha_modif ) AS DATE )
						  end as  fechaproduccion

						from PROPRENSAFILAS  fil


						where fil.atendido = '1' and fil.eliminado = '0' AND CAST ( fil.fecha_modif AS DATE) >= '2020-12-01' AND CAST (fil.fecha_modif AS DATE) <= '2020-12-31'
		)TABLA01
		GROUP BY prefila_op, prefila_tipo,fechaproduccion

)produccion on produccion.numop_par = totalped.numop
)DATOS
LEFT JOIN PROVALITEMSCARACT VALITEM ON (VALITEM.artsemi_id =DATOS.artsemi_id AND VALITEM.itemcaracsemi_id = '17')

 * 
 * */




?>
