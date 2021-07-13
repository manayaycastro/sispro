<?php

require_once 'conexion.php';
     
class planificacion {


    private $objPdo;

    public function __construct() { // produccion 2019
       
        $this->objPdo = new Conexion();
    }

    public function ConsultarSegPed($ini, $fin) { // produccion 2019
        $stmt = $this->objPdo->prepare("
        select tabla10.* , 
stock.cantini,
stock.cantstock,stock.nroped

,case when cast ( tabla10.cantidadb as int ) > '0'  and cast (tabla10.cantidada as int )> '0' then  round (cast( (convert (decimal (12,2),tabla10.cantidadb)/convert (decimal(12,2),tabla10.cantidada))*100 as float),2) else 0 end as porcentaje
from  (
			
			Select datosgena.* 
			,	case when CLASEB.sumcantidad  is null then '0' else CLASEB.sumcantidad  end as cantidadb ,
			case when  CLASEB.sumpeso is null  then  '0'  else CLASEB.sumpeso end as    pesob
			from (		
						SELECT datosgen.*,
						case when CLASEA.sumcantidad  is null then '0' else CLASEA.sumcantidad  end as cantidada ,
						case when  CLASEA.sumpeso is null  then  '0'  else CLASEA.sumpeso end as    pesoa
						  FROM (

																	-- anterior + detalle del pedido como vendedor , cliente etc (**)	
																	select aprobados.prodped_op,
																		case when aprobados.prodped_estado = '0' then 'A' else 'C' end as prodped_estado 
																	, aprobados.prodped_fecaprob , VD.desart, CAST ( VD.cantped  AS INT ) cantped, SEMI.artsemi_id, SEMI.tipsem_id, VD.codart
																	,cast (vc.fecped as date) as entrega,cast ( VC.fechaentrega as date ) AS vencimiento, vc.codven, concat ( ven.apellidos ,' ',ven.nombres) as vendedor
																	,Vc.razonsocial as cliente
																	from (
																			--- OPs aprobadas (*)
																					select * from PROPEDIDOAPROB
																					where prodped_tipaprob = '2' and eliminado = '0'	
											   								--- fin   OPs aprobadas (*)
																	)  aprobados
																	INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = aprobados.prodped_op
																	INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOC VC ON VC.nroped  =VD.nroped
																	INNER JOIN ". $_SESSION['server_vinculado']."VEVENDEDOR ven ON ven.codven  =VC.codven 
																	INNER JOIN PROARTSEMITERMINADO SEMI ON SEMI.form_id = VD.codart 
										
																-- finde  + detalle del pedido como vendedor , cliente etc (**)	
							)datosgen

							LEFT JOIN (
				-- Lista de clase a (***)
							SELECT prefila_op as numop, SUM(prefila_cantidad_fin) sumcantidad, SUM(prefila_peso) sumpeso
																				,prefila_tipo as tipo
																				 FROM PROPRENSAFILAS

																				WHERE eliminado= '0' AND atendido = '1' --and prefila_op = '52031' 
																				and prefila_tipo = 'Clase A'
																				GROUP BY prefila_op, prefila_tipo
	
	
				-- fin de lista de clase a (***)
							)	CLASEA ON CLASEA.numop = datosgen.prodped_op

					  )datosgena


				LEFT JOIN (
			 -- inicicio de lista clase B (****)	
				SELECT prefila_op as numop, SUM(prefila_cantidad_fin) sumcantidad, SUM(prefila_peso) sumpeso
																	,prefila_tipo as tipo
																	 FROM PROPRENSAFILAS

																	WHERE eliminado= '0' AND atendido = '1' --and prefila_op = '52031' 
																	and prefila_tipo = 'Clase B'
																	GROUP BY prefila_op, prefila_tipo
	
			-- fin de lista de clase b (****)
				)	CLASEB ON CLASEB.numop = datosgena.prodped_op		
	
				--where 	datosgena.vencimiento >= '2021-01-01' AND datosgena.vencimiento <= '2021-01-15'
				--ORDER BY datosgena.vencimiento
	)tabla10

	left join 

	(

	select SUM(tablefin.cantini)cantini,sum( tablefin.cantstock)cantstock, try_cast ( nroped as int) as nroped 
	from (
				select t12.*,try_cast(substring(t12.strlote, Charindex('-',t12.strlote)+1,len(t12.strlote)- Charindex('-',t12.strlote)+1) as int) nroped
				from (
							select * ,  right(trim(lotefab) , 5) strlote 
							from (
									select * 
									from ". $_SESSION['server_vinculado']."pplotefab 
									where eliminado = 0 and idlotefab not in
											 (select idlotefab 
											 from  ". $_SESSION['server_vinculado']."pplotefab 
											 where lotefab Like '%[A-Z]%'union all
														select idlotefab 
														from  ". $_SESSION['server_vinculado']."pplotefab 
														where lotefab Like '%[./,]%'
											  ) 
				 ) t1
		 ) t12
)tablefin
	--where tablefin.nroped = '0'		
group by  tablefin.nroped	


	)stock on stock.nroped = tabla10.prodped_op

where 	tabla10.vencimiento >= '$ini' AND tabla10.vencimiento <= '$fin'

 
");
        $stmt->execute();
        $segped = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $segped;
    }
    
    
         public function fecultimoing($op) { 
        $stmt = $this->objPdo->prepare("
SELECT TOP 1 prefila_op , CAST (fecha_modif AS DATE ) ultimafecha FROM PROPRENSAFILAS
WHERE prefila_op = '$op' AND atendido = '1'
ORDER BY fecha_modif DESC



    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
      


//PARA , LAMINADO, IMPRESION
    public function ConsultarProducProcesoXfecha($ini, $fin, $proceso) { // produccion 2019
        $stmt = $this->objPdo->prepare("

SELECT TABLA01.*
 ,DISPO.movdismaq_id, DISPO.movdismaq_proceso,DISPO.movdismaq_mtrs,DISPO.movdismaq_atendido
 ,MAQ.maq_nombre
  ,cast (CONVERT(varchar,  TABLA01.fecha_creacion,8 ) as nvarchar) as horareg
 FROM 
(
			select rolldet.*,
			 roll.progprodet_id,roll.proroll_mtrs_total, roll.proroll_peso_total, roll.proroll_atendido,
			 prog.progpro_id,prog.progpro_proceso,prog.progpro_kanban,prog.progpro_atendido,prog.progpro_siguienteproc
			 ,kandet.prokandet_nroped ,kandet.prokandet_items,kandet.prokandet_mtrs, kandet.prokandet_tipo
			 ,vd.codart, vd.desart
			 ,vc.razonsocial
			
			,
			CASE
			 WHEN  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '06:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '13:59:59' as  time)  then 
			 CAST (rolldet.fecha_creacion as date) 
			 when cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '14:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '21:59:59' as  time)  then 
			CAST (rolldet.fecha_creacion as date) 
			 when cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '22:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '23:59:59' as  time)  then 
			 CAST (rolldet.fecha_creacion as date) 
			else   CAST ( DATEADD(DAY,-1,rolldet.fecha_creacion ) AS DATE )
									  end as  fechaproduccion

			,
			CASE
			 WHEN  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '06:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '13:59:59' as  time)  then 
			'Mañana'
			 when cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '14:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '21:59:59' as  time)  then 
			'Tarde'
			 when cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '22:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '23:59:59' as  time)  then 
			'Noche'
			else  'Noche'
									  end as  Turno
			 from PROPRODUCCIONROLLODET rolldet
			 inner join PROPRODUCCIONROLLO roll on roll.proroll_id = rolldet.proroll_id
			 inner join PROPROGRAMACIONPROCDET progdet on progdet.progprodet_id = roll.progprodet_id
			 inner join PROPROGRAMACIONPROC prog on prog.progpro_id = progdet.progpro_id
			 inner join PROPROGKANBANDET kandet on kandet.prokandet_id= prog.progpro_kanban
			-- LEFT JOIN PROMOVDISPONIBILIDADMAQ  DISPO ON ( DISPO.movdismaq_idkanban =kandet.prokandet_id AND DISPO.movdismaq_tipoocupacion = 'Programacion')
			 INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = kandet.prokandet_nroped
			INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOC VC ON VC.nroped  =VD.nroped
			 where rolldet.eliminado = '0' and  roll.eliminado = '0' 
)TABLA01
LEFT JOIN PROMOVDISPONIBILIDADMAQ  DISPO ON ( DISPO.movdismaq_idkanban =TABLA01.progpro_kanban AND DISPO.movdismaq_tipoocupacion = 'Programacion' AND TABLA01.progpro_proceso = DISPO.movdismaq_proceso)
INNER JOIN PROMGMAQUINA MAQ ON MAQ.maq_id = DISPO.movdismaq_maqid
WHERE TABLA01.fechaproduccion>= '$ini' AND TABLA01.fechaproduccion<='$fin' AND DISPO.movdismaq_proceso='$proceso'
order by  MAQ.maq_id
");
        $stmt->execute();
        $produc = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $produc;
    }
 // PARA CONVERSION
    public function ConsultarProducProcesoXfecha2($ini, $fin, $proceso) { // produccion 2019
        $stmt = $this->objPdo->prepare("

SELECT TABLA01.*
 ,DISPO.movdismaq_id, DISPO.movdismaq_proceso,DISPO.movdismaq_mtrs,DISPO.movdismaq_atendido
 ,MAQ.maq_nombre
  ,cast (CONVERT(varchar,  TABLA01.fecha_creacion,8 ) as nvarchar) as horareg
 FROM 
(
			select rolldet.*,
			 roll.progprodet_id,roll.proroll_mtrs_total, roll.proroll_peso_total, roll.proroll_atendido,
			 prog.progpro_id,prog.progpro_proceso,prog.progpro_kanban,prog.progpro_atendido,prog.progpro_siguienteproc
			 ,kandet.prokandet_nroped ,kandet.prokandet_items,kandet.prokandet_mtrs, kandet.prokandet_tipo
			 ,vd.codart, vd.desart
			 ,vc.razonsocial
			
			,
			CASE
			 WHEN  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '06:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '13:59:59' as  time)  then 
			 CAST (rolldet.fecha_creacion as date) 
			 when cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '14:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '21:59:59' as  time)  then 
			CAST (rolldet.fecha_creacion as date) 
			 when cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '22:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '23:59:59' as  time)  then 
			 CAST (rolldet.fecha_creacion as date) 
			else   CAST ( DATEADD(DAY,-1,rolldet.fecha_creacion ) AS DATE )
									  end as  fechaproduccion

			,
			CASE
			 WHEN  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '06:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '13:59:59' as  time)  then 
			'Mañana'
			 when cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '14:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '21:59:59' as  time)  then 
			'Tarde'
			 when cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '22:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '23:59:59' as  time)  then 
			'Noche'
			else  'Noche'
									  end as  Turno
			 from PROPRODUCCIONSACODET rolldet
			 inner join PROPRODUCCIONROLLO roll on roll.proroll_id = rolldet.proroll_id
			 inner join PROPROGRAMACIONPROCDET progdet on progdet.progprodet_id = roll.progprodet_id
			 inner join PROPROGRAMACIONPROC prog on prog.progpro_id = progdet.progpro_id
			 inner join PROPROGKANBANDET kandet on kandet.prokandet_id= prog.progpro_kanban
			-- LEFT JOIN PROMOVDISPONIBILIDADMAQ  DISPO ON ( DISPO.movdismaq_idkanban =kandet.prokandet_id AND DISPO.movdismaq_tipoocupacion = 'Programacion')
			 INNER JOIN [192.168.10.242].[ELAGUILA].[DBO].VEPEDIDOD VD ON VD.nroped = kandet.prokandet_nroped
			INNER JOIN [192.168.10.242].[ELAGUILA].[DBO].VEPEDIDOC VC ON VC.nroped  =VD.nroped
			 where rolldet.eliminado = '0' and  roll.eliminado = '0' 
)TABLA01
LEFT JOIN PROMOVDISPONIBILIDADMAQ  DISPO ON ( DISPO.movdismaq_idkanban =TABLA01.progpro_kanban AND DISPO.movdismaq_tipoocupacion = 'Programacion' AND TABLA01.progpro_proceso = DISPO.movdismaq_proceso)
INNER JOIN PROMGMAQUINA MAQ ON MAQ.maq_id = DISPO.movdismaq_maqid
WHERE TABLA01.fechaproduccion>= '$ini' AND TABLA01.fechaproduccion<='$fin' AND DISPO.movdismaq_proceso='$proceso'
order by  MAQ.maq_id

");
        $stmt->execute();
        $produc = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $produc;
    }
    
          public function ordenPedCan($proceso,$codart) { 
        $stmt = $this->objPdo->prepare("
SELECT TABLA02.progpro_proceso, TABLA02.prokandet_nroped, TABLA02.desart ,TABLA02.codart, COUNT (*) AS cantidad
FROM ( 

		select tabla01.*, prokandet_nroped,VD.desart, vd.codart
		from (
				SELECT 
				PRO.progpro_id, PRO.progpro_proceso, PRO.progpro_kanban,PRO.progpro_atendido 
				FROM  PROPROGRAMACIONPROC PRO
				WHERE progpro_id= (SELECT  TOP 1 PRO2.progpro_id FROM PROPROGRAMACIONPROC PRO2
									WHERE PRO2.progpro_kanban=PRO.progpro_kanban AND (PRO2.progpro_atendido = '1' and PRO2.eliminado= '0' and PRO2.estado= '0')
									ORDER BY PRO2.progpro_id DESC
					
									)
				--and PRO.progpro_kanban = '34'  339 registros
				)tabla01
		inner join PROPROGKANBANDET kandet on kandet.prokandet_id =tabla01.progpro_kanban
		inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = kandet.prokandet_nroped
		inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VC ON VC.nroped = VD.nroped
		INNER JOIN  ". $_SESSION['server_vinculado']."ALART ART ON ART.codart = VD.codart
		where tabla01.progpro_atendido = '1' and (tabla01.progpro_proceso = '167' or tabla01.progpro_proceso= '168' or tabla01.progpro_proceso= '169')
		AND ART.tipoarticulo = '001'
		)TABLA02
		where TABLA02.progpro_proceso = '$proceso' and  TABLA02.codart='$codart'
GROUP BY TABLA02.progpro_proceso, TABLA02.prokandet_nroped, TABLA02.desart ,TABLA02.codart

ORDER BY TABLA02.prokandet_nroped


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   
   
    
          public function artUnicoStock($proceso) { 
        $stmt = $this->objPdo->prepare("

select  tabla20.codart,tabla20.desart,SUM(tabla20.cantidad) AS total
from(
			SELECT TABLA02.progpro_proceso, TABLA02.prokandet_nroped, TABLA02.desart ,TABLA02.codart, COUNT (*) AS cantidad
			FROM ( 

					select tabla01.*, prokandet_nroped,VD.desart, vd.codart
					from (
							SELECT 
							PRO.progpro_id, PRO.progpro_proceso, PRO.progpro_kanban,PRO.progpro_atendido 
							FROM  PROPROGRAMACIONPROC PRO
							WHERE progpro_id= (SELECT  TOP 1 PRO2.progpro_id FROM PROPROGRAMACIONPROC PRO2
												WHERE PRO2.progpro_kanban=PRO.progpro_kanban AND (PRO2.progpro_atendido = '1' and PRO2.eliminado= '0' and PRO2.estado= '0')
												ORDER BY PRO2.progpro_id DESC
					
												)
							--and PRO.progpro_kanban = '34'  339 registros
							)tabla01
					inner join PROPROGKANBANDET kandet on kandet.prokandet_id =tabla01.progpro_kanban
					inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = kandet.prokandet_nroped
					inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VC ON VC.nroped = VD.nroped
					INNER JOIN  ". $_SESSION['server_vinculado']."ALART ART ON ART.codart = VD.codart
					where tabla01.progpro_atendido = '1' and (tabla01.progpro_proceso = '167' or tabla01.progpro_proceso= '168' or tabla01.progpro_proceso= '169')
					AND ART.tipoarticulo = '001'
					)TABLA02
						where TABLA02.progpro_proceso = '$proceso'
			GROUP BY TABLA02.progpro_proceso, TABLA02.prokandet_nroped, TABLA02.desart ,TABLA02.codart
)tabla20

GROUP BY  tabla20.codart,tabla20.desart
ORDER BY tabla20.codart





    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   


      public function DetstockXkanbanXproceso($proceso,$codart,$op) { 
        $stmt = $this->objPdo->prepare("


select * 
from (
		select tabla01.* , kandet.prokandet_nroped,VD.desart, vd.codart
		from (
				SELECT 
				PRO.progpro_id, PRO.progpro_proceso, PRO.progpro_kanban,PRO.progpro_atendido 
				FROM  PROPROGRAMACIONPROC PRO
				WHERE progpro_id= (SELECT  TOP 1 PRO2.progpro_id FROM PROPROGRAMACIONPROC PRO2
									WHERE PRO2.progpro_kanban=PRO.progpro_kanban AND (PRO2.progpro_atendido = '1' and PRO2.eliminado= '0' and PRO2.estado= '0')
									ORDER BY PRO2.progpro_id DESC
					
									)
				--and PRO.progpro_kanban = '34'  136 registros
				)tabla01
		inner join PROPROGKANBANDET kandet on kandet.prokandet_id =tabla01.progpro_kanban
		inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = kandet.prokandet_nroped
		inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VC ON VC.nroped = VD.nroped
		INNER JOIN  ". $_SESSION['server_vinculado']."ALART ART ON ART.codart = VD.codart
		where tabla01.progpro_atendido = '1' and (tabla01.progpro_proceso = '167' or tabla01.progpro_proceso= '168' or tabla01.progpro_proceso= '169')
		AND ART.tipoarticulo = '001'
		
		)tabla02
		where tabla02.progpro_proceso='$proceso' and  TABLA02.codart='$codart' and TABLA02.prokandet_nroped='$op'
		ORDER BY tabla02.progpro_kanban			








    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   
   
      public function ResuStockXproceso($proc,$siguiproc) { 
        $stmt = $this->objPdo->prepare("


select * 
from (
		select tabla01.* , kandet.prokandet_nroped,VD.desart, vd.codart
		from (
				SELECT 
				PRO.progpro_id, PRO.progpro_proceso, PRO.progpro_kanban,PRO.progpro_atendido  ,PRO.progpro_siguienteproc
				FROM  PROPROGRAMACIONPROC PRO
				WHERE progpro_id= (SELECT  TOP 1 PRO2.progpro_id FROM PROPROGRAMACIONPROC PRO2
									WHERE PRO2.progpro_kanban=PRO.progpro_kanban AND (PRO2.progpro_atendido = '1' and PRO2.eliminado= '0' and PRO2.estado= '0')
									ORDER BY PRO2.progpro_id DESC
					
									)
				--and PRO.progpro_kanban = '34'  136 registros
				)tabla01
		inner join PROPROGKANBANDET kandet on kandet.prokandet_id =tabla01.progpro_kanban
		inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = kandet.prokandet_nroped
		inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VC ON VC.nroped = VD.nroped
		INNER JOIN  ". $_SESSION['server_vinculado']."ALART ART ON ART.codart = VD.codart
		where tabla01.progpro_atendido = '1' and (tabla01.progpro_proceso = '167' or tabla01.progpro_proceso= '168' or tabla01.progpro_proceso= '169')
		AND ART.tipoarticulo = '001'
		
		)tabla02
		where tabla02.progpro_proceso='$proc' and  	tabla02.progpro_siguienteproc = '$siguiproc'
		ORDER BY tabla02.progpro_kanban			


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   
public function ProcAnter_ProcActual($proc,$artsemi_id) { 
        $stmt = $this->objPdo->prepare("

select a.*,
case when b.valitemcarac_valor is null then '0' else  b.valitemcarac_valor end as proceso_anterior
from (
		select RANK() OVER (ORDER BY VAL.itemcaracsemi_id ) fila, VAL.valitemcarac_id, VAL.artsemi_id, VAL.itemcaracsemi_id, VAL.valitemcarac_valor,CARACSEMI.itemcaracsemi_descripcion,clasi.clasem_id,
		 clasi.clasem_titulo , semi.form_id
		 from PROVALITEMSCARACT VAL
		 INNER JOIN PROITEMCARACTSEMITERMINADO CARACSEMI ON CARACSEMI.itemcaracsemi_id = VAL.itemcaracsemi_id
		 inner join PROCLASIFSEMITERMINADO clasi on clasi.clasem_id = CARACSEMI.clasem_id
		 inner join PROARTSEMITERMINADO semi on semi.artsemi_id= VAL.artsemi_id
		 where clasi.clasem_id = '14'  and semi.artsemi_id ='$artsemi_id' AND VAL.valitemcarac_valor != '-1'
		 )a
left outer join 
	(
		select RANK() OVER (ORDER BY VAL.itemcaracsemi_id ) fila, VAL.valitemcarac_id, VAL.artsemi_id, VAL.itemcaracsemi_id, VAL.valitemcarac_valor,CARACSEMI.itemcaracsemi_descripcion,clasi.clasem_id,
		 clasi.clasem_titulo , semi.form_id
		 from PROVALITEMSCARACT VAL
		 INNER JOIN PROITEMCARACTSEMITERMINADO CARACSEMI ON CARACSEMI.itemcaracsemi_id = VAL.itemcaracsemi_id
		 inner join PROCLASIFSEMITERMINADO clasi on clasi.clasem_id = CARACSEMI.clasem_id
		 inner join PROARTSEMITERMINADO semi on semi.artsemi_id= VAL.artsemi_id
		 where clasi.clasem_id = '14'  and semi.artsemi_id ='$artsemi_id' AND VAL.valitemcarac_valor != '-1'

	)b on a.fila = b.fila+1
	where a.valitemcarac_valor= '$proc'

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
       public function ProcActual_Cant_Pendiente($op,$proceso) { 
        $stmt = $this->objPdo->prepare("
select  kanbanpendi.prokandet_nroped  as op_pendiente,count (kanbanpendi.progpro_kanban) as pendiente_proceso_actual
from(
	select
	 proce.progpro_proceso, proce.progpro_kanban, proce.progpro_atendido, proce.estado, proce.eliminado, proce.progpro_siguienteproc, proce.progpro_fecprogramacion  -- prog prpceso
	 , kandet.artsemi_id, kandet.prokandet_nroped, kandet.prokandet_items, kandet.prokandet_mtrs, kandet.prokandet_tipo --kanban detalle
	 ,kan.prokan_mtrs_x_rollo,kan.prokan_larg_corte, kan.prokan_mtrs_totales, kan.prokan_cantkanban, kan.prokan_cantkanbanparche

	from PROPROGRAMACIONPROC proce
	inner join PROPROGKANBANDET kandet on kandet.prokandet_id = proce.progpro_kanban and  (kandet.estado = '0' and kandet.eliminado = '0')
	inner join PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped
	where proce.estado = '0' and proce.eliminado = '0'  and  kan.prokan_nroped= '$op' and proce.progpro_proceso = '$proceso' and proce.progpro_atendido = '0'
	)kanbanpendi
	group by kanbanpendi.prokandet_nroped


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   
       public function ProcActual_Cant_Atendido($op,$proceso) { 
        $stmt = $this->objPdo->prepare("

	select  kanbanpendi.prokandet_nroped as opatendido ,count (kanbanpendi.progpro_kanban) as atendido_proceso_actual
from(
	select
	 proce.progpro_proceso, proce.progpro_kanban, proce.progpro_atendido, proce.estado, proce.eliminado, proce.progpro_siguienteproc, proce.progpro_fecprogramacion  -- prog prpceso
	 , kandet.artsemi_id, kandet.prokandet_nroped, kandet.prokandet_items, kandet.prokandet_mtrs, kandet.prokandet_tipo --kanban detalle
	 ,kan.prokan_mtrs_x_rollo,kan.prokan_larg_corte, kan.prokan_mtrs_totales, kan.prokan_cantkanban, kan.prokan_cantkanbanparche

	from PROPROGRAMACIONPROC proce
	inner join PROPROGKANBANDET kandet on kandet.prokandet_id = proce.progpro_kanban and  (kandet.estado = '0' and kandet.eliminado = '0')
	inner join PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped
	where proce.estado = '0' and proce.eliminado = '0'  and  kan.prokan_nroped= '$op' and proce.progpro_proceso = '$proceso' and proce.progpro_atendido = '1'
	)kanbanpendi
	group by kanbanpendi.prokandet_nroped


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
      public function Programacion_proceso_Actual($fec_ini , $fec_fin,$proce) { 
        $stmt = $this->objPdo->prepare("



select tabla02.* ,datos.*,  DATEDIFF(day, GETDATE(), datos.fechaentrega) as vencimiento
from 
		(	select distinct tabla.prokandet_nroped as numpedido, tabla.artsemi_id,tabla.prokandet_tipo,tabla.progpro_fecprogramacion,tabla.prokan_mtrs_x_rollo,tabla.prokan_cantkanban
			from (
				select
				 proce.progpro_proceso, proce.progpro_kanban, proce.progpro_atendido, proce.estado, proce.eliminado, proce.progpro_siguienteproc,  cast (proce.progpro_fecprogramacion as date )  progpro_fecprogramacion-- prog prpceso
				 , kandet.artsemi_id, kandet.prokandet_nroped, kandet.prokandet_items, kandet.prokandet_mtrs, kandet.prokandet_tipo --kanban detalle
				 ,kan.prokan_mtrs_x_rollo,kan.prokan_larg_corte, kan.prokan_mtrs_totales, kan.prokan_cantkanban, kan.prokan_cantkanbanparche

				from PROPROGRAMACIONPROC proce
				inner join PROPROGKANBANDET kandet on kandet.prokandet_id = proce.progpro_kanban and  (kandet.estado = '0' and kandet.eliminado = '0')
				inner join PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped
				where proce.estado = '0' and proce.eliminado = '0'   and proce.progpro_proceso = '$proce' 
				and  cast (proce.progpro_fecprogramacion as date) >= '$fec_ini' 	and  cast (proce.progpro_fecprogramacion as date) <= '$fec_fin'
				)tabla
				group by  tabla.artsemi_id,prokandet_nroped,tabla.prokandet_tipo,tabla.progpro_fecprogramacion,tabla.prokan_mtrs_x_rollo,tabla.prokan_cantkanban
		)tabla02
inner join (
			SELECT  
				APRO.prodped_op , APRO.prodidet_id, APRO.prodped_estado, -- DATOS APROBACION
			cast (VC.fecped as date )fecped , cast (VC.fechaentrega as date)fechaentrega, VC.razonsocial,  -- DATOS PED CABECERA
				VD.codart, VD.desart, VD.cantped
				FROM PROPEDIDOAPROB APRO
				INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOC VC ON VC.nroped = APRO.prodped_op
				INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = VC.nroped
				WHERE APRO.prodped_tipaprob = '2' AND APRO.eliminado= '0'

			)datos on datos.prodped_op= tabla02.numpedido
			where tabla02.prokandet_tipo= 'saco'
                         ORDER BY tabla02.progpro_fecprogramacion

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   
          public function Programacion_proceso_Actual_Maq($fec_ini , $fec_fin,$proce) { 
        $stmt = $this->objPdo->prepare("



select tabla02.* ,datos.*,  DATEDIFF(day, GETDATE(), datos.fechaentrega) as vencimiento
,MAQ.maq_nombre
from 
		(	select distinct tabla.prokandet_nroped as numpedido, tabla.movdismaq_idmaq, tabla.artsemi_id,tabla.prokandet_tipo,tabla.progpro_fecprogramacion,tabla.prokan_mtrs_x_rollo,tabla.prokan_cantkanban
			from (
				select
				 proce.progpro_proceso, proce.progpro_kanban, proce.progpro_atendido, proce.estado, proce.eliminado, proce.progpro_siguienteproc,  cast (proce.progpro_fecprogramacion as date )  progpro_fecprogramacion-- prog prpceso
				 , kandet.artsemi_id, kandet.prokandet_nroped, kandet.prokandet_items, kandet.prokandet_mtrs, kandet.prokandet_tipo --kanban detalle
				 ,kan.prokan_mtrs_x_rollo,kan.prokan_larg_corte, kan.prokan_mtrs_totales, kan.prokan_cantkanban, kan.prokan_cantkanbanparche
                                 ,DISPO.movdismaq_idmaq
				from PROPROGRAMACIONPROC proce
				inner join PROPROGKANBANDET kandet on kandet.prokandet_id = proce.progpro_kanban and  (kandet.estado = '0' and kandet.eliminado = '0')
					INNER JOIN PROMOVDISPONIBILIDADMAQ DISPO ON DISPO.movdismaq_numped = kandet.prokandet_nroped AND DISPO.movdismaq_idkanban=kandet.prokandet_id AND DISPO.movdismaq_proceso='$proce' AND DISPO.movdismaq_tipoocupacion= 'Programacion'
                                inner join PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped
				where proce.estado = '0' and proce.eliminado = '0'   and proce.progpro_proceso = '$proce' 
				and  cast (proce.progpro_fecprogramacion as date) >= '$fec_ini' 	and  cast (proce.progpro_fecprogramacion as date) <= '$fec_fin'
				)tabla
				group by   tabla.movdismaq_idmaq,tabla.artsemi_id,prokandet_nroped,tabla.prokandet_tipo,tabla.progpro_fecprogramacion,tabla.prokan_mtrs_x_rollo,tabla.prokan_cantkanban
		)tabla02
inner join (
			SELECT  
				APRO.prodped_op , APRO.prodidet_id, APRO.prodped_estado, -- DATOS APROBACION
			cast (VC.fecped as date )fecped , cast (VC.fechaentrega as date)fechaentrega, VC.razonsocial,  -- DATOS PED CABECERA
				VD.codart, VD.desart, VD.cantped
				FROM PROPEDIDOAPROB APRO
				INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOC VC ON VC.nroped = APRO.prodped_op
				INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = VC.nroped
				WHERE APRO.prodped_tipaprob = '2' AND APRO.eliminado= '0'

			)datos on datos.prodped_op= tabla02.numpedido
INNER JOIN PROMGMAQUINA MAQ ON MAQ.maq_id= tabla02.movdismaq_idmaq
			where tabla02.prokandet_tipo= 'saco'
                         ORDER BY tabla02.progpro_fecprogramacion

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   
    
    
    
        public function Proceso_op_Iniciado($proceso) { 
        $stmt = $this->objPdo->prepare("


SELECT DATOS2.*,(DATOS2.pendiente + DATOS2.atendido) as total_programado , ( mtrs_asignados.asignado_total - (DATOS2.pendiente + DATOS2.atendido)) as pendiente_programar
,CAST (VC.fechaentrega AS DATE )fechaentrega ,mtrs_asignados.asignado_total
FROM (
	select datos.* ,
case when  pendiente.cantidadkanban is null then 0 else  pendiente.cantidadkanban end  AS pendiente, 
case when  atendido.cantidadkanban is null then 0 else   atendido.cantidadkanban end  AS atendido
from (

		SELECT PROGDET.* 
		, PROG.progpro_proceso,PROG.progpro_kanban, PROG.progpro_fecprogramacion,PROG.progpro_atendido, PROG.progpro_siguienteproc
		,kandet.prokandet_nroped,kandet.prokandet_items,kandet.prokandet_mtrs, kandet.prokandet_tipo, kandet.artsemi_id
		,kan.prokan_mtrs_x_rollo,kan.prokan_larg_corte,kan.prokan_mtrs_totales, kan.prokan_cantkanban, kan.prokan_cantkanbanparche
		,dispo.movdismaq_idmaq
		,maq.maq_nombre
		FROM PROPROGRAMACIONPROCDET PROGDET
		INNER JOIN PROPROGRAMACIONPROC PROG ON PROG.progpro_id = PROGDET.progpro_id and (PROG.estado = '0' and PROG.eliminado= '0' and PROGDET.eliminado='0')
		inner join PROPROGKANBANDET kandet on kandet.prokandet_id = PROG.progpro_kanban and (kandet.estado= '0' and kandet.eliminado= '0'  and kandet.prokandet_tipo= 'saco')
		inner join PROPROGKANBAN kan  on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado= '0')
		inner join PROMOVDISPONIBILIDADMAQ dispo on dispo.movdismaq_idkanban = kandet.prokandet_id  and dispo.movdismaq_estado= '0'
		and (dispo.movdismaq_tipoocupacion = 'Programacion' and dispo.movdismaq_proceso =PROG.progpro_proceso)
		inner join PROMGMAQUINA maq on maq.maq_id= dispo.movdismaq_maqid

		WHERE PROGDET.estado = '0' AND PROGDET.eliminado= '0' and PROGDET.progprodet_hora_ini is not null and PROGDET.progprodet_hora_fin is null
		-- AND kandet.prokandet_nroped= '51304'
		and PROG.progpro_proceso='$proceso'
		
		)datos
inner join (
			
			select DISPO.movdismaq_numped, DISPO.movdismaq_idmaq,sum(DISPO.movdismaq_mtrs) sum_metros, DISPO.movdismaq_proceso, count (DISPO.movdismaq_idmaq) as cantidadkanban,
			DISPO.movdismaq_atendido, SUM(DISPO.movdismaq_atendido) as estado
			 from PROMOVDISPONIBILIDADMAQ DISPO
			 INNER JOIN PROPROGRAMACIONPROC PROG ON PROG.progpro_kanban= DISPO.movdismaq_idkanban AND  PROG.progpro_proceso=DISPO.movdismaq_proceso and  PROG.ELIMINADO='0'
			 where DISPO.movdismaq_estado ='0' and DISPO.movdismaq_tipoocupacion = 'Programacion' and DISPO.movdismaq_proceso= '$proceso' and DISPO.movdismaq_atendido= '0'
			--AND movdismaq_numped= '55291'
			 group by  DISPO.movdismaq_numped, DISPO.movdismaq_idmaq,DISPO.movdismaq_atendido,DISPO.movdismaq_proceso


			)pendiente
			on pendiente.movdismaq_numped= datos.prokandet_nroped and pendiente.movdismaq_idmaq=datos.movdismaq_idmaq
left join (
				select DISPO.movdismaq_numped, DISPO.movdismaq_idmaq,sum(DISPO.movdismaq_mtrs) sum_metros, DISPO.movdismaq_proceso, count (DISPO.movdismaq_idmaq) as cantidadkanban,
			DISPO.movdismaq_atendido, SUM(DISPO.movdismaq_atendido) as estado
			 from PROMOVDISPONIBILIDADMAQ DISPO
			 INNER JOIN PROPROGRAMACIONPROC PROG ON PROG.progpro_kanban= DISPO.movdismaq_idkanban AND  PROG.progpro_proceso=DISPO.movdismaq_proceso  and  PROG.ELIMINADO='0'
			 where DISPO.movdismaq_estado ='0' and DISPO.movdismaq_tipoocupacion = 'Programacion' and DISPO.movdismaq_proceso= '$proceso' and DISPO.movdismaq_atendido= '1'
			--AND movdismaq_numped= '55291'
			 group by  DISPO.movdismaq_numped, DISPO.movdismaq_idmaq,DISPO.movdismaq_atendido,DISPO.movdismaq_proceso


			)atendido
			on atendido.movdismaq_numped= datos.prokandet_nroped and atendido.movdismaq_idmaq=datos.movdismaq_idmaq


	)DATOS2
        	inner join (
			select  sum(movdismaq_mtrs) movdismaq_mtrs ,COUNT (movdismaq_idmaq) AS asignado_total, movdismaq_numped, movdismaq_idmaq
			from PROMOVDISPONIBILIDADMAQ
			where  movdismaq_proceso= '$proceso' and movdismaq_tipoocupacion='Programacion' and movdismaq_estado= '0'
			group by movdismaq_numped,movdismaq_idmaq
			)mtrs_asignados on
			mtrs_asignados.movdismaq_numped=DATOS2.prokandet_nroped and mtrs_asignados.movdismaq_idmaq= DATOS2.movdismaq_idmaq
	INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOC VC ON VC.nroped= DATOS2.prokandet_nroped
	order by datos2.movdismaq_idmaq



    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   
            public function prog_cambiotej($proceso) { 
        $stmt = $this->objPdo->prepare("

SELECT op_siguiente.*
,maq.maq_nombre 
,vd.codart,vd.desart, cast (vc.fechaentrega as date )fechaentrega
,mtrs_asignados.movdismaq_mtrs
,semi.artsemi_id
FROM (
            select *
            from (
			select  pendiente.*,atendido.atendido
			 from (

					SELECT  distinct movdismaq_numped,movdismaq_atendido as pendiente, movdismaq_maqid
					FROM  PROMOVDISPONIBILIDADMAQ
					WHERE  movdismaq_atendido= '0' and movdismaq_proceso= '$proceso'  and movdismaq_estado= '0' -- and movdismaq_idmaq= '25' 
					GROUP BY movdismaq_numped, movdismaq_atendido,movdismaq_maqid
					)pendiente

			left  join (
		

					SELECT  distinct movdismaq_numped,movdismaq_atendido as atendido,movdismaq_maqid
					FROM  PROMOVDISPONIBILIDADMAQ
					WHERE movdismaq_atendido= '1' and movdismaq_proceso= '$proceso'  and movdismaq_estado= '0' --and movdismaq_idmaq= '25' 
					GROUP BY movdismaq_numped, movdismaq_atendido,movdismaq_maqid
					)atendido
					on atendido.movdismaq_numped = pendiente.movdismaq_numped  and pendiente.movdismaq_maqid= atendido.movdismaq_maqid
                                        
                    )tab                                   
			where tab.pendiente='0' and (tab.atendido is null OR  tab.atendido= '1') and
                        
                                         CONCAT(tab.movdismaq_numped,'-',tab.movdismaq_maqid) NOT IN (
																					
                                                    SELECT CONCAT( movdismaq_numped ,'-',maq_id) AS OP_MAQ_ACTUAL
                                                    /* PROGDET.* 
                                            , PROG.progpro_proceso,PROG.progpro_kanban, PROG.progpro_fecprogramacion,PROG.progpro_atendido, PROG.progpro_siguienteproc
                                            ,kandet.prokandet_nroped,kandet.prokandet_items,kandet.prokandet_mtrs, kandet.prokandet_tipo, kandet.artsemi_id
                                            ,kan.prokan_mtrs_x_rollo,kan.prokan_larg_corte,kan.prokan_mtrs_totales, kan.prokan_cantkanban, kan.prokan_cantkanbanparche
                                            ,dispo.movdismaq_idmaq
                                            ,maq.maq_nombre */
                                            FROM PROPROGRAMACIONPROCDET PROGDET
                                            INNER JOIN PROPROGRAMACIONPROC PROG ON PROG.progpro_id = PROGDET.progpro_id and (PROG.estado = '0' and PROG.eliminado= '0'and PROGDET.eliminado='0')
                                            inner join PROPROGKANBANDET kandet on kandet.prokandet_id = PROG.progpro_kanban and (kandet.estado= '0' and kandet.eliminado= '0' and kandet.prokandet_tipo= 'saco')
                                            inner join PROPROGKANBAN kan  on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado= '0')
                                            inner join PROMOVDISPONIBILIDADMAQ dispo on dispo.movdismaq_idkanban = kandet.prokandet_id   and (dispo.movdismaq_estado= '0')
                                            and (dispo.movdismaq_tipoocupacion = 'Programacion' and dispo.movdismaq_proceso =PROG.progpro_proceso)
                                            inner join PROMGMAQUINA maq on maq.maq_id= dispo.movdismaq_maqid

                                            WHERE PROGDET.estado = '0' AND PROGDET.eliminado= '0' and PROGDET.progprodet_hora_ini is not null and PROGDET.progprodet_hora_fin is null
                                            -- AND kandet.prokandet_nroped= '51304'
                                            and PROG.progpro_proceso='167'

			
																						)


)op_siguiente
inner join PROMGMAQUINA maq on maq.maq_id = op_siguiente.movdismaq_maqid
inner join ". $_SESSION['server_vinculado']."vepedidod vd on vd.nroped= op_siguiente.movdismaq_numped
inner join ". $_SESSION['server_vinculado']."vepedidoc vc on vc.nroped= op_siguiente.movdismaq_numped
inner join (
			select  sum(movdismaq_mtrs) movdismaq_mtrs , movdismaq_numped, movdismaq_idmaq
			from PROMOVDISPONIBILIDADMAQ
			where  movdismaq_proceso= '$proceso' and movdismaq_tipoocupacion='Programacion'  and movdismaq_estado= '0'
			group by movdismaq_numped,movdismaq_idmaq
			)mtrs_asignados on
			mtrs_asignados.movdismaq_numped=op_siguiente.movdismaq_numped and mtrs_asignados.movdismaq_idmaq= op_siguiente.movdismaq_maqid
inner join (
			 select distinct prokandet_nroped,prokandet_tipo,artsemi_id
			  from PROPROGKANBANDET
			  where prokandet_tipo = 'saco'

			)semi
			on semi.prokandet_nroped = op_siguiente.movdismaq_numped

order by op_siguiente.movdismaq_maqid, op_siguiente.movdismaq_numped



    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   
    
                public function prog_cambiotejV01($proceso) { 
        $stmt = $this->objPdo->prepare("

SELECT op_siguiente.*
,maq.maq_nombre 
,vd.codart,vd.desart, cast (vc.fechaentrega as date )fechaentrega
,mtrs_asignados.movdismaq_mtrs
,semi.artsemi_id
FROM (

			select  pendiente.*,atendido.atendido
			 from (

					SELECT  distinct movdismaq_numped,movdismaq_atendido as pendiente, movdismaq_maqid
					FROM  PROMOVDISPONIBILIDADMAQ
					WHERE  movdismaq_atendido= '0' and movdismaq_proceso= '$proceso' -- and movdismaq_idmaq= '25' 
					GROUP BY movdismaq_numped, movdismaq_atendido,movdismaq_maqid
					)pendiente

			left  join (
		

					SELECT  distinct movdismaq_numped,movdismaq_atendido as atendido,movdismaq_maqid
					FROM  PROMOVDISPONIBILIDADMAQ
					WHERE movdismaq_atendido= '1' and movdismaq_proceso= '$proceso'--and movdismaq_idmaq= '25' 
					GROUP BY movdismaq_numped, movdismaq_atendido,movdismaq_maqid
					)atendido
					on atendido.movdismaq_numped = pendiente.movdismaq_numped
                                        
                                            
			where pendiente.pendiente='0' and atendido.atendido is null 

)op_siguiente
inner join PROMGMAQUINA maq on maq.maq_id = op_siguiente.movdismaq_maqid
inner join ". $_SESSION['server_vinculado']."vepedidod vd on vd.nroped= op_siguiente.movdismaq_numped
inner join ". $_SESSION['server_vinculado']."vepedidoc vc on vc.nroped= op_siguiente.movdismaq_numped
inner join (
			select  sum(movdismaq_mtrs) movdismaq_mtrs , movdismaq_numped, movdismaq_idmaq
			from PROMOVDISPONIBILIDADMAQ
			where  movdismaq_proceso= '$proceso' and movdismaq_tipoocupacion='Programacion'
			group by movdismaq_numped,movdismaq_idmaq
			)mtrs_asignados on
			mtrs_asignados.movdismaq_numped=op_siguiente.movdismaq_numped and mtrs_asignados.movdismaq_idmaq= op_siguiente.movdismaq_maqid
inner join (
			 select distinct prokandet_nroped,prokandet_tipo,artsemi_id
			  from PROPROGKANBANDET
			  where prokandet_tipo = 'saco'

			)semi
			on semi.prokandet_nroped = op_siguiente.movdismaq_numped

order by op_siguiente.movdismaq_maqid, op_siguiente.movdismaq_numped



    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
    
    
    
        public function ConsultarSegPedForm($ini, $fin,$estado) { // produccion 2019
         $sql= " ";
            $sql.="
        select tabla10.* , 
stock.cantini,
stock.cantstock,stock.nroped

,case when cast ( tabla10.cantidadb as int ) > '0'  and cast (tabla10.cantidada as int )> '0' then  round (cast( (convert (decimal (12,2),tabla10.cantidadb)/convert (decimal(12,2),tabla10.cantidada))*100 as float),2) else 0 end as porcentaje
from  (
			
			Select datosgena.* 
			,	case when CLASEB.sumcantidad  is null then '0' else CLASEB.sumcantidad  end as cantidadb ,
			case when  CLASEB.sumpeso is null  then  '0'  else CLASEB.sumpeso end as    pesob
			from (		
						SELECT datosgen.*,
						case when CLASEA.sumcantidad  is null then '0' else CLASEA.sumcantidad  end as cantidada ,
						case when  CLASEA.sumpeso is null  then  '0'  else CLASEA.sumpeso end as    pesoa
						  FROM (

																	-- anterior + detalle del pedido como vendedor , cliente etc (**)	
																	select aprobados.prodped_op,aprobados.prodped_id,aprobados.prodped_estado as estado,
																		case when aprobados.prodped_estado = '0' then 'A' else 'C' end as prodped_estado 
																	, aprobados.prodped_fecaprob , VD.desart, CAST ( VD.cantped  AS INT ) cantped, SEMI.artsemi_id, SEMI.tipsem_id, VD.codart
																	,cast (vc.fecped as date) as entrega,cast ( VC.fechaentrega as date ) AS vencimiento, vc.codven, concat ( ven.apellidos ,' ',ven.nombres) as vendedor
																	,Vc.razonsocial as cliente
																	from (
																			--- OPs aprobadas (*)
																					select * from PROPEDIDOAPROB
																					where prodped_tipaprob = '2' and eliminado = '0'	
											   								--- fin   OPs aprobadas (*)
																	)  aprobados
																	INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = aprobados.prodped_op
																	INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOC VC ON VC.nroped  =VD.nroped
																	INNER JOIN ". $_SESSION['server_vinculado']."VEVENDEDOR ven ON ven.codven  =VC.codven 
																	INNER JOIN PROARTSEMITERMINADO SEMI ON SEMI.form_id = VD.codart 
										
																-- finde  + detalle del pedido como vendedor , cliente etc (**)	
							)datosgen

							LEFT JOIN (
				-- Lista de clase a (***)
							SELECT prefila_op as numop, SUM(prefila_cantidad_fin) sumcantidad, SUM(prefila_peso) sumpeso
																				,prefila_tipo as tipo
																				 FROM PROPRENSAFILAS

																				WHERE eliminado= '0' AND atendido = '1' --and prefila_op = '52031' 
																				and prefila_tipo = 'Clase A'
																				GROUP BY prefila_op, prefila_tipo
	
	
				-- fin de lista de clase a (***)
							)	CLASEA ON CLASEA.numop = datosgen.prodped_op

					  )datosgena


				LEFT JOIN (
			 -- inicicio de lista clase B (****)	
				SELECT prefila_op as numop, SUM(prefila_cantidad_fin) sumcantidad, SUM(prefila_peso) sumpeso
																	,prefila_tipo as tipo
																	 FROM PROPRENSAFILAS

																	WHERE eliminado= '0' AND atendido = '1' --and prefila_op = '52031' 
																	and prefila_tipo = 'Clase B'
																	GROUP BY prefila_op, prefila_tipo
	
			-- fin de lista de clase b (****)
				)	CLASEB ON CLASEB.numop = datosgena.prodped_op		
	
				--where 	datosgena.vencimiento >= '2021-01-01' AND datosgena.vencimiento <= '2021-01-15'
				--ORDER BY datosgena.vencimiento
	)tabla10

	left join 

	(

	select SUM(tablefin.cantini)cantini,sum( tablefin.cantstock)cantstock, try_cast ( nroped as int) as nroped 
	from (
				select t12.*,try_cast(substring(t12.strlote, Charindex('-',t12.strlote)+1,len(t12.strlote)- Charindex('-',t12.strlote)+1) as int) nroped
				from (
							select * ,  right(trim(lotefab) , 5) strlote 
							from (
									select * 
									from ". $_SESSION['server_vinculado']."pplotefab 
									where eliminado = 0 and idlotefab not in
											 (select idlotefab 
											 from  ". $_SESSION['server_vinculado']."pplotefab 
											 where lotefab Like '%[A-Z]%'union all
														select idlotefab 
														from  ". $_SESSION['server_vinculado']."pplotefab 
														where lotefab Like '%[./,]%'
											  ) 
				 ) t1
		 ) t12
)tablefin
	--where tablefin.nroped = '0'		
group by  tablefin.nroped	


	)stock on stock.nroped = tabla10.prodped_op

where 	tabla10.vencimiento >= '$ini' AND tabla10.vencimiento <= '$fin'

 
";
          if($estado != '-1'){
           $sql .= " and tabla10.estado = '$estado' ";
                 }
        
        
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $segped = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $segped;
    }
    
                public function cerrarOps($op,$idop, $prodped_usr) {
        $stmt = $this->objPdo->prepare("
              update    PROPEDIDOAPROB  
            set prodped_estado ='1', prodped_usr = '$prodped_usr',prodped_fecha_cerrarop = SYSDATETIME() 
            where prodped_id = '$idop' and prodped_op = '$op'
           ");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
                   public function LiberarOps($op,$idop, $prodped_usr) {
        $stmt = $this->objPdo->prepare("
              update    PROPEDIDOAPROB  
            set prodped_estado ='0', prodped_usr = '$prodped_usr',prodped_fecha_cerrarop = SYSDATETIME() 
            where prodped_id = '$idop' and prodped_op = '$op'
           ");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
    
              public function listacambiomaq() { 
        $stmt = $this->objPdo->prepare("

select cam.*,maqori.maq_nombre as origen, maqfin.maq_nombre as fin , kan.prokandet_nroped from PROPLACAMBIOMAQ cam
inner join PROMGMAQUINA maqori on maqori.maq_id = cam.cammaq_ori
inner join PROMGMAQUINA maqfin on maqfin.maq_id = cam.cammaq_fin
inner join PROPROGKANBANDET kan on kan.prokandet_id = cam.cammaq_kanban
 WHERE cam.eliminado = '0'
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
                  public function ConsultarOPabierta() { 
        $stmt = $this->objPdo->prepare("
 select * 
 from PROPEDIDOAPROB
 where prodped_tipaprob = '2' and prodped_estado =0 and eliminado = '0'
  ORDER BY prodped_id
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
                    public function ListarKanbanXproceso($ops_abierta,$procesos) { 
        $stmt = $this->objPdo->prepare("
select DISPO.* , MAQ.maq_nombre 
,KANDET.artsemi_id,
CASE WHEN  FEC.fecdispmaq_fechadisp IS NULL THEN GETDATE() ELSE  FEC.fecdispmaq_fechadisp END AS fecdispmaq_fechadisp
from PROMOVDISPONIBILIDADMAQ DISPO
 inner join PROMGMAQUINA maq on maq.maq_id = dispo.movdismaq_maqid
  INNER JOIN PROPROGKANBANDET KANDET ON KANDET.prokandet_id = DISPO.movdismaq_idkanban
 LEFT JOIN PROFECHADISPMAQUINA FEC ON FEC.fecdispmaq_codmaq = DISPO.movdismaq_idmaq
where DISPO.movdismaq_proceso= '$procesos' and DISPO.movdismaq_estado = '0' and DISPO.movdismaq_numped = '$ops_abierta'and DISPO.movdismaq_tipoocupacion = 'Programacion'
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
    
       function consultarMaqXproceso($procesos) {//producción 2019
        $lista = [];
        $consultar = new maquinas();
        if ($procesos == '167') {

            $lista = $consultar->ConsultarxArea('4');//ok
        } else if ($procesos == '168') {
            
             $lista = $consultar->ConsultarxArea('5');//ok
        }else if ($procesos == '169') {
            
           $lista = $consultar->ConsultarxArea('6');//ok
         
        } else if ($procesos == '170') {
            
           $lista = $consultar->ConsultarxArea('7');//ok
         
        }
        return $lista;
    }
    
    
            public function UpdateTblKanbanDet($kanban,$maq_detino ) {
        $stmt = $this->objPdo->prepare("
        UPDATE PROPROGKANBANDET SET prokandet_telar ='$maq_detino' WHERE  prokandet_id = '$kanban';
           ");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
         public function UpdateTblDisponibilidadMaq($kanban,$maq_detino,$fec_maq_destino,$tiempo_produccion_dest,$nuevaFecha_produccion_dest,$id ) {
        $stmt = $this->objPdo->prepare("
   UPDATE PROMOVDISPONIBILIDADMAQ SET movdismaq_idmaq = '$maq_detino' , movdismaq_maqid ='$maq_detino' 
    , movdismaq_fecinicio = '$fec_maq_destino',movdismaq_tiempo='$tiempo_produccion_dest', movdismaq_fecfin='$nuevaFecha_produccion_dest'            
WHERE movdismaq_idkanban = '$kanban' and movdismaq_id = '$id';
           ");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
        
                    public function ListFecDispoxMaquina($maq_id) { 
        $stmt = $this->objPdo->prepare("
	SELECT * FROM PROFECHADISPMAQUINA
	where fecdispmaq_codmaq = '$maq_id'
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
         public function UpdateFecDisponiMaq($maq_id,$fecha ) {
        $stmt = $this->objPdo->prepare("
  UPDATE PROFECHADISPMAQUINA SET fecdispmaq_fechadisp= '$fecha' WHERE fecdispmaq_codmaq = '$maq_id' ;
  ");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
        public function insertarCambioMaq($cammaq_kanban,$cammaq_ori,$cammaq_fin, $cammaq_proceso,$cammaq_motivo,$cammaq_usr) { //producción 2020
        $stmt = $this->objPdo->prepare("
          	insert into PROPLACAMBIOMAQ (cammaq_kanban,cammaq_ori, cammaq_fin, cammaq_proceso, cammaq_motivo, cammaq_usr) 
	values ('$cammaq_kanban','$cammaq_ori','$cammaq_fin','$cammaq_proceso','$cammaq_motivo','$cammaq_usr')  

       ");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
    
              public function ordenPedCan_sgteProc($proceso,$codart) { 
        $stmt = $this->objPdo->prepare("
SELECT TABLA02.progpro_proceso, TABLA02.prokandet_nroped, TABLA02.desart ,TABLA02.codart, COUNT (*) AS cantidad
FROM ( 

		select tabla01.*, prokandet_nroped,VD.desart, vd.codart
		from (
				SELECT 
				PRO.progpro_id, PRO.progpro_proceso, PRO.progpro_kanban,PRO.progpro_atendido , PRO.progpro_siguienteproc
				FROM  PROPROGRAMACIONPROC PRO
				WHERE progpro_id= (SELECT  TOP 1 PRO2.progpro_id FROM PROPROGRAMACIONPROC PRO2
									WHERE PRO2.progpro_kanban=PRO.progpro_kanban AND (PRO2.progpro_atendido = '1' and PRO2.eliminado= '0' and PRO2.estado= '0')
									ORDER BY PRO2.progpro_id DESC
					
									)
				--and PRO.progpro_kanban = '34'  339 registros
				)tabla01
		inner join PROPROGKANBANDET kandet on kandet.prokandet_id =tabla01.progpro_kanban
		inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = kandet.prokandet_nroped
		inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VC ON VC.nroped = VD.nroped
		INNER JOIN  ". $_SESSION['server_vinculado']."ALART ART ON ART.codart = VD.codart
		where tabla01.progpro_atendido = '1' and 
              (tabla01.progpro_siguienteproc = '168' or tabla01.progpro_siguienteproc= '169' or tabla01.progpro_siguienteproc= '170')
		AND ART.tipoarticulo = '001'
		)TABLA02
		where TABLA02.progpro_siguienteproc = '$proceso' and  TABLA02.codart='$codart'
GROUP BY TABLA02.progpro_proceso, TABLA02.prokandet_nroped, TABLA02.desart ,TABLA02.codart

ORDER BY TABLA02.prokandet_nroped


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   
   
    
          public function artUnicoStock_sgteProc($proceso) { 
        $stmt = $this->objPdo->prepare("

select  tabla20.codart,tabla20.desart,SUM(tabla20.cantidad) AS total
from(
			SELECT TABLA02.progpro_proceso, TABLA02.prokandet_nroped, TABLA02.desart ,TABLA02.codart, COUNT (*) AS cantidad
			FROM ( 

					select tabla01.*, prokandet_nroped,VD.desart, vd.codart
					from (
							SELECT 
							PRO.progpro_id, PRO.progpro_proceso, PRO.progpro_kanban,PRO.progpro_atendido , PRO.progpro_siguienteproc
							FROM  PROPROGRAMACIONPROC PRO
							WHERE progpro_id= (SELECT  TOP 1 PRO2.progpro_id FROM PROPROGRAMACIONPROC PRO2
												WHERE PRO2.progpro_kanban=PRO.progpro_kanban AND (PRO2.progpro_atendido = '1' and PRO2.eliminado= '0' and PRO2.estado= '0')
												ORDER BY PRO2.progpro_id DESC
					
												)
							--and PRO.progpro_kanban = '34'  339 registros
							)tabla01
					inner join PROPROGKANBANDET kandet on kandet.prokandet_id =tabla01.progpro_kanban
					inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = kandet.prokandet_nroped
					inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VC ON VC.nroped = VD.nroped
					INNER JOIN  ". $_SESSION['server_vinculado']."ALART ART ON ART.codart = VD.codart
					where tabla01.progpro_atendido = '1' and 
                                      (tabla01.progpro_siguienteproc = '168' or tabla01.progpro_siguienteproc= '169' or tabla01.progpro_siguienteproc= '170')
					AND ART.tipoarticulo = '001'
					)TABLA02
						where TABLA02.progpro_siguienteproc = '$proceso'
			GROUP BY TABLA02.progpro_proceso, TABLA02.prokandet_nroped, TABLA02.desart ,TABLA02.codart
)tabla20

GROUP BY  tabla20.codart,tabla20.desart
ORDER BY tabla20.codart





    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   


      public function DetstockXkanbanXproceso_sgteProc($proceso,$codart,$op) { 
        $stmt = $this->objPdo->prepare("


select * 
from (
		select tabla01.* , kandet.prokandet_nroped,VD.desart, vd.codart
		from (
				SELECT 
				PRO.progpro_id, PRO.progpro_proceso, PRO.progpro_kanban,PRO.progpro_atendido , PRO.progpro_siguienteproc
				FROM  PROPROGRAMACIONPROC PRO
				WHERE progpro_id= (SELECT  TOP 1 PRO2.progpro_id FROM PROPROGRAMACIONPROC PRO2
									WHERE PRO2.progpro_kanban=PRO.progpro_kanban AND (PRO2.progpro_atendido = '1' and PRO2.eliminado= '0' and PRO2.estado= '0')
									ORDER BY PRO2.progpro_id DESC
					
									)
				--and PRO.progpro_kanban = '34'  136 registros
				)tabla01
		inner join PROPROGKANBANDET kandet on kandet.prokandet_id =tabla01.progpro_kanban
		inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = kandet.prokandet_nroped
		inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VC ON VC.nroped = VD.nroped
		INNER JOIN  ". $_SESSION['server_vinculado']."ALART ART ON ART.codart = VD.codart
		where tabla01.progpro_atendido = '1' and 
             (tabla01.progpro_siguienteproc = '168' or tabla01.progpro_siguienteproc= '169' or tabla01.progpro_siguienteproc= '170')
		AND ART.tipoarticulo = '001'
		
		)tabla02
		where tabla02.progpro_siguienteproc='$proceso' and  TABLA02.codart='$codart' and TABLA02.prokandet_nroped='$op'
		ORDER BY tabla02.progpro_kanban			








    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   
   
      public function ResuStockXproceso_sgteProc($proc,$siguiproc) { 
        $stmt = $this->objPdo->prepare("


select * 
from (
		select tabla01.* , kandet.prokandet_nroped,VD.desart, vd.codart
		from (
				SELECT 
				PRO.progpro_id, PRO.progpro_proceso, PRO.progpro_kanban,PRO.progpro_atendido  ,PRO.progpro_siguienteproc
				FROM  PROPROGRAMACIONPROC PRO
				WHERE progpro_id= (SELECT  TOP 1 PRO2.progpro_id FROM PROPROGRAMACIONPROC PRO2
									WHERE PRO2.progpro_kanban=PRO.progpro_kanban AND (PRO2.progpro_atendido = '1' and PRO2.eliminado= '0' and PRO2.estado= '0')
									ORDER BY PRO2.progpro_id DESC
					
									)
				--and PRO.progpro_kanban = '34'  136 registros
				)tabla01
		inner join PROPROGKANBANDET kandet on kandet.prokandet_id =tabla01.progpro_kanban
		inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = kandet.prokandet_nroped
		inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VC ON VC.nroped = VD.nroped
		INNER JOIN  ". $_SESSION['server_vinculado']."ALART ART ON ART.codart = VD.codart
		where tabla01.progpro_atendido = '1' and (tabla01.progpro_proceso = '167' or tabla01.progpro_proceso= '168' or tabla01.progpro_proceso= '169')
		AND ART.tipoarticulo = '001'
		
		)tabla02
		where tabla02.progpro_proceso='$proc' and  	tabla02.progpro_siguienteproc = '$siguiproc'
		ORDER BY tabla02.progpro_kanban			


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    public function ConsultarProducProcesoXfecha_TEL($ini, $fin, $proceso) { // produccion 2019
        $stmt = $this->objPdo->prepare("

SELECT TABLA01.*
 ,DISPO.movdismaq_id, DISPO.movdismaq_proceso,DISPO.movdismaq_mtrs,DISPO.movdismaq_atendido
 ,MAQ.maq_nombre
  ,cast (CONVERT(varchar,  TABLA01.fecha_creacion,8 ) as nvarchar) as horareg
 FROM 
(
			select rolldet.*,
			 roll.progprodet_id,roll.proroll_mtrs_total, roll.proroll_peso_total, roll.proroll_atendido,
			 prog.progpro_id,prog.progpro_proceso,prog.progpro_kanban,prog.progpro_atendido,prog.progpro_siguienteproc
			 ,kandet.prokandet_nroped ,kandet.prokandet_items,kandet.prokandet_mtrs, kandet.prokandet_tipo,kandet.artsemi_id
			 ,vd.codart, vd.desart
			 ,vc.razonsocial
			
			,
			CASE
			 WHEN  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '06:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '13:59:59' as  time)  then 
			 CAST (rolldet.fecha_creacion as date) 
			 when cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '14:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '21:59:59' as  time)  then 
			CAST (rolldet.fecha_creacion as date) 
			 when cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '22:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '23:59:59' as  time)  then 
			 CAST (rolldet.fecha_creacion as date) 
			else   CAST ( DATEADD(DAY,-1,rolldet.fecha_creacion ) AS DATE )
									  end as  fechaproduccion

			,
			CASE
			 WHEN  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '06:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '13:59:59' as  time)  then 
			'Mañana'
			 when cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '14:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '21:59:59' as  time)  then 
			'Tarde'
			 when cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) >= cast ( '22:00:00' as  time)  and  cast (CONVERT(varchar, rolldet.fecha_creacion,8 ) as time) <= cast ( '23:59:59' as  time)  then 
			'Noche'
			else  'Noche'
									  end as  Turno
			 from PROPRODUCCIONROLLODET rolldet
			 inner join PROPRODUCCIONROLLO roll on roll.proroll_id = rolldet.proroll_id
			 inner join PROPROGRAMACIONPROCDET progdet on progdet.progprodet_id = roll.progprodet_id AND progdet.ELIMINADO='0'
			 inner join PROPROGRAMACIONPROC prog on prog.progpro_id = progdet.progpro_id  and prog.eliminado = '0'
			 inner join PROPROGKANBANDET kandet on kandet.prokandet_id= prog.progpro_kanban and  kandet.eliminado= '0'
			-- LEFT JOIN PROMOVDISPONIBILIDADMAQ  DISPO ON ( DISPO.movdismaq_idkanban =kandet.prokandet_id AND DISPO.movdismaq_tipoocupacion = 'Programacion')
			 INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = kandet.prokandet_nroped
			INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOC VC ON VC.nroped  =VD.nroped
			 where rolldet.eliminado = '0' and  roll.eliminado = '0' 
)TABLA01
LEFT JOIN PROMOVDISPONIBILIDADMAQ  DISPO ON ( DISPO.movdismaq_idkanban =TABLA01.progpro_kanban AND DISPO.movdismaq_tipoocupacion = 'Programacion' AND TABLA01.progpro_proceso = DISPO.movdismaq_proceso AND DISPO.movdismaq_estado='0')
INNER JOIN PROMGMAQUINA MAQ ON MAQ.maq_id = DISPO.movdismaq_maqid
WHERE TABLA01.fechaproduccion>= '$ini' AND TABLA01.fechaproduccion<='$fin' AND DISPO.movdismaq_proceso='$proceso'
order by  MAQ.maq_id
");
        $stmt->execute();
        $produc = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $produc;
    }
 
}

?>
