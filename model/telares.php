<?php

require_once 'conexion.php';

class telares {


    private $objPdo;

    public function __construct() { // produccion 2019
       
        $this->objPdo = new Conexion();
    }

    public function ConsultarTelares() { // produccion 2019
        $stmt = $this->objPdo->prepare("
  select maq.maq_id, maq.maq_nombre, tipsemi.tipsem_id, maq.maq_estado 

			from PROMGMAQUINA maq
			inner join PROMGAREAS ar on ar.are_id = maq.are_id
			inner join PROTIPOSEMITERMINADO tipsemi on tipsemi.are_id = ar.are_id

			where tipsemi.tipsem_id = '2' and maq_estado = '0'
");
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $areas;
    }


    public function ConsultarOcupMaq($idmaq) { // produccion 2019
        $stmt = $this->objPdo->prepare("
	
	select distinct  fechaocu , movdismaq_numped, kan.prokan_coloid
	from(
			SELECT * , cast (movdismaq_fecfin as date) as fechaocu
			FROM PROMOVDISPONIBILIDADMAQ

			WHERE movdismaq_proceso = '167' AND movdismaq_idmaq = '$idmaq' --AND movdismaq_numped = '51919' 
			--ORDER BY movdismaq_id, movdismaq_idkanban asc
			)fecha
			inner join PROPROGKANBAN kan on kan.prokan_nroped = fecha.movdismaq_numped
			order by fecha.fechaocu asc
");
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $areas;
    }
    
    
    
       public function ConsultarAvancexOP($idmaq) { // produccion 2019
        $stmt = $this->objPdo->prepare("



select resultado.*,
case when resultado.movdismaq_atendido = '1' then 0 else resultado.metrostej end as pendiente,
case when resultado.movdismaq_atendido = '1' then 100 else round( (( resultado.prokan_mtrs_totales -resultado.metrostej)/resultado.prokan_mtrs_totales)*100,2,0) end as porcentaje


from (
select atendido.*, pendiente.repet 

from (

SELECT dispo.movdismaq_numped, sum(dispo.movdismaq_mtrs) metrostej, dispo.movdismaq_atendido, mtrtotal.prokan_mtrs_totales
			FROM PROMOVDISPONIBILIDADMAQ dispo
			inner join 
			(
			SELECT DISPOTOT.movdismaq_numped, SUM(DISPOTOT.movdismaq_mtrs)  AS prokan_mtrs_totales 
			FROM PROMOVDISPONIBILIDADMAQ DISPOTOT
			WHERE DISPOTOT.movdismaq_proceso = '167' AND DISPOTOT.movdismaq_idmaq = '$idmaq' AND DISPOTOT.movdismaq_estado = '0'  and movdismaq_tipoocupacion = 'Programacion'
			GROUP BY DISPOTOT.movdismaq_numped
			)
			
			
			mtrtotal  on 
			
			mtrtotal.movdismaq_numped= dispo.movdismaq_numped

			WHERE dispo.movdismaq_proceso = '167' AND dispo.movdismaq_idmaq = '$idmaq' AND dispo.movdismaq_estado = '0' 
			--and  dispo.movdismaq_atendido = '1'
			and movdismaq_tipoocupacion = 'Programacion'
		
			group by dispo.movdismaq_numped, dispo.movdismaq_atendido,  mtrtotal.prokan_mtrs_totales
) atendido
left join 
(
	select repe.movdismaq_numped, count (*) repet 
	from( 

			SELECT dispo.movdismaq_numped, sum(dispo.movdismaq_mtrs) metrostej, dispo.movdismaq_atendido, kan.prokan_mtrs_totales
						FROM PROMOVDISPONIBILIDADMAQ dispo
						inner join PROPROGKANBAN kan on kan.prokan_nroped= dispo.movdismaq_numped

						WHERE dispo.movdismaq_proceso = '167' AND dispo.movdismaq_idmaq = '$idmaq' AND dispo.movdismaq_estado = '0' 
						--and  dispo.movdismaq_atendido = '0'
						and movdismaq_tipoocupacion = 'Programacion'
		
						group by dispo.movdismaq_numped, dispo.movdismaq_atendido,  kan.prokan_mtrs_totales

		)repe
		group by repe.movdismaq_numped
		--having count(*)>1

)pendiente on pendiente.movdismaq_numped = atendido.movdismaq_numped 
		)resultado
		inner join PROPROGKANBAN kan on (kan.prokan_nroped = resultado.movdismaq_numped and kan.estado= '0')
		where  CONCAT(resultado.movdismaq_atendido,resultado.repet)!= '12' -- resultado.movdismaq_atendido !='0' and resultado.repet !='2'

");
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $areas;
    }


}

?>
