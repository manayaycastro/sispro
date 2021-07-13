<?php

require_once 'conexion.php';

class prensa {


    private $objPdo;

    public function __construct() { // produccion 2019
       
        $this->objPdo = new Conexion();
    }

    public function ConsultarProduccResumenDia($ini, $fin) { // produccion 2019
        $stmt = $this->objPdo->prepare("
 select tablafin2.* 
, artic.descripcion as descripcionfin
from (

select tablafin.*
,case when tablafin.codartfin is null then  tablafin.codart  else   tablafin.codartfin  end as codigofin

 from (
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

		WHERE eliminado= '0' AND atendido = '1' --and prefila_op = '52031' 
		GROUP BY prefila_op, prefila_tipo
		)  fil
		INNER JOIN  ". $_SESSION['server_vinculado']."VEPEDIDOD VD ON VD.nroped = fil.numop
		INNER JOIN PROARTSEMITERMINADO SEMI ON SEMI.form_id = VD.codart 
) totalped  
inner join (
		SELECT  prefila_op as numop_par, SUM(prefila_cantidad_fin) sumcantidad_par, SUM(prefila_peso) sumpeso_par
		,prefila_tipo as tipo_par, fechaproduccion,codartfin
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


						where fil.atendido = '1' and fil.eliminado = '0' --AND CAST ( fil.fecha_modif AS DATE) >= '2020-12-01' AND CAST (fil.fecha_modif AS DATE) <= '2020-12-31'
		)TABLA01
		GROUP BY prefila_op, prefila_tipo,fechaproduccion,codartfin

)produccion on (produccion.numop_par = totalped.numop and produccion.tipo_par = totalped.tipo)
)DATOS
LEFT JOIN PROVALITEMSCARACT VALITEM ON (VALITEM.artsemi_id =DATOS.artsemi_id AND VALITEM.itemcaracsemi_id = '17')
where DATOS.fechaproduccion>= '$ini' and DATOS.fechaproduccion<='$fin'
)tablafin)tablafin2
inner join ". $_SESSION['server_vinculado']."ALART artic on artic.codart = tablafin2.codigofin
ORDER BY tablafin2.fechaproduccion


");
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $areas;
    }
    
    
    
            public function conultarClaseB($codart) { 
        $stmt = $this->objPdo->prepare("

select tablafin.*, artCLASEB.descripcion 
,CASE WHEN  tablafin.itemcaracsemi_id = '111' THEN 'Clase B'
WHEN  tablafin.itemcaracsemi_id = '112' THEN 'Clase B - Picar'
WHEN  tablafin.itemcaracsemi_id = '113' THEN 'Clase - Costura'
     END AS tipo
from 
(
select art.artsemi_id, art.form_id, val.valitemcarac_valor as codigofin,val.itemcaracsemi_id
from PROARTSEMITERMINADO art
inner join PROVALITEMSCARACT val on ( val.artsemi_id = art.artsemi_id and  (val.itemcaracsemi_id = '111' or val.itemcaracsemi_id = '112' or val.itemcaracsemi_id = '113'))
where art.form_id = '$codart'
)tablafin


LEFT join ". $_SESSION['server_vinculado']."ALART artCLASEB on artCLASEB.codart = tablafin.codigofin


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }




}

?>
