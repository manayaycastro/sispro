<?php

require_once 'conexion.php';

class produccion {

    private $objPdo;
     public function __construct() { // produccion 2020
       
        $this->objPdo = new Conexion();
    }
    

    public function consultartipdoc($are_id) { // produccion 2020
        $stmt = $this->objPdo->prepare("
select *
from PROADMTIPDOCUMENTOS
where eliminado = '0' and are_referencia = '$are_id'");
        $stmt->execute();
        $tipdoc = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tipdoc;
    }
    
        public function consultarturno() { // produccion 2020
        $stmt = $this->objPdo->prepare("
select *
from PROADMTURNOS
where eliminado = '0' ");
        $stmt->execute();
        $turno = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $turno;
    }
    
    
    
    
    
           public function consultarStock($fecha) { // produccion 2020
        $stmt = $this->objPdo->prepare("
select tabla01.*,art.artsemi_descripcion , tabla03.artlot_cajfinal, tabla03.artlot_bobfinal , tabla03.artlot_cantfinal

from 
(
		SELECT TABLA1.artsemi_id, SUM(TABLA1.promov_cant_mov) AS stock
		FROM 
		(
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
			WHERE eliminado='0'
		)TABLA1
		where TABLA1.fechaproduccion <= '$fecha' and cast (TABLA1.promov_fecmov as date ) > '2020-10-03'
		AND TABLA1.eliminado= '0'
		GROUP BY TABLA1.artsemi_id
		
) tabla01
inner join PROARTSEMITERMINADO art on (art.artsemi_id = tabla01.artsemi_id and art.artsemi_estado = '0')
inner join (
select artsemi_id, sum(artlot_cantfinal) as artlot_cantfinal, sum(artlot_cajfinal) as artlot_cajfinal, sum(artlot_bobfinal) as artlot_bobfinal
from PROARTLOTE
where cast( fecha_creacion as date )> '2020-10-03'
AND eliminado= '0'
group by artsemi_id
)as tabla03 on tabla03.artsemi_id = tabla01.artsemi_id
where art.tipsem_id= '1'
order by tabla01.artsemi_id

");
        $stmt->execute();
        $turno = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $turno;
    }
    
    
    
    
    
    
    
    
    
    public function consultarreferencia() { // produccion 2019
        $stmt = $this->objPdo->prepare("
               SELECT *
FROM ". $_SESSION['server_vinculado'] ."rharea
where eliminado = '0' and codarea NOT in  (SELECT are_referencia from PROMGAREAS)
                
");
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $areas;
    }
    
        public function consultarreferenciaid() { // produccion 2019
        $stmt = $this->objPdo->prepare("
               SELECT *
FROM ". $_SESSION['server_vinculado'] ."rharea
where eliminado = '0' 
                
");
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $areas;
    }

    public function consultarActivos() { // produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROMGAREAS where are_estado = '0' and eliminado = 0 ORDER BY are_id;");
        $stmt->execute();
        $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $departamentos;
    }

    public function obtenerxId($area_id) {// produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PROMGAREAS WHERE are_id = :area_id");
        $stmt->execute(array('area_id' => $area_id));
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($areas as $area) {
            $this->setAre_id($area ['are_id']);
            $this->setAre_titulo($area ['are_titulo']);
            $this->setAre_estado($area ['are_estado']);
            $this->setUsr_id($area ['usr_id']);
            $this->setFecha_creacion($area ['fecha_creacion']);
             $this->setAre_referencia($area ['are_referencia']);
        }
        return $this;
    }

    public function insertar() {// produccion 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROMGAREAS (are_titulo, are_estado, usr_id, are_referencia) 
                                        VALUES(:are_titulo,
                                               :are_estado,
                                               :usr_id,
                                               :are_referencia)');
        $rows = $stmt->execute(array('are_titulo' => $this->are_titulo,
            'are_estado' => $this->are_estado,
            'usr_id' => $this->usr_id,
            'are_referencia' => $this->are_referencia));
    }

    public function modificar() {// produccion 2019
        $stmt = $this->objPdo->prepare('UPDATE PROMGAREAS SET are_titulo=:are_titulo, are_estado=:are_estado, usr_id=:usr_id, fecha_creacion = SYSDATETIME(), are_referencia=:are_referencia
                                        WHERE are_id = :are_id');
        $rows = $stmt->execute(array('are_titulo' => $this->are_titulo,
            'are_estado' => $this->are_estado,
            'usr_id' => $this->usr_id,
            'are_id' => $this->are_id,
            'are_referencia' =>  $this-> are_referencia));
    }

    public function eliminar($area_id) { //producción 2019
        $stmt = $this->objPdo->prepare("update  PROMGAREAS set eliminado = '1' WHERE are_id=:are_id");
        $rows = $stmt->execute(array('are_id' => $area_id));
        return $rows;
    }




}

?>
