<?php

require_once 'conexion.php';

class kanban {

    private $objPdo;

    public function __construct() { 
        $this->objPdo = new Conexion();
    }


    public function consultarVbPlanificacion($inicio, $fin) { // produccion 20200327
        $stmt = $this->objPdo->prepare("
       
SELECT 
VEC.nroped, VEC.codalm, cast (VEC.fecped as date) as fecped , VEC.estado, VEC.codcli, VEC.codven, VEC.conpag, VEC.codmon, VEC.tasaigv,
VEC.razonsocial, VEC.direccion, VEC.nroid, VEC.observacion, cast ( fechaentrega as date ) as fechaentrega , VEC.occliente, VEC.valorventa,
VEC.imptotal, VEC.factorc,
ALMA.nombre,
estado.descripcion,
clien.lineacredito,
vended.apellidos, vended.nombres,
VED.codart, VED.desart, ved.cantped, VED.preuni, VED.coduser
, art.codalt,diseno.*,CONPAG.descripcion as nomconpag,aprobado.prodped_id, aprobado.prodidet_id as disenoapro,observado.*,datoskan.*
,tablacaract.corteconversion, tablacaract.metrosrollo, tablacaract.largoparche,tablacaract.artsemi_id
,aprobado.prodped_fecaprob
FROM " . $_SESSION['server_vinculado'] . "VEPEDIDOC VEC
inner join " . $_SESSION['server_vinculado'] . "ALALM ALMA ON ALMA.codalm = VEC.codalm
inner join (
select tc.codtabla, td.codelemento, td.descripcion
from " . $_SESSION['server_vinculado'] . "MGTABGENC  tc
inner join " . $_SESSION['server_vinculado'] . "MGTABGEND td on td.codtabla = tc.codtabla
where tc.codtabla = '015'
) estado on estado.codelemento = VEC.estado
inner join " . $_SESSION['server_vinculado'] . "VECLIENTE  clien on clien.codcli = VEC.codcli
inner join " . $_SESSION['server_vinculado'] . "VEVENDEDOR vended on vended.codven = VEC.codven
inner join " . $_SESSION['server_vinculado'] . "VEPEDIDOD VED ON VED.nroped = VEC.nroped
    

   
inner join (
select tabla.*, semi.form_id as codsiempresoft
from (
select PivotTable.artsemi_id, PivotTable.[76] as metrosrollo, PivotTable.[48] as corteconversion, PivotTable.[105] as largoparche
from (
select  artsemi_id,itemcaracsemi_id, 
case when valitemcarac_valor is null then 0 
when valitemcarac_valor = '' then 0 
when  TRY_CAST ( valitemcarac_valor as decimal(15,2))  is not null  then cast ( valitemcarac_valor as decimal(15,2))
else 0
 end as decimal1  from PROVALITEMSCARACT
where  ( itemcaracsemi_id = '76' or itemcaracsemi_id= '48' or itemcaracsemi_id= '105') --and artsemi_id = '113' 
) as tabla01 pivot(avg(decimal1) for itemcaracsemi_id in ([48],[76],[105]) )as PivotTable
) tabla
inner join PROARTSEMITERMINADO  semi on semi.artsemi_id= tabla.artsemi_id

) tablacaract on tablacaract.codsiempresoft = VED.codart


    INNER JOIN " . $_SESSION['server_vinculado'] . "VECONPAG CONPAG ON CONPAG.CONPAG=VEC.CONPAG
    INNER  join " . $_SESSION['server_vinculado'] . "ALART art ON VED.CODART=art.CODART
        left join PROPEDIDOAPROB aprobado on  aprobado.prodped_op = VEC.nroped and aprobado.prodped_tipaprob = '2'
        left join (
SELECT proobs_id_doc, COUNT(proobs_id_doc) AS obs
FROM PROOBSERVACIONES
WHERE  proobs_finalizado = '0'
GROUP BY proobs_id_doc

) as observado on observado.proobs_id_doc =  VEC.nroped
LEFT JOIN 
(
select disedet.prodidet_id, disedet.prodi_id, disedet.prodidet_url,disedet.prodidet_version,dise.prodi_codart,dise.prodi_cliente
from PRODISENOSDET disedet
inner join PRODISENOS dise on dise.prodi_id = disedet.prodi_id and disedet.prodidet_vigente = '1'
) AS diseno
on diseno.prodi_codart = VED.CODART

LEFT JOIN (
select * from PROPROGKANBAN kan
WHERE kan.eliminado = '0'
)as datoskan on  datoskan.prokan_nroped = VEC.nroped


WHERE  VEC.tipped = 'VAB' AND CAST(aprobado.prodped_fecaprob AS DATE ) >= '$inicio' AND CAST(aprobado.prodped_fecaprob AS DATE ) <= '$fin' and aprobado.prodped_id is not null and  observado.proobs_id_doc is null


        

    ");
        $stmt->execute();
        $ops = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ops;
    }

    public function insertarkanban($prokan_nroped, $prokan_mtrs_x_rollo, $prokan_larg_corte, $prokan_porcent_b,$prokan_mtrs_totales,$usuario_creacion,$totalkanban, $prokan_mtrs_totalparche, $prokan_cantkanbanparche,$prokan_coloid) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROPROGKANBAN 
            (prokan_nroped,prokan_mtrs_x_rollo,prokan_larg_corte, prokan_porcent_b,prokan_mtrs_totales,usuario_creacion,prokan_cantkanban, prokan_mtrs_totalparche, prokan_cantkanbanparche, prokan_coloid) 
                values ('$prokan_nroped','$prokan_mtrs_x_rollo','$prokan_larg_corte','$prokan_porcent_b','$prokan_mtrs_totales','$usuario_creacion','$totalkanban', '$prokan_mtrs_totalparche','$prokan_cantkanbanparche','$prokan_coloid')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
      public function insertarkanbandet($prokandet_nroped, $prokandet_items, $prokandet_mtrs, $usuario_creacion,$tipo, $artsemi_id) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROPROGKANBANDET 
            (prokandet_nroped,prokandet_items,prokandet_mtrs, usuario_creacion,prokandet_tipo, artsemi_id) 
                values ('$prokandet_nroped','$prokandet_items','$prokandet_mtrs','$usuario_creacion','$tipo','$artsemi_id')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
    
    
     public function ListaKanban($op) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
select * from PROPROGKANBANDET  where prokandet_nroped = '$op'     

    ");
        $stmt->execute();
        $kanban = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kanban;
    }

         public function ListaMaquinas($area) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
SELECT maq_id, maq_nombre FROM PROMGMAQUINA
WHERE are_id ='$area'

    ");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    }
    
          public function insertarTelar($prokandet_id, $telar) { //producción 2020
        $stmt = $this->objPdo->prepare("
            update  PROPROGKANBANDET 
            set prokandet_telar = '$telar'
                where prokandet_id = '$prokandet_id'
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
             public function ListaProcesos() { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
select * from PROTABLAGENDET
where tabgen_id = '19' and eliminado = '0'

    ");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    }
    
      function consultarProceso($ini,$fin,$procesos,$estado) {//producción 2019
        $lista = [];
        $consultar = new kanban();
        if ($procesos == '167') {

            $lista = $consultar->ListProcTelares($ini,$fin,$estado,$procesos);//ok
        } else if ($procesos == '168') {
            
            $lista = $consultar->ListProcLaminado($ini,$fin,$estado,$procesos);//ok
        }else if ($procesos == '169') {
            
          $lista = $consultar->ListProcImpresion($ini,$fin,$estado,$procesos);//ok
         
        } else if ($procesos == '170') {
            
          $lista = $consultar->ListProcConversion($ini,$fin,$estado,$procesos);//ok
         
        } else if ($procesos == '171') {

           $lista = $consultar->ListProcBastillado($ini,$fin,$estado,$procesos);//revisar
        }elseif ($procesos == '172'){

            $lista = $consultar->ListProcBastillado($ini,$fin,$estado,$procesos);//ok
        }elseif ($procesos == '173'){

            $lista = $consultar->ListProcConversionConvert($ini,$fin,$estado,$procesos);
        }
        return $lista;
    }

    public function ListProcTelares($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "select kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban,cast (vec.fechaentrega as date ) fechaentrega
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso
,progra.movdismaq_fecfin, maq.maq_nombre,progra.movdismaq_maqid,kandet.prokandet_mtrs as metros_procanterior
from PROPROGKANBANDET kandet
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join  " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROMOVDISPONIBILIDADMAQ progra on progra.movdismaq_idkanban = kandet.prokandet_id and movdismaq_estado = '0' 
inner join PROMGMAQUINA maq on maq.maq_id = progra.movdismaq_idmaq

LEFT JOIN( select * from  PROPROGRAMACIONPROC  where progpro_proceso='$procesos' and eliminado ='0' )propro

on propro.progpro_kanban= kandet.prokandet_id-- and propro.progpro_proceso= '168'

where kandet.estado = '0' and kandet.eliminado = '0' AND progra.movdismaq_tipoocupacion = 'Programacion' and
 ( CAST(progra.movdismaq_fecfin AS DATE) >= '$ini' AND CAST( progra.movdismaq_fecfin AS DATE)<='$fin')  and maq.are_id='4' ";
        
        if($estado == '0'){
           $sql .= " and propro.progpro_id is  null ";
           
        }elseif($estado == '1'){
            $sql .= " and propro.progpro_id is not null ";
            
        }
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
    
        public function insertarProgProcesos($progpro_proceso, $progpro_codreferencia, $progpro_kanban, $progpro_fecprogramacion,$usuario_creacion,$progpro_siguienteproc) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROPROGRAMACIONPROC 
            (progpro_proceso,progpro_codreferencia,progpro_kanban, progpro_fecprogramacion,usuario_creacion,progpro_siguienteproc) 
                values ('$progpro_proceso','$progpro_codreferencia','$progpro_kanban','$progpro_fecprogramacion','$usuario_creacion','$progpro_siguienteproc')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
          function consultarProcesoIniciar($ini,$fin,$procesos,$estado,$maquina) {//producción 2019
        $lista = [];
        $consultar = new kanban();
        if ($procesos == '167') {
				if($maquina =='-1'){
				$lista = $consultar->ListInicProcTelares($ini,$fin,$estado,$procesos);//ok
				}else {
				$lista = $consultar->ListInicProcTelaresXmaq($ini,$fin,$estado,$procesos,$maquina);//ok
				}
        } else if ($procesos == '168') {
            
          if($maquina =='-1'){
				$lista = $consultar->ListInicProcTelares($ini,$fin,$estado,$procesos);//ok
				}else {
				$lista = $consultar->ListInicProcTelaresXmaq($ini,$fin,$estado,$procesos,$maquina);//ok
				}
        }else if ($procesos == '169') {
            
           if($maquina =='-1'){
				$lista = $consultar->ListInicProcTelares($ini,$fin,$estado,$procesos);//ok
				}else {
				$lista = $consultar->ListInicProcTelaresXmaq($ini,$fin,$estado,$procesos,$maquina);//ok
				}
         
        } else if ($procesos == '170') {
            
         if($maquina =='-1'){
				$lista = $consultar->ListInicProcTelares($ini,$fin,$estado,$procesos);//ok
				}else {
				$lista = $consultar->ListInicProcTelaresXmaq($ini,$fin,$estado,$procesos,$maquina);//ok
				}
         
        } else if ($procesos == '171') {

            $lista = $consultar->ListInicProcBas($ini,$fin,$estado,$procesos);
        }elseif ($procesos == '172'){

            $lista = $consultar->ListInicProcBas($ini,$fin,$estado,$procesos);
        }elseif ($procesos == '173'){

            if($maquina =='-1'){
				$lista = $consultar->ListInicProcTelares($ini,$fin,$estado,$procesos);//ok
				}else {
				$lista = $consultar->ListInicProcTelaresXmaq($ini,$fin,$estado,$procesos,$maquina);//ok
				}
        }
        return $lista;
    }
    
    
    
        public function ListInicProcTelares($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "
 select propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido, proprodet.progprodet_id
,tabla01.movdismaq_mtrs as metros_procanterior, tabla01.movdismaq_idkanban as kanban,tabla01.maq_nombre
from PROPROGRAMACIONPROC propro
INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped

LEFT JOIN PROPROGRAMACIONPROCDET proprodet on (proprodet.progpro_id= propro.progpro_id and proprodet.eliminado = '0')

left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq
  where dis.movdismaq_proceso = '$procesos' and  dis.movdismaq_tipoocupacion = 'Programacion') tabla01
  on tabla01.movdismaq_idkanban= kandet.prokandet_id

where propro.estado = '0' and propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and propro.progpro_proceso = '$procesos'


";
        
        if($estado == '2'){
           $sql .= " and ( proprodet.progprodet_fecha_ini is  null and  proprodet.progprodet_fecha_fin is null )";
           
        }elseif($estado == '0'){
            $sql .= " and ( proprodet.progprodet_fecha_ini is not null and  proprodet.progprodet_fecha_fin is null ) ";
            
        }elseif($estado == '1'){
            $sql .= " and ( proprodet.progprodet_fecha_ini is not null and  proprodet.progprodet_fecha_fin is not null ) ";
            
        }
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
        public function ListInicProcTelaresXmaq($ini,$fin,$estado,$procesos,$maquina) { // produccion 20202211
        $sql = "";
                $sql .= "
 select propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido, proprodet.progprodet_id
,dis.movdismaq_maqid
,tabla01.movdismaq_mtrs as metros_procanterior, tabla01.movdismaq_idkanban as kanban,tabla01.maq_nombre
from PROPROGRAMACIONPROC propro
INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROMOVDISPONIBILIDADMAQ dis on (kandet.prokandet_id = dis.movdismaq_idkanban and dis.movdismaq_proceso='$procesos' and dis.movdismaq_tipoocupacion != 'Puesta Marcha')

LEFT JOIN PROPROGRAMACIONPROCDET proprodet on (proprodet.progpro_id= propro.progpro_id and proprodet.eliminado = '0')

left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq
  where dis.movdismaq_proceso = '$procesos' and  dis.movdismaq_tipoocupacion = 'Programacion') tabla01
  on tabla01.movdismaq_idkanban= kandet.prokandet_id

where propro.estado = '0' and propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and propro.progpro_proceso = '$procesos'


";
        
        if($estado == '2'){
           $sql .= " and ( proprodet.progprodet_fecha_ini is  null and  proprodet.progprodet_fecha_fin is null )";
           
        }elseif($estado == '0'){
            $sql .= " and ( proprodet.progprodet_fecha_ini is not null and  proprodet.progprodet_fecha_fin is null ) ";
            
        }elseif($estado == '1'){
            $sql .= " and ( proprodet.progprodet_fecha_ini is not null and  proprodet.progprodet_fecha_fin is not null ) ";
            
        }
        
        if($maquina != '-1'){
			   $sql .= "and dis.movdismaq_maqid = '$maquina' ";
		}
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
    
    
            public function insertarInicProg($propro_id,$fecha_inicio, $hora_inicio,$usuario_nickname) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROPROGRAMACIONPROCDET 
            (progpro_id,progprodet_fecha_ini,progprodet_hora_ini, usuario_creacion) 
                values ('$propro_id','$fecha_inicio','$hora_inicio','$usuario_nickname')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
                 public function ultimoID() { 
        $stmt = $this->objPdo->prepare("
select top 1 progprodet_id  from PROPROGRAMACIONPROCDET order by progprodet_id desc

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    
            public function insertarProducRollo($progprodet_id,$usuario_creacion) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROPRODUCCIONROLLO 
            (progprodet_id, usuario_creacion) 
                values ('$progprodet_id','$usuario_creacion')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    

    
         public   function consultarAvanceProduccRollo($ini,$fin,$procesos,$estado,$maquina) {//producción 2019
        $lista = [];
        $consultar = new kanban();
        if ($procesos == '167') {
			if($maquina =='-1'){
			 $lista = $consultar->ListAvanceproduccTelares($ini,$fin,$estado,$procesos);
				}else {
				$lista = $consultar->ListAvanceproduccTelaresXmaq($ini,$fin,$estado,$procesos,$maquina);
				}

           
        } else if ($procesos == '168') {
			if($maquina =='-1'){
				 $lista = $consultar->ListAvanceproduccTelares($ini,$fin,$estado,$procesos);//ok
				}else {
				$lista = $consultar->ListAvanceproduccTelaresXmaq($ini,$fin,$estado,$procesos,$maquina);//ok
				}
            
          
        }else if ($procesos == '169') {
			if($maquina =='-1'){
				  $lista = $consultar->ListAvanceproduccTelares($ini,$fin,$estado,$procesos);//ok
				}else {
				$lista = $consultar->ListAvanceproduccTelaresXmaq($ini,$fin,$estado,$procesos,$maquina);//ok
				}
            
           
         
        } else if ($procesos == '170') {
			if($maquina =='-1'){
			  $lista = $consultar->ListAvanceproduccTelaresConv($ini,$fin,$estado,$procesos);//ok
				}else {
				$lista = $consultar->ListAvanceproduccTelaresXmaqConv($ini,$fin,$estado,$procesos,$maquina);//ok
				}
            
          
         
        } else if ($procesos == '171') {

              $lista = $consultar->ListAvanceproduccSacos($ini,$fin,$estado,$procesos);
        }elseif ($procesos == '172'){

              $lista = $consultar->ListAvanceproduccSacosPren($ini,$fin,$estado,$procesos);
        }elseif ($procesos == '173'){

              $lista = $consultar->ListAvanceproduccSacos($ini,$fin,$estado,$procesos);
        }
        return $lista;
    }
    
    
         public function ListAvanceproduccTelares($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "
select 
rollo.proroll_id,proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id

--, rollodet.prorolldet_id ,rollodet. ,rollodet. , rollodet. ,rollodet., rollodet
,tabla01.movdismaq_mtrs as metros_procanterior, tabla01.movdismaq_idkanban as kanban
from PROPRODUCCIONROLLO rollo


inner JOIN PROPROGRAMACIONPROCDET proprodet on  (proprodet.progprodet_id= rollo.progprodet_id and  proprodet.eliminado= '0')
inner join PROPROGRAMACIONPROC propro on    propro.progpro_id = proprodet.progpro_id

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
--LEFT join PROPRODUCCIONROLLODET rollodet on rollodet.proroll_id = rollo.proroll_id

left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq
  where dis.movdismaq_proceso = '$procesos' and  dis.movdismaq_tipoocupacion = 'Programacion') tabla01
  on tabla01.movdismaq_idkanban= kandet.prokandet_id

where propro.estado = '0' and propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and propro.progpro_proceso = '$procesos'


";
        
        if($estado == '0'){
           $sql .= " and rollo.proroll_atendido = '0' ";
           
        }elseif($estado == '1'){
            $sql .= " and rollo.proroll_atendido = '1' ";
            
        }
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
    
         public function ListAvanceproduccTelaresXmaq($ini,$fin,$estado,$procesos,$maquina) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "
select 
rollo.proroll_id,proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id

,dis.movdismaq_maqid
,tabla01.movdismaq_mtrs as metros_procanterior, tabla01.movdismaq_idkanban as kanban
from PROPRODUCCIONROLLO rollo


inner JOIN PROPROGRAMACIONPROCDET proprodet on ( proprodet.progprodet_id= rollo.progprodet_id and proprodet.eliminado= '0')
inner join PROPROGRAMACIONPROC propro on    propro.progpro_id = proprodet.progpro_id and propro.estado = '0' and propro.eliminado= '0' 

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban and kandet.estado= '0' and kandet.eliminado= '0'
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROMOVDISPONIBILIDADMAQ dis on (kandet.prokandet_id = dis.movdismaq_idkanban and dis.movdismaq_proceso='$procesos' and dis.movdismaq_tipoocupacion != 'Puesta Marcha')

left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq and dis.movdismaq_estado ='0'
  where dis.movdismaq_proceso = '$procesos' and  dis.movdismaq_tipoocupacion = 'Programacion') tabla01
  on tabla01.movdismaq_idkanban= kandet.prokandet_id
  
where propro.estado = '0' and propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and propro.progpro_proceso = '$procesos'


";
        
        if($estado == '0'){
           $sql .= " and rollo.proroll_atendido = '0' ";
           
        }elseif($estado == '1'){
            $sql .= " and rollo.proroll_atendido = '1' ";
            
        }
        
           
        if($maquina != '-1'){
			   $sql .= "and dis.movdismaq_maqid = '$maquina' ";
		}
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
          public function ListAvanceproduccSacos($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "


select 
rollo.proroll_id,proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id

,sacos.prosacodet_total, sacos.prosacodet_totalb
, ART.valitemcarac_valor as enfardelado
,tabla01.movdismaq_mtrs as metros_procanterior, tabla01.movdismaq_idkanban as kanban
from PROPRODUCCIONROLLO rollo


inner JOIN PROPROGRAMACIONPROCDET proprodet on (proprodet.progprodet_id= rollo.progprodet_id and proprodet.eliminado= '0')
inner join PROPROGRAMACIONPROC propro on    propro.progpro_id = proprodet.progpro_id

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner JOIN (
select ART.* , VAL.valitemcarac_valor
from PROARTSEMITERMINADO ART
INNER JOIN  PROVALITEMSCARACT VAL ON VAL.artsemi_id= ART.artsemi_id
 WHERE  VAL.itemcaracsemi_id = '77'
) ART ON ART.form_id = ved.codart

--agregado para mostrar sacos
LEFT join (
select    roll.proroll_mtrs_total prosacodet_total , roll.proroll_peso_total prosacodet_totalb, roll.proroll_id  , prog.progpro_kanban  
from PROPRODUCCIONROLLO roll

inner join PROPROGRAMACIONPROCDET progdet on progdet.progprodet_id= roll.progprodet_id
inner join PROPROGRAMACIONPROC prog on prog.progpro_id = progdet.progpro_id 
where prog.progpro_siguienteproc = '$procesos' 


)sacos on sacos.progpro_kanban = kandet.prokandet_id

left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq
  where dis.movdismaq_proceso = '$procesos' and  dis.movdismaq_tipoocupacion = 'Programacion') tabla01
  on tabla01.movdismaq_idkanban= kandet.prokandet_id

where propro.estado = '0' and propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and propro.progpro_proceso = '$procesos'


";
    
                
                /*
               select sac.prosacodet_total, sac.prosacodet_totalb, prog.progpro_kanban, sac.prosacodet_id, roll.proroll_id, progdet.progprodet_id, prog.progpro_id
from PROPRODUCCIONSACODET sac
inner join PROPRODUCCIONROLLO roll on roll.proroll_id = sac.proroll_id
inner join PROPROGRAMACIONPROCDET progdet on progdet.progprodet_id= roll.progprodet_id
inner join PROPROGRAMACIONPROC prog on prog.progpro_id = progdet.progpro_id 
where prog.progpro_siguienteproc = '$procesos'  
                 
                 */
        if($estado == '0'){
           $sql .= " and rollo.proroll_atendido = '0' ";
           
        }elseif($estado == '1'){
            $sql .= " and rollo.proroll_atendido = '1' ";
            
        }
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
     public function consultarEmp() { //producción 2019
        $stmt = $this->objPdo->prepare("


select e.*, direc.apellidopaterno, direc.apellidomaterno, direc.primernombre, direc.segundonombre, direc.nroid,  ar.descripcion as area, ar.codarea , car.descripcion as cargo
,INF.codgrupo, GRU.abreviatura
from  ". $_SESSION['server_vinculado']."RHEMPLEADO e
inner join ". $_SESSION['server_vinculado']."MGDIRECTORIO direc on direc.coddir = e.codempl
INNER JOIN ". $_SESSION['server_vinculado']."RHINFLABORAL INF ON ( INF.codempl = E.codempl  AND INF.eliminado= '0')
INNER JOIN ". $_SESSION['server_vinculado']."RHAREA ar on ar.codarea = INF.tipoarea
inner join ". $_SESSION['server_vinculado']."rhcargo car on  car.codcargo = INF.cargo

inner join ". $_SESSION['server_vinculado']."RHGRUPO GRU on  GRU.codgrupo = INF.codgrupo
WHERE (GRU.abreviatura = 'G1' OR GRU.abreviatura = 'G2' OR GRU.abreviatura = 'G3' OR GRU.abreviatura = 'GA') and ar.codarea != '9' and  e.eliminado='0'-- and  direc.nroid = '45817277'
ORDER BY direc.apellidopaterno
                ");
        $stmt->execute();
        $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $item;
    }
    
    
         public function consultarEmpXmaq($maquina) { //producción 2019
        $stmt = $this->objPdo->prepare("

				SELECT empleado.* FROM (
select e.*, direc.apellidopaterno, direc.apellidomaterno, direc.primernombre, direc.segundonombre, direc.nroid,  ar.descripcion as area, ar.codarea , car.descripcion as cargo
,INF.codgrupo, GRU.abreviatura
from  ". $_SESSION['server_vinculado']."RHEMPLEADO e
inner join ". $_SESSION['server_vinculado']."MGDIRECTORIO direc on direc.coddir = e.codempl
INNER JOIN ". $_SESSION['server_vinculado']."RHINFLABORAL INF ON ( INF.codempl = E.codempl  AND INF.eliminado= '0')
INNER JOIN ". $_SESSION['server_vinculado']."RHAREA ar on ar.codarea = INF.tipoarea
inner join ". $_SESSION['server_vinculado']."rhcargo car on  car.codcargo = INF.cargo

inner join ". $_SESSION['server_vinculado']."RHGRUPO GRU on  GRU.codgrupo = INF.codgrupo
WHERE (GRU.abreviatura = 'G1' OR GRU.abreviatura = 'G2' OR GRU.abreviatura = 'G3') and ar.codarea != '9' and  e.eliminado='0'-- and  direc.nroid = '45817277'

)empleado
INNER JOIN PROMAQUINACOLAB maqcol on maqcol.coddir =empleado.codempl

 WHERE maqcol.maq_id = '$maquina'
 ORDER BY empleado.apellidopaterno

                ");
        $stmt->execute();
        $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $item;
    }
    
    
    
             public function ListAvanceproduccTelaresIDrollo($ini,$fin,$id_rrollo) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "
select 
rollo.proroll_id,proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id
,semi.artsemi_descripcion
--, rollodet.prorolldet_id ,rollodet. ,rollodet. , rollodet. ,rollodet., rollodet
from PROPRODUCCIONROLLO rollo


inner JOIN PROPROGRAMACIONPROCDET proprodet on proprodet.progprodet_id= rollo.progprodet_id
inner join PROPROGRAMACIONPROC propro on    propro.progpro_id = proprodet.progpro_id

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROARTSEMITERMINADO semi on semi.artsemi_id = kandet.artsemi_id
--LEFT join PROPRODUCCIONROLLODET rollodet on rollodet.proroll_id = rollo.proroll_id

where propro.estado = '0' and propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and rollo.proroll_id = '$id_rrollo'


";

  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
    
       public function insertarProduccRolloParcial($proroll_id,$prorolldet_mtrs, $prorolldet_peso,$prorolldet_operario,$prorolldet_obs,$usuario_nickname) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROPRODUCCIONROLLODET 
            (proroll_id,prorolldet_mtrs,prorolldet_peso, prorolldet_operario,prorolldet_obs,usuario_creacion) 
                values ('$proroll_id','$prorolldet_mtrs','$prorolldet_peso','$prorolldet_operario','$prorolldet_obs','$usuario_nickname')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
      
public function sumaacumulada($proroll_id) { 
        $stmt = $this->objPdo->prepare("
select sum(prorolldet_mtrs) as prorolldet_mtrs, sum(prorolldet_peso) as prorolldet_peso, proroll_id
 from PROPRODUCCIONROLLOdet where proroll_id = '$proroll_id'  and eliminado = '0' and estado = '0'
     group by proroll_id 
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
              public function UpdateTotalAvance($id, $mtrs, $peso) { //producción 2020
        $stmt = $this->objPdo->prepare("
            update  PROPRODUCCIONROLLO 
            set proroll_mtrs_total = '$mtrs',proroll_peso_total = '$peso'
                where proroll_id = '$id'
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
    public function listarProduccRolloDet($proroll_id) { 
        $stmt = $this->objPdo->prepare("
select * from PROPRODUCCIONROLLODET WHERE eliminado = '0' AND estado = '0' and proroll_id='$proroll_id'
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
             public function CerraProduccRollo($id,$usr) { //producción 2020
        $stmt = $this->objPdo->prepare("
            update  PROPRODUCCIONROLLO 
            set proroll_atendido = '1',usuario_atendido= '$usr'
                where proroll_id = '$id'
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
    
              public function UpdateProgDetProceso($progprodet_id, $fecha_actual,$hora_actual,$usuario_nickname) { //producción 2020
        $stmt = $this->objPdo->prepare("
            update  PROPROGRAMACIONPROCDET 
            set progprodet_fecha_fin = '$fecha_actual',progprodet_hora_fin= '$hora_actual',usuario_modificacion='$usuario_nickname'
                where progprodet_id = '$progprodet_id'
           ");
        $rows = $stmt->execute();
        return $rows;
    }

           public function ListaDisponibilidadMaquinas($codart,$proceso,$area) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
SELECT TABLA02.*
,case when  TABLA02.hora> '06:00:00.0000000'and  TABLA02.hora < '13:59:59.0990000' then  '<span class=".'"label label-success arrowed"'.">Mañana</span>'
	when  TABLA02.hora> '14:00:00.0000000'and  TABLA02.hora < '21:59:59.0990000' then '<span class=".'"label label-info arrowed-in-right arrowed"'.">Tarde</span>'
	else '<span class=".'"label label-inverse"'.">Noche</span>' end as turno
FROM(
select tabla01.* ,  cast ( (convert ( varchar ,tabla01.fecha_disponible ,108)) as time) as hora , semimaq.artsemimaq_velinicial, art.form_id as codart
from
(
SELECT maq_id, maq_nombre, dispo.fecdispmaq_id, dispo.fecdispmaq_fechadisp,
case when dispo.fecdispmaq_fechadisp is null then getdate() 
when dispo.fecdispmaq_fechadisp < getdate() then getdate()  
when  dispo.fecdispmaq_fechadisp > getdate() then dispo.fecdispmaq_fechadisp  end as fecha_disponible

 FROM PROMGMAQUINA maq
left  join PROFECHADISPMAQUINA dispo on dispo.fecdispmaq_codmaq = maq.maq_id
WHERE are_id ='$area')tabla01
inner join PROARTSEMIMAQUINA semimaq on (semimaq.maq_id = tabla01.maq_id and semimaq.eliminado='0')
inner join PROARTSEMITERMINADO art on art.artsemi_id = semimaq.artsemi_id
where art.artsemi_id = '$codart'

)TABLA02
ORDER BY TABLA02.maq_id

    ");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    } 
    
               public function ListaOcupacionMaquinas($id_maq_ocupacion) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
 
  select top 50 * 
  ,case when dispo.movdismaq_atendido = '0' then  '<span class=".'"label label-danger arrowed-in"'.">Pendiente</span>'  
  else '<span class=".'"label label-success arrowed"'.">Atendido</span>'  end as movdismaq_atendido
        ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial
        	,SEMI.artsemi_id, KANDET.prokandet_tipo
  from PROMOVDISPONIBILIDADMAQ dispo
  inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = dispo.movdismaq_numped
inner join  " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = dispo.movdismaq_numped  
INNER JOIN PROPROGKANBANDET KANDET ON KANDET.prokandet_id =dispo.movdismaq_idkanban
INNER JOIN PROARTSEMITERMINADO SEMI ON SEMI.artsemi_id = KANDET.artsemi_id
where dispo.movdismaq_idmaq = '$id_maq_ocupacion'
  order by dispo.movdismaq_fecinicio desc

    ");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    }
    
    
                  public function BuscarIdKanbanEnDisponib($id,$proceso) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."  select * from PROMOVDISPONIBILIDADMAQ where movdismaq_idkanban='$id' and movdismaq_estado = '0'
        $stmt = $this->objPdo->prepare("
   select * 
  from PROMOVDISPONIBILIDADMAQ disp
 
   where disp.movdismaq_idkanban='$id' and disp.movdismaq_estado = '0' and disp.movdismaq_tipoocupacion= 'Programacion' and disp.movdismaq_proceso ='$proceso' ");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    }
    
    
                    public function BuscarConifgMaquina($codart, $maq_id) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
  select artsemimaq.artsemimaq_id,artsemimaq.artsemimaq_estado,artsemimaq.artsemi_id,artsemimaq.maq_id,artsemimaq.artsemimaq_velinicial, artsemimaq.artsemimaq_puestapunto
 ,semit.form_id as codart
 from PROARTSEMIMAQUINA artsemimaq
 inner join PROARTSEMITERMINADO semit on semit.artsemi_id = artsemimaq.artsemi_id
 where semit.artsemi_id = '$codart' and artsemimaq.maq_id= '$maq_id'

    ");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    }
    
                     public function BuscarConifgMaquinaXOP($nroped,$maq_id) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
 SELECT * FROM PROMOVDISPONIBILIDADMAQ WHERE movdismaq_numped = '$nroped'and movdismaq_idmaq = '$maq_id'

    ");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    }
    
    
        public function insertarOcupacionMaquina($movdismaq_idmaq,$movdismaq_numped, $movdismaq_idkanban,$movdismaq_mtrs,
                $movdismaq_fecinicio,$movdismaq_tiempo,$movdismaq_fecfin,$movdismaq_tipoocupacion,$movdismaq_proceso,$maq_id) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROMOVDISPONIBILIDADMAQ 
            (movdismaq_idmaq,movdismaq_numped,movdismaq_idkanban, movdismaq_mtrs,movdismaq_fecinicio,movdismaq_tiempo,movdismaq_fecfin,movdismaq_tipoocupacion,movdismaq_proceso,movdismaq_maqid) 
                values ('$movdismaq_idmaq','$movdismaq_numped','$movdismaq_idkanban','$movdismaq_mtrs',cast('$movdismaq_fecinicio' as datetime2),'$movdismaq_tiempo',cast('$movdismaq_fecfin' as datetime2),'$movdismaq_tipoocupacion','$movdismaq_proceso','$maq_id')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
    
        public function UpdatePROFECHADISPMAQUINA ($maq_id,$nuevafecha) { //producción 2020
        $stmt = $this->objPdo->prepare("
            update  PROFECHADISPMAQUINA 
            set fecdispmaq_fechadisp =  cast('$nuevafecha' as datetime2)
                where fecdispmaq_codmaq = '$maq_id'
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
    
    
             public function InsertPROFECHADISPMAQUINA($maq_id,$nuevafecha) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROFECHADISPMAQUINA 
            (fecdispmaq_codmaq,fecdispmaq_fechadisp) 
                values ('$maq_id',cast ('$nuevafecha' as datetime2))");
        $rows = $stmt->execute(array());
        return $rows;
    }
             
    
    
         public function ListaKanbanV02($op,$area,$proceso) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
select kandet.* , dispo.movdismaq_idmaq, dispo.movdismaq_fecinicio,dispo.movdismaq_fecfin,maq.maq_nombre
from PROPROGKANBANDET   kandet
left join PROMGMAQUINA maq on maq.maq_id= kandet.prokandet_telar
left join PROMOVDISPONIBILIDADMAQ dispo on dispo.movdismaq_idkanban = kandet.prokandet_id and dispo.movdismaq_estado= '0'

where  (dispo.movdismaq_tipoocupacion = 'Programacion' or dispo.movdismaq_tipoocupacion is null) and   kandet.prokandet_nroped = '$op' 
    AND  (dispo.movdismaq_proceso = '$proceso' or dispo.movdismaq_proceso is null) AND KANDET.eliminado= '0'
  ORDER BY kandet.prokandet_id


    ");
        $stmt->execute();
        $kanban = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kanban;
    }
    
    
              public function UpdateCerraDisponibilidadTelar($kandet_id) { //producción 2020
        $stmt = $this->objPdo->prepare("
            update  PROMOVDISPONIBILIDADMAQ 
            set movdismaq_atendido = '1'
                where movdismaq_idkanban = '$kandet_id' and movdismaq_estado= '0'
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
                  public function UpdateProgProcesosAtendido($kandet_id) { //producción 2020
        $stmt = $this->objPdo->prepare("
            update  PROPROGRAMACIONPROC 
            set progpro_atendido = '1', fecha_atencion = sysdatetime()
                where progpro_kanban = '$kandet_id' and eliminado= '0'
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
         public function ListaProcesoXarticulo($codart,$id_kanban_det) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
 select tabla03.*,tabla04.progpro_id, tabla04.progpro_kanban,tabla04.progpro_atendido,tabla04.progpro_siguienteproc
 from ( 
	select tabla1.*,tabla02.tabgendet_nombre as proceso_tabgen
	from
		 (
		 select VAL.valitemcarac_id, VAL.artsemi_id, VAL.itemcaracsemi_id, VAL.valitemcarac_valor,CARACSEMI.itemcaracsemi_descripcion,clasi.clasem_id,
		 clasi.clasem_titulo , semi.form_id
		 from PROVALITEMSCARACT VAL
		 INNER JOIN PROITEMCARACTSEMITERMINADO CARACSEMI ON CARACSEMI.itemcaracsemi_id = VAL.itemcaracsemi_id
		 inner join PROCLASIFSEMITERMINADO clasi on clasi.clasem_id = CARACSEMI.clasem_id
		 inner join PROARTSEMITERMINADO semi on semi.artsemi_id= VAL.artsemi_id
		 where clasi.clasem_id = '14' and VAL.valitemcarac_valor != '-1' and   semi.artsemi_id ='$codart' 
		 )tabla1 --caracteristicas y valores del producto en cuento a la rura
	inner join 
		 ( select tabgendet_id, tabgendet_nombre 
		 from PROTABLAGENDET
		 where tabgen_id= '19'
		 ) tabla02 on tabla02.tabgendet_id = TRY_CAST ( tabla1.valitemcarac_valor as int)  

    )tabla03

 left  join
 (select * from PROPROGRAMACIONPROC where eliminado = '0' and estado ='0' and  progpro_kanban = '$id_kanban_det') tabla04
 on tabla04.progpro_proceso = cast (tabla03.valitemcarac_valor as int )


    ");
        $stmt->execute();
        $kanban = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kanban;
    }
    
    
         public function ListaProcesoXarticuloV01($codart,$id_kanban_det) { //HASTA 27-10-2020
        $stmt = $this->objPdo->prepare("
 select tabla03.*,tabla04.progpro_id, tabla04.progpro_kanban,tabla04.progpro_atendido,tabla04.progpro_siguienteproc
 from ( 
	select tabla1.*,tabla02.tabgendet_nombre as proceso_tabgen
	from
		 (
		 select VAL.valitemcarac_id, VAL.artsemi_id, VAL.itemcaracsemi_id, VAL.valitemcarac_valor,CARACSEMI.itemcaracsemi_descripcion,clasi.clasem_id,
		 clasi.clasem_titulo , semi.form_id
		 from PROVALITEMSCARACT VAL
		 INNER JOIN PROITEMCARACTSEMITERMINADO CARACSEMI ON CARACSEMI.itemcaracsemi_id = VAL.itemcaracsemi_id
		 inner join PROCLASIFSEMITERMINADO clasi on clasi.clasem_id = CARACSEMI.clasem_id
		 inner join PROARTSEMITERMINADO semi on semi.artsemi_id= VAL.artsemi_id
		 where clasi.clasem_id = '14' and VAL.valitemcarac_valor != '-1' and semi.form_id ='$codart' 
		 )tabla1 --caracteristicas y valores del producto en cuento a la rura
	inner join 
		 ( select tabgendet_id, tabgendet_nombre 
		 from PROTABLAGENDET
		 where tabgen_id= '19'
		 ) tabla02 on tabla02.tabgendet_id = TRY_CAST ( tabla1.valitemcarac_valor as int)  

    )tabla03

 left  join
 (select * from PROPROGRAMACIONPROC where eliminado = '0' and estado ='0' and  progpro_kanban = '$id_kanban_det') tabla04
 on tabla04.progpro_proceso = cast (tabla03.valitemcarac_valor as int )


    ");
        $stmt->execute();
        $kanban = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kanban;
    }
    
       public function ListaParaSiguienteProcesoV01($ini, $fin,$procsiguiente) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
select kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso
,propro.progpro_siguienteproc,propro.fecha_atencion
,roll.proroll_mtrs_total, roll.proroll_peso_total, roll.proroll_atendido
, dispo.movdismaq_idmaq, dispo.movdismaq_fecinicio,dispo.movdismaq_fecfin,MAQ.maq_nombre
from PROPROGKANBANDET kandet
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join  " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROPROGRAMACIONPROC propro on propro.progpro_kanban= kandet.prokandet_id
inner join PROPROGRAMACIONPROCDET proprodet on proprodet.progpro_id= propro.progpro_id
inner join PROPRODUCCIONROLLO roll on roll.progprodet_id= proprodet.progprodet_id
INNER join PROMOVDISPONIBILIDADMAQ dispo on dispo.movdismaq_idkanban = kandet.prokandet_id -- AGREGADO
INNER JOIN PROMGMAQUINA MAQ ON MAQ.maq_id=dispo.movdismaq_idmaq

where kandet.estado = '0' and kandet.eliminado = '0' and propro.progpro_atendido= '1' and propro.progpro_siguienteproc = '$procsiguiente'  AND dispo.movdismaq_tipoocupacion = 'Programacion' and
 ( CAST(propro.fecha_atencion AS DATE) >= '$ini' AND CAST( propro.fecha_atencion AS DATE)<='$fin') and roll.proroll_atendido ='1'



    ");
        $stmt->execute();
        $kanban = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kanban;
    }
    
       public function ListaParaSiguienteProceso($ini, $fin,$procsiguiente,$estado) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
       $sql = "";
       $sql .="
select tabla10.* , tabla11.movdismaq_idmaq, CONVERT(varchar, tabla11.movdismaq_fecinicio,20) as movdismaq_fecinicio,convert (varchar ,tabla11.movdismaq_fecfin, 20) as movdismaq_fecfin,tabla11.maq_nombre,tabla11.movdismaq_proceso

from (
select kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial, cast (vec.fechaentrega as date  )fechaentrega,kan.prokan_cantkanban
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso
,propro.progpro_siguienteproc,propro.fecha_atencion
,roll.proroll_mtrs_total, roll.proroll_peso_total, roll.proroll_atendido
--, dispo.movdismaq_idmaq, dispo.movdismaq_fecinicio,dispo.movdismaq_fecfin,MAQ.maq_nombre,dispo.movdismaq_proceso,MAQ.are_id
from PROPROGKANBANDET kandet
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join [192.168.10.242].[ELAGUILA].[DBO].vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join  [192.168.10.242].[ELAGUILA].[DBO].vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROPROGRAMACIONPROC propro on propro.progpro_kanban= kandet.prokandet_id
inner join PROPROGRAMACIONPROCDET proprodet on (proprodet.progpro_id= propro.progpro_id and proprodet.eliminado = '0')
inner join PROPRODUCCIONROLLO roll on roll.progprodet_id= proprodet.progprodet_id
--LEFT join PROMOVDISPONIBILIDADMAQ dispo on dispo.movdismaq_idkanban = kandet.prokandet_id  
--LEFT JOIN PROMGMAQUINA MAQ ON MAQ.maq_id=dispo.movdismaq_maqid

where kandet.estado = '0' and kandet.eliminado = '0' and propro.progpro_atendido= '1' and propro.progpro_siguienteproc = '$procsiguiente'  AND --dispo.movdismaq_tipoocupacion = 'Programacion' and
 ( CAST(propro.fecha_atencion AS DATE) >= '$ini' AND CAST( propro.fecha_atencion AS DATE)<='$fin') and roll.proroll_atendido ='1' -- and dispo.movdismaq_proceso= ''
 )tabla10
  left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq AND DIS.movdismaq_estado= '0'
  where dis.movdismaq_proceso = '$procsiguiente' and  dis.movdismaq_tipoocupacion = 'Programacion') tabla11
  on tabla10.prokandet_id= tabla11.movdismaq_idkanban
 


    ";
       if($estado=='1'){
           $sql.=" where  tabla11.movdismaq_idmaq is null ";
       }elseif($estado=='2'){
             $sql.=" where  tabla11.movdismaq_idmaq is not null ";
       }
           $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $kanban = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kanban;
    }
    
    
    
                  function ConsultarProgProcesoSistema($ini,$fin,$procesos,$estado) {//producción 2019
        $lista = [];
        $consultar = new kanban();
        if ($procesos == '167') {

            $lista = $consultar->ListAvanceproduccTelares($ini,$fin,$procesos);
        } else if ($procesos == '168') {
            
           $lista = $consultar->ListaParaSiguienteProceso($ini,$fin,$procesos,$estado);//ok
        }else if ($procesos == '169') {
            
             $lista = $consultar->ListaParaSiguienteProceso($ini,$fin,$procesos,$estado);//ok
         
        } else if ($procesos == '170') {
            
            $lista = $consultar->ListaParaSiguienteProceso($ini,$fin,$procesos,$estado);//ok
         
        } else if ($procesos == '171') {

            $lista = $consultar->ListaParaSiguienteProceso($ini,$fin,$procesos,$estado);//ok
        }elseif ($procesos == '172'){

           $lista = $consultar->ListaParaSiguienteProceso($ini,$fin,$procesos,$estado);//ok
        }elseif ($procesos == '173'){

           $lista = $consultar->ListaParaSiguienteProceso($ini,$fin,$procesos,$estado);//ok
        }
        return $lista;
    }
    
    
       public function ListProcLaminado($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "select kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban,cast (vec.fechaentrega as date ) fechaentrega
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso
,progra.movdismaq_fecfin, maq.maq_nombre,progra.movdismaq_maqid
,tabla01.movdismaq_mtrs as metros_procanterior, tabla01.movdismaq_idkanban as kanban
from PROPROGKANBANDET kandet
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join  " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROMOVDISPONIBILIDADMAQ progra on progra.movdismaq_idkanban = kandet.prokandet_id AND progra.movdismaq_tipoocupacion = 'Programacion' AND PROGRA.movdismaq_estado ='0'
inner join PROMGMAQUINA maq on maq.maq_id = progra.movdismaq_idmaq

LEFT JOIN( select * from  PROPROGRAMACIONPROC  where progpro_proceso='$procesos'  and eliminado ='0')propro

on propro.progpro_kanban= kandet.prokandet_id-- and propro.progpro_proceso= '168'

left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq
  where dis.movdismaq_proceso = '$procesos' and  dis.movdismaq_tipoocupacion = 'Programacion'  AND dis.movdismaq_estado ='0') tabla01
  on tabla01.movdismaq_idkanban= kandet.prokandet_id

where kandet.estado = '0' and kandet.eliminado = '0' AND progra.movdismaq_tipoocupacion = 'Programacion' and
 ( CAST(progra.fecha_creacion AS DATE) >= '$ini' AND CAST( progra.fecha_creacion AS DATE)<='$fin')  and maq.are_id='5' ";
        
        if($estado == '0'){
           $sql .= " and propro.progpro_id is  null ";
           
        }elseif($estado == '1'){
            $sql .= " and propro.progpro_id is not null ";
            
        }
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    } 
    
        
         public function ListProcImpresion($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "select kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban,cast (vec.fechaentrega as date ) fechaentrega
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso
,progra.movdismaq_fecfin, maq.maq_nombre,progra.movdismaq_maqid
,tabla01.movdismaq_mtrs as metros_procanterior, tabla01.movdismaq_idkanban as kanban
from PROPROGKANBANDET kandet
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join  " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROMOVDISPONIBILIDADMAQ progra on progra.movdismaq_idkanban = kandet.prokandet_id AND progra.movdismaq_tipoocupacion = 'Programacion' AND PROGRA.movdismaq_estado ='0'
inner join PROMGMAQUINA maq on maq.maq_id = progra.movdismaq_idmaq

LEFT JOIN( select * from  PROPROGRAMACIONPROC  where progpro_proceso='$procesos' and eliminado ='0' )propro

on propro.progpro_kanban= kandet.prokandet_id-- and propro.progpro_proceso= '168'

left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq
  where dis.movdismaq_proceso = '$procesos' and  dis.movdismaq_tipoocupacion = 'Programacion' AND dis.movdismaq_estado ='0') tabla01
  on tabla01.movdismaq_idkanban= kandet.prokandet_id


where kandet.estado = '0' and kandet.eliminado = '0' AND progra.movdismaq_tipoocupacion = 'Programacion' and
 ( CAST(progra.fecha_creacion AS DATE) >= '$ini' AND CAST( progra.fecha_creacion AS DATE)<='$fin')  and maq.are_id='6' ";
        
        if($estado == '0'){
           $sql .= " and propro.progpro_id is  null ";
           
        }elseif($estado == '1'){
            $sql .= " and propro.progpro_id is not null ";
            
        }
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    } 
      
            public function ListProcConversion($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "select kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban,cast (vec.fechaentrega as date ) fechaentrega
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso
,progra.movdismaq_fecfin, maq.maq_nombre,progra.movdismaq_maqid
,tabla01.movdismaq_mtrs as metros_procanterior, tabla01.movdismaq_idkanban as kanban
from PROPROGKANBANDET kandet
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join  " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROMOVDISPONIBILIDADMAQ progra on progra.movdismaq_idkanban = kandet.prokandet_id AND progra.movdismaq_tipoocupacion = 'Programacion' AND PROGRA.movdismaq_estado ='0'
inner join PROMGMAQUINA maq on maq.maq_id = progra.movdismaq_idmaq

LEFT JOIN( select * from  PROPROGRAMACIONPROC  where progpro_proceso='$procesos' and eliminado ='0' )propro

on propro.progpro_kanban= kandet.prokandet_id-- and propro.progpro_proceso= '168'

left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq
  where dis.movdismaq_proceso = '$procesos' and  dis.movdismaq_tipoocupacion = 'Programacion' AND dis.movdismaq_estado ='0') tabla01
  on tabla01.movdismaq_idkanban= kandet.prokandet_id

where kandet.estado = '0' and kandet.eliminado = '0' AND progra.movdismaq_tipoocupacion = 'Programacion' and
 ( CAST(progra.fecha_creacion AS DATE) >= '$ini' AND CAST( progra.fecha_creacion AS DATE)<='$fin')  and maq.are_id='7' and maq.maq_id != '155' ";
        
        if($estado == '0'){
           $sql .= " and propro.progpro_id is  null ";
           
        }elseif($estado == '1'){
            $sql .= " and propro.progpro_id is not null ";
            
        }
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    } 
       
       
       
       
                  public function ListProcConversionConvert($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "select kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban,cast (vec.fechaentrega as date ) fechaentrega
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso
,progra.movdismaq_fecfin, maq.maq_nombre,progra.movdismaq_maqid
from PROPROGKANBANDET kandet
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join  " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROMOVDISPONIBILIDADMAQ progra on progra.movdismaq_idkanban = kandet.prokandet_id AND progra.movdismaq_tipoocupacion = 'Programacion' AND PROGRA.movdismaq_estado ='0'
inner join PROMGMAQUINA maq on maq.maq_id = progra.movdismaq_idmaq

LEFT JOIN( select * from  PROPROGRAMACIONPROC  where progpro_proceso='$procesos' and eliminado ='0' )propro

on propro.progpro_kanban= kandet.prokandet_id-- and propro.progpro_proceso= '168'

where kandet.estado = '0' and kandet.eliminado = '0' AND progra.movdismaq_tipoocupacion = 'Programacion' and
 ( CAST(progra.fecha_creacion AS DATE) >= '$ini' AND CAST( progra.fecha_creacion AS DATE)<='$fin')  and maq.are_id='7' and maq.maq_id= '155'";
        
        if($estado == '0'){
           $sql .= " and propro.progpro_id is  null ";
           
        }elseif($estado == '1'){
            $sql .= " and propro.progpro_id is not null ";
            
        }
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    } 
       
       
       
       
       
     public function insertarProduccSacoParcial($proroll_id,$clasea,$telares,$laminado,$impresion,$conversion,$sacos_total,$sacos_totalb,$emp,$obs, $usuario_nickname) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROPRODUCCIONSACODET 
            (proroll_id,prosacodet_sacoa,prosacodet_sacotel, prosacodet_sacolam,prosacodet_sacoimp,prosacodet_sacoconv,prosacodet_total,prosacodet_totalb,prosacodet_operario,prosacodet_obs,usuario_creacion) 
                values ('$proroll_id','$clasea','$telares','$laminado','$impresion','$conversion','$sacos_total','$sacos_totalb','$emp','$obs','$usuario_nickname')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
         
public function sumaacumuladaSacos($proroll_id) { 
        $stmt = $this->objPdo->prepare("
select sum(prosacodet_total) as prosacodet_total, sum(prosacodet_totalb) as prosacodet_totalb,  sum(prosacodet_sacobast) as prosacodet_sacobast, proroll_id
 from PROPRODUCCIONSACODET where proroll_id = '$proroll_id' group by proroll_id
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
  public function listarProduccSacoDet($proroll_id) { 
        $stmt = $this->objPdo->prepare("
select * from PROPRODUCCIONSACODET WHERE eliminado = '0' and proroll_id='$proroll_id'
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }   
    
             public function ListProcBastillado($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "
select kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban ,cast (vec.fechaentrega as date ) fechaentrega
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso
,propro.progpro_siguienteproc,propro.fecha_atencion,roll.proroll_mtrs_total, roll.proroll_peso_total, roll.proroll_atendido, programado.progpro_id as programado_progpro_id,  CAST (  programado.progpro_fecprogramacion AS DATE) as programado_fecha

from PROPROGKANBANDET kandet
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join  " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped

INNER  JOIN PROPROGRAMACIONPROC  propro ON propro.progpro_kanban= kandet.prokandet_id

inner join PROPROGRAMACIONPROCDET proprodet on ( proprodet.progpro_id= propro.progpro_id and proprodet.eliminado= '0')
inner join PROPRODUCCIONROLLO roll on roll.progprodet_id= proprodet.progprodet_id

left join ( select  * from PROPROGRAMACIONPROC where progpro_proceso = '$procesos' ) programado on programado.progpro_kanban = propro.progpro_kanban



where kandet.estado = '0' and kandet.eliminado = '0' and propro.progpro_siguienteproc = '$procesos' AND
 ( CAST(propro.fecha_creacion AS DATE) >= '$ini' AND CAST( propro.fecha_creacion AS DATE)<='$fin')   and propro.progpro_atendido = '1'                    



";
        
        if($estado == '0'){
           $sql .= " and  programado.progpro_id is  null ";
           
        }elseif($estado == '1'){
            $sql .= " and  programado.progpro_id is not null ";
            
        }
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    } 
        
   
         public function ListInicProcBas($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "
 select propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido, proprodet.progprodet_id
,programado.*
from PROPROGRAMACIONPROC propro
INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped

left join ( 
select PROGRA.progpro_id as progpro_id_anterior, PROGRA.progpro_proceso, PROGRA.progpro_kanban, PROGRA.progpro_atendido, PROGRA.progpro_siguienteproc ,ROLL.proroll_mtrs_total AS saco_total, ROLL.proroll_peso_total as sacos_b
 from PROPROGRAMACIONPROC PROGRA
INNER JOIN PROPROGRAMACIONPROCDET PROGRADET ON (PROGRADET.progpro_id = PROGRA.progpro_id and PROGRADET.eliminado= '0')
INNER JOIN PROPRODUCCIONROLLO ROLL ON ROLL.progprodet_id = PROGRADET.progprodet_id
 where PROGRA.progpro_siguienteproc = '$procesos' and PROGRA.progpro_atendido = '1' and PROGRA.eliminado = '0'



 ) programado  ON programado.progpro_kanban = kandet.prokandet_id

LEFT JOIN PROPROGRAMACIONPROCDET proprodet on proprodet.progpro_id= propro.progpro_id

where propro.estado = '0' and propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and propro.progpro_proceso = '$procesos'


";
        
        if($estado == '2'){
           $sql .= " and ( proprodet.progprodet_fecha_ini is  null and  proprodet.progprodet_fecha_fin is null )";
           
        }elseif($estado == '0'){
            $sql .= " and ( proprodet.progprodet_fecha_ini is not null and  proprodet.progprodet_fecha_fin is null ) ";
            
        }elseif($estado == '1'){
            $sql .= " and ( proprodet.progprodet_fecha_ini is not null and  proprodet.progprodet_fecha_fin is not null ) ";
            
        }
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    

      public function listarMaqBastilladoras($are_id) { 
        $stmt = $this->objPdo->prepare("

select * from PROMGMAQUINA where are_id = '$are_id'
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
         public function insertarProduccSacoParcialBast($proroll_id,$clasea,$maquina,$claseb_bast,$sacos_total,$sacos_totalb,$emp,$obs, $usuario_nickname) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROPRODUCCIONSACODET 
            (proroll_id,prosacodet_sacoa,prosacodet_maq, prosacodet_sacobast,prosacodet_total,prosacodet_totalb,prosacodet_operario,prosacodet_obs,usuario_creacion) 
                values ('$proroll_id','$clasea','$maquina','$claseb_bast','$sacos_total','$sacos_totalb','$emp','$obs','$usuario_nickname')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
            public function ListaProcesosBast() { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
select * from PROTABLAGENDET
where tabgen_id = '19' and eliminado = '0' and tabgendet_id = '172'

    ");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    }
    
            public function CerraProduccSac($id,$usr,$totala, $totalB) { //producción 2020
        $stmt = $this->objPdo->prepare("
            update  PROPRODUCCIONROLLO 
            set proroll_atendido = '1',usuario_atendido= '$usr', proroll_mtrs_total = '$totala', proroll_peso_total= '$totalB'
                where proroll_id = '$id'
           ");
        $rows = $stmt->execute();
        return $rows;
    }         
    
     public function GuardarRegis($op,$kanban,$a, $b,$cantenfardado,$proroll_id,$usuario_nickname) {
        $div_entera_clasea = floor($a/$cantenfardado);
        $div_entera_claseb = floor($b/$cantenfardado);
        
        $resto_clasea= $a%$cantenfardado;
        $resto_claseb= $b%$cantenfardado;
        
        $kanbas = $kanban."/";
                
    //inicio clase A         
    $insertarregi = new kanban();
         if($div_entera_clasea >=1){
             for ($index = 1; $index <= $div_entera_clasea; $index++) {
                 //generacion de fardos en funcion del tamaño del fardo
            
                $insertarregi->insertarRegistroFardos($proroll_id, $op, $kanban, $cantenfardado, $cantenfardado, 'Clase A', $kanbas, $usuario_nickname, $usuario_nickname,'Total');
             
                
             }
             if( $resto_clasea>0){
				     $insertarregi->insertarRegistroFardos($proroll_id, $op, $kanban, $resto_clasea, $resto_clasea, 'Clase A', $kanbas, $usuario_nickname, $usuario_nickname,'Parcial');
			}
         }elseif($div_entera_clasea <= 0){
              $insertarregi->insertarRegistroFardos($proroll_id, $op, $kanban, $resto_clasea, $resto_clasea, 'Clase A', $kanbas, $usuario_nickname, $usuario_nickname,'Parcial');
         }
     //Fin clase A  
         
         
        //inicio clase B     
         if($div_entera_claseb >= 1){
             for ($index = 1; $index <= $div_entera_claseb; $index++) {
                 //generacion de fardos en funcion del tamaño del fardo
                 $insertarregi->insertarRegistroFardos($proroll_id, $op, $kanban, $cantenfardado, $cantenfardado, 'Clase B', $kanbas, $usuario_nickname, $usuario_nickname,'Total'); 
             }
             if($resto_claseb>0){
				$insertarregi->insertarRegistroFardos($proroll_id, $op, $kanban, $resto_claseb, $resto_claseb, 'Clase B', $kanbas, $usuario_nickname, $usuario_nickname,'Parcial');
         
			 }
          }elseif($div_entera_claseb <= 0){
              $insertarregi->insertarRegistroFardos($proroll_id, $op, $kanban, $resto_claseb, $resto_claseb, 'Clase B', $kanbas, $usuario_nickname, $usuario_nickname,'Parcial');
         }
     //Fin clase B 
         
     }
     
         public function insertarRegistroFardos($proroll_id,$prefila_op,$prefila_kanban, $prefila_cantidad_ini,$prefila_cantidad_fin,$prefila_tipo,$prefila_kanbas,$usuario_creacion,$usuario_modif,$prefila_tamanio) { //producción 2020
        $stmt = $this->objPdo->prepare("
        insert into   PROPRENSAFILAS 
        (proroll_id,prefila_op,prefila_kanban, prefila_cantidad_ini,prefila_cantidad_fin,prefila_tipo,prefila_kanbas,usuario_creacion,usuario_modif,prefila_tamanio) 
        values ('$proroll_id','$prefila_op','$prefila_kanban','$prefila_cantidad_ini','$prefila_cantidad_fin','$prefila_tipo','$prefila_kanbas','$usuario_creacion','$usuario_modif','$prefila_tamanio')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
      public function listarFilasGeneradas($rollo_id) { 
        $stmt = $this->objPdo->prepare("

select * from PROPRENSAFILAS where proroll_id = '$rollo_id' and eliminado ='0'
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    public function listarOps() { 
        $stmt = $this->objPdo->prepare("

select kan.* from PROPROGKANBAN kan 
inner join PROPEDIDOAPROB apro on apro.prodped_op = kan.prokan_nroped and (apro.prodped_tipaprob= '2')
where kan.estado = '0' and kan.eliminado = '0' and apro.prodped_estado= '0'
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
       public function ajaxGetDatGen($op) { 
        $stmt = $this->objPdo->prepare("

select ved.nroped, ved.codart, ved.desart,vedc.razonsocial, vedc.fechaentrega,ved.cantped, dise.prodidet_id, disedet.prodidet_url
from " . $_SESSION['server_vinculado'] . "vepedidod ved 
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vedc on vedc.nroped = ved.nroped
inner join 
(select * from PROPEDIDOAPROB
where prodped_op= '$op' and prodped_tipaprob= '2' and eliminado= '0'
) dise on dise.prodped_op= ved.nroped
left join PRODISENOSDET disedet  on disedet.prodidet_id = dise.prodidet_id

where ved.nroped = '$op'

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
       public function ajaxGetResumen($op) { 
        $stmt = $this->objPdo->prepare("

select tabla1.total_sacos,tabla1.prefila_op, tabla1.prefila_tipo, tabla2.pendiente_enfardar
from
(SELECT SUM(prefila_cantidad_ini) AS total_sacos, SUM(prefila_cantidad_fin) as pendiente_enfardar, prefila_op, prefila_tipo
FROM PROPRENSAFILAS
WHERE prefila_op= '$op' AND estado = '0' and eliminado = '0' and prefila_tamanio = 'Total'
group by  prefila_op, prefila_tipo
)tabla1
inner join 
(
SELECT SUM(prefila_cantidad_ini) AS total_sacos, SUM(prefila_cantidad_fin) as pendiente_enfardar, prefila_op, prefila_tipo
FROM PROPRENSAFILAS
WHERE prefila_op= '$op' AND estado = '0' and eliminado = '0' and prefila_tamanio = 'Parcial'
group by  prefila_op, prefila_tipo
)tabla2 on tabla1.prefila_op= tabla2.prefila_op and (tabla1.prefila_tipo = tabla2.prefila_tipo)


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
        public function ajaxGetPuchosActivos($op) { 
        $stmt = $this->objPdo->prepare("
SELECT prefila_cantidad_ini, prefila_cantidad_fin, prefila_op, prefila_tipo
FROM PROPRENSAFILAS
WHERE prefila_op= '$op' AND estado = '0' and prefila_tamanio = 'Parcial' and eliminado = '0'

ORDER BY prefila_tipo,prefila_cantidad_fin desc


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
          public function ajaxGetEnfardadoTotal($op) { 
        $stmt = $this->objPdo->prepare("
SELECT FIL.*, VD.codart
FROM PROPRENSAFILAS fil
inner join " . $_SESSION['server_vinculado'] . "VEPEDIDOD VD ON VD.nroped = fil.prefila_op
WHERE prefila_op= '$op' AND estado = '0' and prefila_tamanio = 'Total' and eliminado = '0'

ORDER BY prefila_tipo,prefila_cantidad_fin desc

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
         public function ajaxGetPuchosActivosXtipo($op,$tipo) { 
        $stmt = $this->objPdo->prepare("
SELECT *
FROM PROPRENSAFILAS
WHERE prefila_op= '$op' AND estado = '0' and prefila_tamanio = 'Parcial' and prefila_tipo = '$tipo'

ORDER BY prefila_tipo,prefila_cantidad_fin desc


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
    
       public function listafila($idfila) { 
        $stmt = $this->objPdo->prepare("

SELECT * FROM PROPRENSAFILAS where prefila_id = '$idfila'
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }   
    
                public function UpdatefilasAgruparTotal($id,$usr_name,$valor_actual) { //producción 2020
        $stmt = $this->objPdo->prepare("
         
update PROPRENSAFILAS set prefila_cantidad_fin = '$valor_actual', estado = '1' , usuario_modif = '$usr_name', fecha_modif = SYSDATETIME() 
where prefila_id = '$id'
            
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
                    public function UpdatefilasAgruparParcial($id,$usr_name,$valor_actual) { //producción 2020
        $stmt = $this->objPdo->prepare("
         
update PROPRENSAFILAS set prefila_cantidad_fin = '$valor_actual', estado = '0' , usuario_modif = '$usr_name', fecha_modif = SYSDATETIME() 
where prefila_id = '$id'
            
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
             public function insertarRegistroFardosAgrupados($proroll_id,$prefila_op,$prefila_kanban, $prefila_cantidad_ini,$prefila_cantidad_fin,$prefila_tipo,$prefila_kanbas,$usuario_creacion,$usuario_modif,$prefila_tamanio) { //producción 2020
        $stmt = $this->objPdo->prepare("
        insert into   PROPRENSAFILAS 
        (proroll_id,prefila_op,prefila_kanban, prefila_cantidad_ini,prefila_cantidad_fin,prefila_tipo,prefila_kanbas,usuario_creacion,usuario_modif,prefila_tamanio) 
        values ('$proroll_id','$prefila_op','$prefila_kanban','$prefila_cantidad_ini','$prefila_cantidad_fin','$prefila_tipo','$prefila_kanbas','$usuario_creacion','$usuario_modif','$prefila_tamanio')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
                      public function UpdatefilasRegisProducc($prefila_id,$peso,$usuario_nickname,$codartfin) { //producción 2020
        $stmt = $this->objPdo->prepare("
         
update PROPRENSAFILAS set prefila_peso = '$peso', atendido = '1' , usuario_modif = '$usuario_nickname', fecha_modif = SYSDATETIME() , codartfin = '$codartfin'
where prefila_id = '$prefila_id'
            
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
    
    
      public function consultarDatosEtiqueta($id) { 
        $stmt = $this->objPdo->prepare("
select tablafin2.* , artic.descripcion as descripcionfin, artic.codalt as codaltfin
from  ( 

select tablafin.*
,case when tablafin.codartfin is null then  tablafin.codart  else   tablafin.codartfin  end as codigofin

from
		(
		
		SELECT * , convert(varchar,FIL.fecha_modif,108) as fec_turno 
		FROM PROPRENSAFILAS FIL
		INNER JOIN (
		select ved.nroped, ved.codart, ved.desart,vedc.razonsocial, vedc.fechaentrega,ved.cantped, dise.prodidet_id, disedet.prodidet_url,  ART.codalt
		from " . $_SESSION['server_vinculado'] . "vepedidod ved 
		inner join " . $_SESSION['server_vinculado'] . "vepedidoc vedc on vedc.nroped = ved.nroped
		 inner join  " . $_SESSION['server_vinculado'] . "ALART ART ON ART.codart = ved.codart
		inner join 
		(select * from PROPEDIDOAPROB
		where  prodped_tipaprob= '2' and eliminado= '0'
		) dise on dise.prodped_op= ved.nroped
		left join PRODISENOSDET disedet  on disedet.prodidet_id = dise.prodidet_id

		)TABLA01 ON TABLA01.nroped= FIL.prefila_op 
		WHERE FIL.prefila_id = '$id'
		)tablafin
		)tablafin2

		inner join " . $_SESSION['server_vinculado'] . "ALART artic on artic.codart = tablafin2.codigofin


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    } 
    
     public function consultarTurno() { 
        $stmt = $this->objPdo->prepare("
SELECT * FROM PROADMTURNOS

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
                  public function listarTiempoPendientesV02($codart,$area) {
        $stmt = $this->objPdo->prepare("
SELECT TABLA04.* , FECDIS.fecdispmaq_fechadisp FROM (
select * from (
select maq.maq_id from PROARTSEMIMAQUINA artmaq
inner join PROMGMAQUINA maq on maq.maq_id = artmaq.maq_id
inner join PROARTSEMITERMINADO semi on semi.artsemi_id =  artmaq.artsemi_id
where semi.form_id = '$codart' and maq.are_id = '$area' 
)maqproducto
left join (


select tabla02.movdismaq_idmaq, CONCAT(tabla02.horas,':', tabla02.minutos, ':',tabla02.segundos) as tiempo_pendiente from 
(
select  movdismaq_idmaq,

(timeseg_pendi ) / (60 * 60) AS horas,
	(timeseg_pendi % ( 60 * 60))/ 60 AS minutos,
	((timeseg_pendi % (60 * 60))) % 60 AS segundos
from (
select 
  SUM(
        DATEPART(SECOND, cast(movdismaq_tiempo as time)) + 
                60 * DATEPART(MINUTE, cast(movdismaq_tiempo as time)) + 
                3600 * DATEPART(HOUR, cast(movdismaq_tiempo as time)) 
        ) timeseg_pendi ,movdismaq_idmaq
from PROMOVDISPONIBILIDADMAQ
WHERE movdismaq_atendido = '0' AND movdismaq_fecfin < GETDATE()
group by movdismaq_idmaq
)tabla01)tabla02


)tiempoadicional on tiempoadicional.movdismaq_idmaq =maqproducto.maq_id)TABLA04
LEFT JOIN PROFECHADISPMAQUINA FECDIS ON FECDIS.fecdispmaq_codmaq = TABLA04.maq_id
where FECDIS.fecdispmaq_fechadisp <=getdate()
");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    }

                        public function listarTiempoPendientesV03($codart,$area) {
        $stmt = $this->objPdo->prepare("
SELECT TABLA04.* , FECDIS.fecdispmaq_fechadisp FROM (
select * from (
select maq.maq_id from PROARTSEMIMAQUINA artmaq
inner join PROMGMAQUINA maq on maq.maq_id = artmaq.maq_id
inner join PROARTSEMITERMINADO semi on semi.artsemi_id =  artmaq.artsemi_id
where semi.form_id = '$codart' and maq.are_id = '$area' 
)maqproducto
left join (


select tabla02.movdismaq_idmaq, CONCAT(tabla02.horas,':', tabla02.minutos, ':',tabla02.segundos) as tiempo_pendiente from 
(
select  movdismaq_idmaq,

(timeseg_pendi ) / (60 * 60) AS horas,
	(timeseg_pendi % ( 60 * 60))/ 60 AS minutos,
	((timeseg_pendi % (60 * 60))) % 60 AS segundos
from (
select 
		  SUM(
     replace (  ( SUBSTRING(movdismaq_tiempo, CHARINDEX(':',movdismaq_tiempo)+4,2)),':','') + 
                60 * replace ((SUBSTRING(movdismaq_tiempo, CHARINDEX(':',movdismaq_tiempo)+1,2)),':','') + 
                3600 * replace ((SUBSTRING(movdismaq_tiempo,1, CHARINDEX(':',movdismaq_tiempo)-1)) , ':','')
        ) timeseg_pendi ,movdismaq_idmaq
from PROMOVDISPONIBILIDADMAQ
WHERE movdismaq_atendido = '0' AND movdismaq_fecfin < GETDATE()
group by movdismaq_idmaq
)tabla01)tabla02


)tiempoadicional on tiempoadicional.movdismaq_idmaq =maqproducto.maq_id)TABLA04
LEFT JOIN PROFECHADISPMAQUINA FECDIS ON FECDIS.fecdispmaq_codmaq = TABLA04.maq_id
where FECDIS.fecdispmaq_fechadisp <=getdate()
");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    }

    
                    public function listarTiempoPendientes($codart,$area) {
        $stmt = $this->objPdo->prepare("
SELECT TABLA04.* , FECDIS.fecdispmaq_fechadisp 

FROM (
										select * from (
										select maq.maq_id from PROARTSEMIMAQUINA artmaq
										inner join PROMGMAQUINA maq on maq.maq_id = artmaq.maq_id
										inner join PROARTSEMITERMINADO semi on semi.artsemi_id =  artmaq.artsemi_id
										where semi.form_id = '$codart' and maq.are_id = '$area' 
										)maqproducto
							left join (


									select tabla02.movdismaq_idmaq, CONCAT(tabla02.horas,':', tabla02.minutos, ':',tabla02.segundos) as tiempo_pendiente from 
									(
														SELECT TABLAHORA.movdismaq_idmaq,
														CASE WHEN LEN(TABLAHORA.segundos)=1 then CONCAT('0', cast ( TABLAHORA.segundos as varchar(5) )) else TABLAHORA.segundos end as segundos,
														CASE WHEN LEN(TABLAHORA.minutos)=1 then CONCAT('0', cast ( TABLAHORA.minutos as varchar (5))) else TABLAHORA.minutos end as minutos,
														TABLAHORA.horas
			
														FROM(	
																select  tabla01.movdismaq_idmaq,

																(tabla01.timeseg_pendi ) / (60 * 60) AS horas,
																cast (	((tabla01.timeseg_pendi % ( 60 * 60))/ 60) as varchar(5)) AS minutos,
															 cast(		(((tabla01.timeseg_pendi % (60 * 60))) % 60) as varchar (5)) AS segundos
																from (
																		select 
																				  SUM(
																			 replace (  ( SUBSTRING(movdismaq_tiempo, CHARINDEX(':',movdismaq_tiempo)+4,2)),':','') + 
																						60 * replace ((SUBSTRING(movdismaq_tiempo, CHARINDEX(':',movdismaq_tiempo)+1,2)),':','') + 
																						3600 * replace ((SUBSTRING(movdismaq_tiempo,1, CHARINDEX(':',movdismaq_tiempo)-1)) , ':','')
																				) timeseg_pendi ,movdismaq_idmaq
																		from PROMOVDISPONIBILIDADMAQ
																		WHERE movdismaq_atendido = '0' AND movdismaq_fecfin < GETDATE()
																		group by movdismaq_idmaq
																)tabla01
															)TABLAHORA
									)tabla02


							)tiempoadicional on tiempoadicional.movdismaq_idmaq =maqproducto.maq_id
		)TABLA04
LEFT JOIN PROFECHADISPMAQUINA FECDIS ON FECDIS.fecdispmaq_codmaq = TABLA04.maq_id
where FECDIS.fecdispmaq_fechadisp <=getdate() and TABLA04.movdismaq_idmaq is not null


");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    }

          

            public function listarTiempoPendientesV01($codart,$area) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."  select * from PROMOVDISPONIBILIDADMAQ where movdismaq_idkanban='$id' and movdismaq_estado = '0'
        $stmt = $this->objPdo->prepare("
SELECT TABLA02.* , FECDIS.fecdispmaq_fechadisp FROM (
select * from (
select maq.maq_id from PROARTSEMIMAQUINA artmaq
inner join PROMGMAQUINA maq on maq.maq_id = artmaq.maq_id
inner join PROARTSEMITERMINADO semi on semi.artsemi_id =  artmaq.artsemi_id
where semi.form_id = '$codart' and maq.are_id = '$area'
)maqproducto
left join (
SELECT SUM(movdismaq_tiempo) AS tiempo_pendiente, movdismaq_idmaq FROM PROMOVDISPONIBILIDADMAQ
WHERE movdismaq_atendido = '0' AND movdismaq_fecfin < GETDATE()
GROUP BY movdismaq_idmaq
)tiempoadicional on tiempoadicional.movdismaq_idmaq =maqproducto.maq_id)TABLA02
LEFT JOIN PROFECHADISPMAQUINA FECDIS ON FECDIS.fecdispmaq_codmaq = TABLA02.maq_id
where FECDIS.fecdispmaq_fechadisp <=getdate()
");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    }

    
    
        public function consultarKanbanManual() { 
        $stmt = $this->objPdo->prepare("
select kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban

from PROPROGKANBANDET kandet
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join  " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped



where kandet.estado = '0' and kandet.eliminado = '0' AND kandet.prokandet_manual= '1'

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
     public function ConsultarKanban() { 
        $stmt = $this->objPdo->prepare("
select * from PROPROGKANBAN where  eliminado = '0' and estado = '0'

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
         public function ConsultarUltimoKanb($op) { 
        $stmt = $this->objPdo->prepare("
select top 1 det.* , kan.prokan_cantkanban, kan.prokan_mtrs_totales,kan.prokan_kanb_manual
from PROPROGKANBANDET det 
inner join PROPROGKANBAN kan on kan.prokan_nroped = det.prokandet_nroped
 where det.prokandet_nroped = '$op'   
 order by det.prokandet_items desc

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
    
           public function InsertKanbanManual($opedido,$nuevo_items,$mtrslineales,$usuario_nickname,$artsemi_id,$prokandet_tipo) { //producción 2020
          $stmt = $this->objPdo->prepare("
        insert into   PROPROGKANBANDET 
        (prokandet_nroped,prokandet_items,prokandet_mtrs, usuario_creacion,prokandet_manual,artsemi_id,prokandet_tipo) 
        values ('$opedido','$nuevo_items','$mtrslineales','$usuario_nickname','1','$artsemi_id','$prokandet_tipo')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
    
             public function UpdateTblkanban($opedido,$nuevo_prokan_cantkanban,$nuevo_prokan_mtrs_totales,$nuevo_prokan_kanb_manual) { //producción 2020
        $stmt = $this->objPdo->prepare("
         
update PROPROGKANBAN set prokan_cantkanban = '$nuevo_prokan_cantkanban', prokan_mtrs_totales = '$nuevo_prokan_mtrs_totales' , prokan_kanb_manual = '$nuevo_prokan_kanb_manual'
where prokan_nroped = '$opedido'
            
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
    
    
    
    
    
    
        public function ConsultarKanbanDet($op) { 
        $stmt = $this->objPdo->prepare("

select *, prokandet_id from PROPROGKANBANDET where  eliminado = '0' and estado = '0' AND prokandet_nroped = '$op'

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
          public function ConsultarTrandferenciaKanb() { 
        $stmt = $this->objPdo->prepare("

SELECT * FROM PROTRANSKANBAN WHERE estado = '0' and eliminado = '0'

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
      public function InsertTransfkanb($opedidoorig,$kanban_id,$opedidodest,$usuario_nickname) { //producción 2020
          $stmt = $this->objPdo->prepare("
        insert into   PROTRANSKANBAN 
        (transkanb_op_origen,transkanb_kanb_origen,transkanb_op_destino, usuario_creacion) 
        values ('$opedidoorig','$kanban_id','$opedidodest','$usuario_nickname')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
             public function UpdateTblkanbanPedido($opedidodest,$kanban_id,$artsemi_id) { //producción 2020
        $stmt = $this->objPdo->prepare("
update PROPROGKANBANDET set prokandet_nroped= '$opedidodest',  artsemi_id = '$artsemi_id'  where prokandet_id = '$kanban_id'
            
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
      public function ConsultarBasePlanaOP($op) { 
        $stmt = $this->objPdo->prepare("
select VED.nroped , VED.codart, VED.desart, ARTSEMI.artsemi_id, ARTSEMI.form_id ,tabla.*
from " . $_SESSION['server_vinculado'] . "VEPEDIDOD VED
INNER JOIN PROARTSEMITERMINADO ARTSEMI ON ARTSEMI.form_id= VED.codart
LEFT JOIN  (
select PivotTable.artsemi_id artsemi_id2, PivotTable.[21] as tipacabado, PivotTable.[104] as codbaseplana, PivotTable.[105] as largoparche
from (
select  artsemi_id,itemcaracsemi_id, 
case when valitemcarac_valor is null then 0 
when valitemcarac_valor = '' then 0 
when  TRY_CAST ( valitemcarac_valor as decimal(15,2))  is not null  then cast ( valitemcarac_valor as decimal(15,2))
else 0
 end as decimal1  from PROVALITEMSCARACT
where  ( itemcaracsemi_id = '21' or itemcaracsemi_id= '104' or itemcaracsemi_id= '105') --and artsemi_id = '113' 
) as tabla01 pivot(avg(decimal1) for itemcaracsemi_id in ([21],[104],[105]) )as PivotTable
) tabla ON tabla.artsemi_id2 = ARTSEMI.artsemi_id

WHERE VED.nroped = '$op' 


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
    
                      public function BuscarItemsduplicados($nroped,$items) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("

 select * from PROPROGKANBANDET where prokandet_items  = '$items' and prokandet_nroped = '$nroped' and  prokandet_telar = '0'

    ");
        $stmt->execute();
        $maq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $maq;
    }
    
    
      public function listarProduccMiniRoll($proroll_id) { 
        $stmt = $this->objPdo->prepare("
select * from PROPRODUCCIONROLLPARCH WHERE eliminado = '0' AND estado = '0' and proroll_id='$proroll_id'
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
        public function insertarProduccMiniRoll($proroll_id,
        $prorollparch_a,
        $prorollparch_b,
        $prorollparch_mtrscort,
        $prorollparch_mtrstotal,
		$prorollparch_mtrstotalb,
		$prorollparch_operario,
		$prorollparch_obs,
		
		$usuario_nickname) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROPRODUCCIONROLLPARCH 
            (proroll_id,
            prorollparch_a,
            prorollparch_b, 
            prorollparch_mtrscort,
            prorollparch_mtrstotal,
            prorollparch_mtrstotalb, 
            prorollparch_operario,
            prorollparch_obs,
           
            usuario_creacion) 
                values ('$proroll_id',
                '$prorollparch_a',
                '$prorollparch_b',
                '$prorollparch_mtrscort',
                '$prorollparch_mtrstotal',
                '$prorollparch_mtrstotalb',
                 '$prorollparch_operario',
                 '$prorollparch_obs',
                
                 '$usuario_nickname')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    public function sumaacumuladaMtrsRollo($proroll_id) { 
        $stmt = $this->objPdo->prepare("
select sum(prorollparch_mtrstotal) as prorollparch_mtrstotal, sum(prorollparch_mtrstotalb) as prorollparch_mtrstotalb,  proroll_id
 from PROPRODUCCIONROLLPARCH where proroll_id = '$proroll_id' group by proroll_id
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
       public function ConsultarArtsemiXop($op) { 
        $stmt = $this->objPdo->prepare("

 select tabla01.*, semi.artsemi_descripcion from 
 (
 select distinct artsemi_id, prokandet_tipo from PROPROGKANBANDET
 where prokandet_nroped ='$op') tabla01
 inner join PROARTSEMITERMINADO semi  on semi.artsemi_id = tabla01.artsemi_id

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
       public function ConsultarArtsemiTipo($artsemi_id) { 
        $stmt = $this->objPdo->prepare("

 select artsemi_id, tipsem_id from PROARTSEMITERMINADO where  artsemi_id = '$artsemi_id'

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
  
   public function ConsultarMaqXarea($are_id) { 
        $stmt = $this->objPdo->prepare("

SELECT * FROM PROMGMAQUINA WHERE are_id = '$are_id' AND eliminado = '0' AND maq_estado = '0'

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

  
public function calcular_tiempo_hor($hora1, $hora2) {
	 date_default_timezone_set('America/Lima');
    $separar[1] = explode(':', $hora1);
    $separar[2] = explode(':', $hora2);

    $total_minutos_trasncurridos[1] = ($separar[1][0] * 60) + $separar[1][1];
    $total_minutos_trasncurridos[2] = ($separar[2][0] * 60) + $separar[2][1];
    $total_minutos_trasncurridos = $total_minutos_trasncurridos[1] - $total_minutos_trasncurridos[2];
    if ($total_minutos_trasncurridos <= 59){
        $HORA_TRANSCURRIDA='0';
        return($HORA_TRANSCURRIDA);
    } elseif ($total_minutos_trasncurridos > 59) {
        $HORA_TRANSCURRIDA = floor($total_minutos_trasncurridos / 60);
        if ($HORA_TRANSCURRIDA <= 9)
            $HORA_TRANSCURRIDA = '0' . $HORA_TRANSCURRIDA;
        $MINUITOS_TRANSCURRIDOS = $total_minutos_trasncurridos % 60;
        if ($MINUITOS_TRANSCURRIDOS <= 9)
            $MINUITOS_TRANSCURRIDOS = '0' . $MINUITOS_TRANSCURRIDOS;
        return ($HORA_TRANSCURRIDA);
    }
}

public function calcular_tiempo_min($hora1, $hora2) {
	date_default_timezone_set('America/Lima');
    $separar[1] = explode(':', $hora1);
    $separar[2] = explode(':', $hora2);

    $total_minutos_trasncurridos[1] = ($separar[1][0] * 60) + $separar[1][1];
    $total_minutos_trasncurridos[2] = ($separar[2][0] * 60) + $separar[2][1];
    $total_minutos_trasncurridos = $total_minutos_trasncurridos[1] - $total_minutos_trasncurridos[2];
    if ($total_minutos_trasncurridos <= 59){
        return($total_minutos_trasncurridos);
    }elseif ($total_minutos_trasncurridos > 59) {
        $HORA_TRANSCURRIDA =floor($total_minutos_trasncurridos / 60);
        if ($HORA_TRANSCURRIDA <= 9)
            $HORA_TRANSCURRIDA = '0' . $HORA_TRANSCURRIDA;
        $MINUITOS_TRANSCURRIDOS = $total_minutos_trasncurridos % 60;
        if ($MINUITOS_TRANSCURRIDOS <= 9)
            $MINUITOS_TRANSCURRIDOS = '0' . $MINUITOS_TRANSCURRIDOS;
        return ( $MINUITOS_TRANSCURRIDOS);
    }
}
  
  
  
              public function ConsultarProgProcesXopXitem($proceso, $op, $items) { 
        $stmt = $this->objPdo->prepare("
SELECT PROGPROC.*,KANDET.prokandet_items, KANDET.prokandet_nroped FROM PROPROGRAMACIONPROC PROGPROC
INNER JOIN PROPROGKANBANDET KANDET ON KANDET.prokandet_id = PROGPROC.progpro_kanban
WHERE PROGPROC.progpro_proceso = '$proceso' AND   KANDET.prokandet_nroped = '$op'  and KANDET.prokandet_items = '$items'

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
        public function ConsultarProgRollXopXitem($proceso, $op, $items) { 
        $stmt = $this->objPdo->prepare("
select * from PROPROGRAMACIONPROCDET   progprodet
inner join PROPROGRAMACIONPROC progproc on progproc.progpro_id =progprodet.progpro_id
inner join PROPRODUCCIONROLLO proroll on proroll.progprodet_id = progprodet.progprodet_id
inner join PROPROGKANBANDET kandet  on kandet.prokandet_id = progproc.progpro_kanban

where  PROGPROC.progpro_proceso = '$proceso' AND   KANDET.prokandet_nroped = '$op' and KANDET.prokandet_items = '$items'

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    public function cabecerakanban($prokandet_id) { 
        $stmt = $this->objPdo->prepare("
select kandet.* ,kan.prokan_id, kan.prokan_larg_corte, kan.prokan_porcent_b, kan.prokan_mtrs_totales,kan.prokan_cantkanban, kan.prokan_mtrs_totalparche
,kan.prokan_cantkanbanparche,
vc.razonsocial,vd.codart, vd.desart,VD.cantped, semi.artsemi_descripcion,vc.docref, comen.procoment_mensaje,maquina.nombre
 from PROPROGKANBANDET kandet
inner join PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "VEPEDIDOC vc on vc.nroped = kan.prokan_nroped and vc.tipped = 'VAB'
inner join " . $_SESSION['server_vinculado'] . "VEPEDIDOd vd on vd.nroped = vc.nroped
inner join PROARTSEMITERMINADO semi on semi.form_id = vd.codart and (semi.tipsem_id ='2' or semi.tipsem_id = '8' ) and semi.form_id != '-1'
inner join (
select maq_id, maq_nombre,  SUBSTRING(maq_nombre,1,CHARINDEX('-' ,maq_nombre)-1) as nombre
from PROMGMAQUINA where are_id = '4'

) as maquina on maquina.maq_id = kandet.prokandet_telar
left join PROCOMENTARIOS comen on comen.procoment_id_doc= vc.nroped and (comen.procoment_id_usuario = '1' or comen.procoment_id_usuario='2')
where kandet.prokandet_id = '$prokandet_id'

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
     public function cuerpokanban($codart) { 
        $stmt = $this->objPdo->prepare("
        select tablafin.artsemi_id, tablafin.itemcaracsemi_id,tablafin.itemcaracsemi_descripcion, tablafin.valor --*
from (
select tablacombo.* from (
select tabla01.*,
case when  tabla02.nombre is null then '' else  tabla02.nombre end as valor
  from (
SELECT VAL.*, ITEM.itemcaracsemi_descripcion, item.itemcaracsemi_tipodato, ITEM.itemcaracsemi_tabla
,ITEM.itemcaracsemi_tabla_id, ITEM.itemcaracsemi_tabla_descripcion 
FROM PROVALITEMSCARACT VAL
INNER JOIN PROITEMCARACTSEMITERMINADO ITEM ON ITEM.itemcaracsemi_id = VAL.itemcaracsemi_id
WHERE artsemi_id = '$codart' and itemcaracsemi_tipodato = '_combo') tabla01
left join 
(


select artsemi_id  as codigo, artsemi_descripcion as nombre,'artsemi_id' as tipotabla from PROARTSEMITERMINADO where tipsem_id = '1' or tipsem_id = '8'
union all
select col_id  as codigo, col_titulo as nombre,'col_id' as tipotabla from PROCOLORES
union all
select colimp_id  as codigo, colimp_nombre as nombre,'colimp_id' as tipotabla from PROCOLORESIMP
union all
select form_id  as codigo,form_identificacion as nombre,'form_id' as tipotabla from PROFORMULACION
union all
select prodi_id  as codigo,prodi_nombre as nombre, 'prodi_id' as tipotabla from PRODISENOS
union all
select tabgendet_id as codigo, tabgendet_nombre as nombre,'tabgendet_id' as tipotabla from PROTABLAGENDET
union all
select tipuso_id as codigo,tipuso_descripcion as nombre,'tipuso_id' as tipotabla from PROTIPOUSO
union all
select '-1' as codigo, '#' as nombre, '#' as tipotabla
) tabla02

on tabla02.tipotabla= tabla01.itemcaracsemi_tabla_id and tabla02.codigo= tabla01.valitemcarac_valor --and tabla01.itemcaracsemi_tipodato = '_combo'
)tablacombo
union all
SELECT VAL.*, ITEM.itemcaracsemi_descripcion, item.itemcaracsemi_tipodato, ITEM.itemcaracsemi_tabla
,ITEM.itemcaracsemi_tabla_id, ITEM.itemcaracsemi_tabla_descripcion, VAL.valitemcarac_valor as valor

FROM PROVALITEMSCARACT VAL
INNER JOIN PROITEMCARACTSEMITERMINADO ITEM ON ITEM.itemcaracsemi_id = VAL.itemcaracsemi_id
WHERE artsemi_id = '$codart' and itemcaracsemi_tipodato = '_caja'
)tablafin
order by  tablafin.itemcaracsemi_id
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
       public function caraccintas($descrip) { 
        $stmt = $this->objPdo->prepare("
   select  tablafin.artsemi_id, tablafin.itemcaracsemi_id,tablafin.itemcaracsemi_descripcion, tablafin.valor --*
from (
select tablacombo.* from (
select tabla01.*,
case when  tabla02.nombre is null then '' else  tabla02.nombre end as valor
  from (
SELECT VAL.*, ITEM.itemcaracsemi_descripcion, item.itemcaracsemi_tipodato, ITEM.itemcaracsemi_tabla
,ITEM.itemcaracsemi_tabla_id, ITEM.itemcaracsemi_tabla_descripcion--, semi.artsemi_descripcion
 FROM PROVALITEMSCARACT VAL
INNER JOIN PROITEMCARACTSEMITERMINADO ITEM ON ITEM.itemcaracsemi_id = VAL.itemcaracsemi_id
inner join PROARTSEMITERMINADO  semi  on semi.artsemi_id = VAL.artsemi_id
WHERE semi.artsemi_descripcion = '$descrip' and itemcaracsemi_tipodato = '_combo' and semi.artsemi_estado='0') tabla01
left join 
(


select artsemi_id  as codigo, artsemi_descripcion as nombre,'artsemi_id' as tipotabla from PROARTSEMITERMINADO where tipsem_id = '1' or tipsem_id = '8'
union all
select col_id  as codigo, col_titulo as nombre,'col_id' as tipotabla from PROCOLORES
union all
select colimp_id  as codigo, colimp_nombre as nombre,'colimp_id' as tipotabla from PROCOLORESIMP
union all
select form_id  as codigo,form_identificacion as nombre,'form_id' as tipotabla from PROFORMULACION
union all
select prodi_id  as codigo,prodi_nombre as nombre, 'prodi_id' as tipotabla from PRODISENOS
union all
select tabgendet_id as codigo, tabgendet_nombre as nombre,'tabgendet_id' as tipotabla from PROTABLAGENDET
union all
select tipuso_id as codigo,tipuso_descripcion as nombre,'tipuso_id' as tipotabla from PROTIPOUSO
union all
select '-1' as codigo, '#' as nombre, '#' as tipotabla
) tabla02

on tabla02.tipotabla= tabla01.itemcaracsemi_tabla_id and tabla02.codigo= tabla01.valitemcarac_valor --and tabla01.itemcaracsemi_tipodato = '_combo'
)tablacombo
union all
SELECT VAL.*, ITEM.itemcaracsemi_descripcion, item.itemcaracsemi_tipodato, ITEM.itemcaracsemi_tabla
,ITEM.itemcaracsemi_tabla_id, ITEM.itemcaracsemi_tabla_descripcion, VAL.valitemcarac_valor as valor
--, semi.artsemi_descripcion
FROM PROVALITEMSCARACT VAL
INNER JOIN PROITEMCARACTSEMITERMINADO ITEM ON ITEM.itemcaracsemi_id = VAL.itemcaracsemi_id
inner join PROARTSEMITERMINADO  semi  on semi.artsemi_id = VAL.artsemi_id
WHERE semi.artsemi_descripcion = '$descrip' and itemcaracsemi_tipodato = '_caja' and semi.artsemi_estado='0'
)tablafin
order by  tablafin.itemcaracsemi_id

    
       
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
        public function cabecerakanbanTotal($op) { 
        $stmt = $this->objPdo->prepare("
select kandet.* ,kan.prokan_id, kan.prokan_larg_corte, kan.prokan_porcent_b, kan.prokan_mtrs_totales,kan.prokan_cantkanban, kan.prokan_mtrs_totalparche
,kan.prokan_cantkanbanparche,
vc.razonsocial,vd.codart, vd.desart,VD.cantped, semi.artsemi_descripcion,vc.docref, comen.procoment_mensaje,maquina.nombre
 from PROPROGKANBANDET kandet
inner join PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "VEPEDIDOC vc on vc.nroped = kan.prokan_nroped and vc.tipped = 'VAB'
inner join " . $_SESSION['server_vinculado'] . "VEPEDIDOd vd on vd.nroped = vc.nroped
inner join PROARTSEMITERMINADO semi on semi.form_id = vd.codart and (semi.tipsem_id ='2' or semi.tipsem_id = '8' ) and semi.form_id != '-1'
inner join (
select maq_id, maq_nombre,  SUBSTRING(maq_nombre,1,CHARINDEX('-' ,maq_nombre)-1) as nombre
from PROMGMAQUINA where are_id = '4'

) as maquina on maquina.maq_id = kandet.prokandet_telar

left join PROCOMENTARIOS comen on comen.procoment_id_doc= vc.nroped and (comen.procoment_id_usuario = '1' or comen.procoment_id_usuario='2')
where kandet.prokandet_nroped = '$op'  and kandet.prokandet_tipo = 'saco' and kandet.prokandet_telar is not null

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
   
      public function cabecerakanbanXmaq($op) { 
        $stmt = $this->objPdo->prepare("
select kandet.* ,kan.prokan_id, kan.prokan_larg_corte, kan.prokan_porcent_b, kan.prokan_mtrs_totales,kan.prokan_cantkanban, kan.prokan_mtrs_totalparche
,kan.prokan_cantkanbanparche,
vc.razonsocial,vd.codart, vd.desart,VD.cantped, vc.docref, comen.procoment_mensaje,maquina.nombre,artic.artsemi_descripcion  ,semi.artsemi_descripcion,artic.artsemi_descripcion as nombresemi

 from PROPROGKANBAN kan

 inner join ( select distinct prokandet_telar, prokandet_nroped,prokandet_tipo,artsemi_id from  PROPROGKANBANDET where prokandet_nroped = '$op' ) as kandet on kandet.prokandet_nroped = kan.prokan_nroped

inner join " . $_SESSION['server_vinculado'] . "VEPEDIDOC vc on vc.nroped = kan.prokan_nroped and vc.tipped = 'VAB'
inner join " . $_SESSION['server_vinculado'] . "VEPEDIDOd vd on vd.nroped = vc.nroped
inner join PROARTSEMITERMINADO semi on semi.form_id = vd.codart and (semi.tipsem_id ='2' or semi.tipsem_id = '8' ) and semi.form_id != '-1'
inner join PROARTSEMITERMINADO artic on artic.artsemi_id = kandet.artsemi_id
inner join (
select maq_id, maq_nombre,  SUBSTRING(maq_nombre,1,CHARINDEX('-' ,maq_nombre)-1) as nombre
from PROMGMAQUINA where are_id = '4'

)  maquina on maquina.maq_id = kandet.prokandet_telar

left join PROCOMENTARIOS comen on comen.procoment_id_doc= vc.nroped and (comen.procoment_id_usuario = '1' or comen.procoment_id_usuario='2')
where kandet.prokandet_nroped = '$op' and kandet.prokandet_telar is not null



    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
        public function UpdateEnviarPrensa ($id) { //producción 2020
        $stmt = $this->objPdo->prepare("
            update  PROPRODUCCIONSACODET 
            set estado =  '1'
                where prosacodet_id = '$id'
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
   
     public function ConsultarpendientesaPrensa($proroll_id) { 
        $stmt = $this->objPdo->prepare("
select * from PROPRODUCCIONSACODET where proroll_id = '$proroll_id' and estado = '0'
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    } 
    
    
             public function ListAvanceproduccSacosPrenV01($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "
select tablafin.*,fil.prefila_kanban as incluido from (
select * from(
select 
rollo.proroll_id,
proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id

,sacos.prosacodet_total, sacos.prosacodet_totalb
, ART.valitemcarac_valor as enfardelado
,sacosdet.prosacodet_id--, sacosdet.prosacodet_total, sacosdet.prosacodet_totalb
, sacosdet.estado as regparcialesproduc
from PROPRODUCCIONSACODET sacosdet

inner join PROPRODUCCIONROLLO rollo on rollo.proroll_id = sacosdet.proroll_id


inner JOIN PROPROGRAMACIONPROCDET proprodet on proprodet.progprodet_id= rollo.progprodet_id
inner join PROPROGRAMACIONPROC propro on    propro.progpro_id = proprodet.progpro_id

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner JOIN (
select ART.* , VAL.valitemcarac_valor
from PROARTSEMITERMINADO ART
INNER JOIN  PROVALITEMSCARACT VAL ON VAL.artsemi_id= ART.artsemi_id
 WHERE  VAL.itemcaracsemi_id = '77'
) ART ON ART.form_id = ved.codart

--agregado para mostrar sacos
LEFT join (
select    roll.proroll_mtrs_total prosacodet_total , roll.proroll_peso_total prosacodet_totalb, roll.proroll_id  , prog.progpro_kanban  
from PROPRODUCCIONROLLO roll

inner join PROPROGRAMACIONPROCDET progdet on progdet.progprodet_id= roll.progprodet_id
inner join PROPROGRAMACIONPROC prog on prog.progpro_id = progdet.progpro_id 
where prog.progpro_siguienteproc = '$procesos' 


)sacos on sacos.progpro_kanban = kandet.prokandet_id

where  propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( sacosdet.fecha_creacion AS DATE)<='$fin')  and ( concat (sacosdet.estado , propro.progpro_atendido) != '00') --and sacosdet.progpro_proceso = '' and sacosdet.estado = '1' 
)tabla19


union all 


select * from(

select 
rollo.proroll_id,
(proroll_mtrs_total + proroll_peso_total) as proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id

,(sacos.prosacodet_total + sacos.prosacodet_totalb) as prosacodet_total, sacos.prosacodet_totalb
, ART.valitemcarac_valor as enfardelado
,rollo.proroll_id AS prosacodet_id--, rollo.proroll_mtrs_total AS prosacodet_total, rollo.proroll_peso_total AS prosacodet_totalb
, rollo.estado as regparcialesproduc
--from PROPRODUCCIONSACODET sacosdet
FROM PROPRODUCCIONROLLO rollo 
--inner join PROPRODUCCIONROLLO rollo on rollo.proroll_id = sacosdet.proroll_id


inner JOIN PROPROGRAMACIONPROCDET proprodet on proprodet.progprodet_id= rollo.progprodet_id
inner join PROPROGRAMACIONPROC propro on  (  propro.progpro_id = proprodet.progpro_id and propro.progpro_siguienteproc = '172' and propro.progpro_proceso = '167')

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner JOIN (
select ART.* , VAL.valitemcarac_valor,itemcaracsemi_id
from PROARTSEMITERMINADO ART
INNER JOIN  PROVALITEMSCARACT VAL ON VAL.artsemi_id= ART.artsemi_id
 WHERE  VAL.itemcaracsemi_id = '77'
) ART ON ART.form_id = ved.codart

--agregado para mostrar sacos
LEFT join (
select    roll.proroll_mtrs_total prosacodet_total , roll.proroll_peso_total prosacodet_totalb, roll.proroll_id  , prog.progpro_kanban  
from PROPRODUCCIONROLLO roll

inner join PROPROGRAMACIONPROCDET progdet on progdet.progprodet_id= roll.progprodet_id
inner join PROPROGRAMACIONPROC prog on prog.progpro_id = progdet.progpro_id 
where prog.progpro_siguienteproc = '172' 


)sacos on sacos.progpro_kanban = kandet.prokandet_id

where  propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and rollo.proroll_atendido = '1'--and sacosdet.progpro_proceso = '' and sacosdet.estado = '1' 

)tabla50 where   proroll_id not in (select proroll_id from PROPRENSAFILAS)
)tablafin
left join (select distinct prefila_kanban from PROPRENSAFILAS where prefila_kanban != 'Manual')


 fil 



on  cast (fil.prefila_kanban as int ) = tablafin.prokandet_id
WHERE tablafin.prosacodet_total IS NOT NULL AND tablafin.prosacodet_totalb IS NOT NULL
";
    

       
                          
           if($estado == '0'){
           $sql .= " and  (tablafin.estado = '1' or tablafin.estado = '0') ";
           
        }elseif($estado == '1'){
            $sql .= " and tablafin.estado = '2' ";
            
        }else{
			 $sql .= " and (tablafin.estado = '2' or tablafin.estado = '1') ";
		}
            
                 
       
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
    
    
	                public function ListAvanceproduccSacosPren($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "

select tablafin.*--,fil.prefila_kanban as incluido 
from (
select * from(
select 
rollo.proroll_id,
proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id

,sacos.prosacodet_total, sacos.prosacodet_totalb
, ART.valitemcarac_valor as enfardelado
,sacosdet.prosacodet_id, sacosdet.prosacodet_total as parciala, sacosdet.prosacodet_totalb as parcialb
, sacosdet.estado as regparcialesproduc
from PROPRODUCCIONSACODET sacosdet

inner join PROPRODUCCIONROLLO rollo on (rollo.proroll_id = sacosdet.proroll_id and rollo.eliminado= '0')


inner JOIN PROPROGRAMACIONPROCDET proprodet on (proprodet.progprodet_id= rollo.progprodet_id and proprodet.eliminado= '0')
inner join PROPROGRAMACIONPROC propro on    propro.progpro_id = proprodet.progpro_id

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner JOIN (
select ART.* , VAL.valitemcarac_valor
from PROARTSEMITERMINADO ART
INNER JOIN  PROVALITEMSCARACT VAL ON VAL.artsemi_id= ART.artsemi_id
 WHERE  VAL.itemcaracsemi_id = '77'
) ART ON ART.form_id = ved.codart

--agregado para mostrar sacos
LEFT join (
select    roll.proroll_mtrs_total prosacodet_total , roll.proroll_peso_total prosacodet_totalb, roll.proroll_id  , prog.progpro_kanban  
from PROPRODUCCIONROLLO roll

inner join PROPROGRAMACIONPROCDET progdet on (progdet.progprodet_id= roll.progprodet_id and progdet.eliminado= '0')
inner join PROPROGRAMACIONPROC prog on prog.progpro_id = progdet.progpro_id 
where prog.progpro_siguienteproc = '$procesos' -- and prog.progpro_kanban='1399'--PARAMETRO PASASO POR EL SISTEMA 

--busca para bastillado
)sacos on sacos.progpro_kanban = kandet.prokandet_id

where  propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( sacosdet.fecha_creacion AS DATE)<='$fin')  and ( concat (sacosdet.estado , propro.progpro_atendido) != '00') --and sacosdet.progpro_proceso = '' and sacosdet.estado = '1' 
and propro.progpro_siguienteproc= '$procesos'
)tabla19
where tabla19.progpro_proceso='170' --  and tabla19.prokandet_id = '8522'  --proceso conversion - prensa

union all 
select * from(
select 
rollo.proroll_id,
proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id

,sacos.prosacodet_total, sacos.prosacodet_totalb
, ART.valitemcarac_valor as enfardelado
,sacosdet.prosacodet_id, sacosdet.prosacodet_total as parciala, sacosdet.prosacodet_totalb as parcialb
, sacosdet.estado as regparcialesproduc
from PROPRODUCCIONSACODET sacosdet

inner join PROPRODUCCIONROLLO rollo on (rollo.proroll_id = sacosdet.proroll_id and rollo.eliminado= '0')


inner JOIN PROPROGRAMACIONPROCDET proprodet on ( proprodet.progprodet_id= rollo.progprodet_id and proprodet.eliminado= '0')
inner join PROPROGRAMACIONPROC propro on    propro.progpro_id = proprodet.progpro_id

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner JOIN (
select ART.* , VAL.valitemcarac_valor
from PROARTSEMITERMINADO ART
INNER JOIN  PROVALITEMSCARACT VAL ON VAL.artsemi_id= ART.artsemi_id
 WHERE  VAL.itemcaracsemi_id = '77'
) ART ON ART.form_id = ved.codart

--agregado para mostrar sacos
LEFT join (
select    roll.proroll_mtrs_total prosacodet_total , roll.proroll_peso_total prosacodet_totalb, roll.proroll_id  , prog.progpro_kanban  
from PROPRODUCCIONROLLO roll

inner join PROPROGRAMACIONPROCDET progdet on (progdet.progprodet_id= roll.progprodet_id and progdet.eliminado= '0')
inner join PROPROGRAMACIONPROC prog on prog.progpro_id = progdet.progpro_id 
where prog.progpro_siguienteproc = '$procesos' -- and prog.progpro_kanban='1399'--PARAMETRO PASASO POR EL SISTEMA 

--busca para bastillado
)sacos on sacos.progpro_kanban = kandet.prokandet_id

where  propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( sacosdet.fecha_creacion AS DATE)<='$fin')  and ( concat (sacosdet.estado , propro.progpro_atendido) != '00') --and sacosdet.progpro_proceso = '' and sacosdet.estado = '1' 
and propro.progpro_siguienteproc= '$procesos'
)tabla19
where  tabla19.progpro_proceso='171' --and tabla19.prokandet_id = '8522'  --proceso - bastillado -prensa

)tablafin
union all
select * from(

select 
rollo.proroll_id,
(proroll_mtrs_total + proroll_peso_total) as proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id

,(sacos.prosacodet_total + sacos.prosacodet_totalb) as prosacodet_total, sacos.prosacodet_totalb
, ART.valitemcarac_valor as enfardelado
,rollo.proroll_id AS prosacodet_id, (sacos.prosacodet_total + sacos.prosacodet_totalb) as parciala, sacos.prosacodet_totalb as parcialb
, rollo.estado as regparcialesproduc
--from PROPRODUCCIONSACODET sacosdet
FROM PROPRODUCCIONROLLO rollo 
--inner join PROPRODUCCIONROLLO rollo on rollo.proroll_id = sacosdet.proroll_id


inner JOIN PROPROGRAMACIONPROCDET proprodet on ( proprodet.progprodet_id= rollo.progprodet_id and proprodet.eliminado= '0')
inner join PROPROGRAMACIONPROC propro on  (  propro.progpro_id = proprodet.progpro_id and propro.progpro_siguienteproc = '172' and propro.progpro_proceso = '167')

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner JOIN (
select ART.* , VAL.valitemcarac_valor,itemcaracsemi_id
from PROARTSEMITERMINADO ART
INNER JOIN  PROVALITEMSCARACT VAL ON VAL.artsemi_id= ART.artsemi_id
 WHERE  VAL.itemcaracsemi_id = '77'
) ART ON ART.form_id = ved.codart

--agregado para mostrar sacos
LEFT join (
select    roll.proroll_mtrs_total prosacodet_total , roll.proroll_peso_total prosacodet_totalb, roll.proroll_id  , prog.progpro_kanban  
from PROPRODUCCIONROLLO roll

inner join PROPROGRAMACIONPROCDET progdet on ( progdet.progprodet_id= roll.progprodet_id and progdet.eliminado= '0')
inner join PROPROGRAMACIONPROC prog on prog.progpro_id = progdet.progpro_id 
where prog.progpro_siguienteproc = '$procesos'
 --and progpro_kanban= '8522'


)sacos on sacos.progpro_kanban = kandet.prokandet_id

where  propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and rollo.proroll_atendido = '1'--and sacosdet.progpro_proceso = '' and sacosdet.estado = '1' 

)tabla50 where   proroll_id not in (select proroll_id from PROPRENSAFILAS) 
--and tabla50.prokandet_id ='8522'


";
    

       
                          
           if($estado == '0'){
          // $sql .= " and  (tablafin.estado = '1' or tablafin.estado = '0') ";
           
        }elseif($estado == '1'){
          //  $sql .= " and tablafin.estado = '2' ";
            
        }else{
			// $sql .= " and (tablafin.estado = '2' or tablafin.estado = '1') ";
		}
            
                 
       
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
    
       public function UpdateFilasGenerados ($id) { //producción 2020
        $stmt = $this->objPdo->prepare("
            update  PROPRODUCCIONSACODET 
            set estado =  '2'
                where prosacodet_id = '$id'
           ");
        $rows = $stmt->execute();
        return $rows;
    }
    
    
        public   function consultarAvanceProduccRolloConv2($ini,$fin,$procesos,$estado,$maquina) {//producción 2019
        $lista = [];
        $consultar = new kanban();
        if ($procesos == '170') {
			if($maquina =='-1'){
			  $lista = $consultar->ListAvanceproduccTelaresConv2($ini,$fin,$estado,$procesos);//ok
				}else {
				$lista = $consultar->ListAvanceproduccTelaresXmaqConv2($ini,$fin,$estado,$procesos,$maquina);//ok
				}
            

           
        }
        return $lista;
    }
    
               public function ListAvanceproduccTelaresConv($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "
select 
rollo.proroll_id,proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id

--, rollodet.prorolldet_id ,rollodet. ,rollodet. , rollodet. ,rollodet., rollodet
,tabla01.movdismaq_mtrs as metros_procanterior, tabla01.movdismaq_idkanban as kanban
from PROPRODUCCIONROLLO rollo


inner JOIN PROPROGRAMACIONPROCDET proprodet (proprodet.progprodet_id= rollo.progprodet_id and proprodet.eliminado= '0')
inner join PROPROGRAMACIONPROC propro on    propro.progpro_id = proprodet.progpro_id

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
--LEFT join PROPRODUCCIONROLLODET rollodet on rollodet.proroll_id = rollo.proroll_id

left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq
  where dis.movdismaq_proceso = '$procesos' and  dis.movdismaq_tipoocupacion = 'Programacion') tabla01
  on tabla01.movdismaq_idkanban= kandet.prokandet_id

where propro.estado = '0' and propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and propro.progpro_proceso = '$procesos' and propro.progpro_siguienteproc = '171'


";
        
        if($estado == '0'){
           $sql .= " and rollo.proroll_atendido = '0' ";
           
        }elseif($estado == '1'){
            $sql .= " and rollo.proroll_atendido = '1' ";
            
        }
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
    
         public function ListAvanceproduccTelaresXmaqConv($ini,$fin,$estado,$procesos,$maquina) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "
select 
rollo.proroll_id,proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id

,dis.movdismaq_maqid
,tabla01.movdismaq_mtrs as metros_procanterior, tabla01.movdismaq_idkanban as kanban
from PROPRODUCCIONROLLO rollo


inner JOIN PROPROGRAMACIONPROCDET proprodet on proprodet.progprodet_id= rollo.progprodet_id
inner join PROPROGRAMACIONPROC propro on    propro.progpro_id = proprodet.progpro_id

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROMOVDISPONIBILIDADMAQ dis on (kandet.prokandet_id = dis.movdismaq_idkanban and dis.movdismaq_proceso='$procesos' and dis.movdismaq_tipoocupacion != 'Puesta Marcha')

left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq
  where dis.movdismaq_proceso = '$procesos' and  dis.movdismaq_tipoocupacion = 'Programacion') tabla01
  on tabla01.movdismaq_idkanban= kandet.prokandet_id
  
where propro.estado = '0' and propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and propro.progpro_proceso = '$procesos' and propro.progpro_siguienteproc = '171'


";
        
        if($estado == '0'){
           $sql .= " and rollo.proroll_atendido = '0' ";
           
        }elseif($estado == '1'){
            $sql .= " and rollo.proroll_atendido = '1' ";
            
        }
        
           
        if($maquina != '-1'){
			   $sql .= "and dis.movdismaq_maqid = '$maquina' ";
		}
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
    
            public function ListAvanceproduccTelaresConv2($ini,$fin,$estado,$procesos) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "
select 
rollo.proroll_id,proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id

--, rollodet.prorolldet_id ,rollodet. ,rollodet. , rollodet. ,rollodet., rollodet
,tabla01.movdismaq_mtrs as metros_procanterior, tabla01.movdismaq_idkanban as kanban
from PROPRODUCCIONROLLO rollo


inner JOIN PROPROGRAMACIONPROCDET proprodet on ( proprodet.progprodet_id= rollo.progprodet_id and proprodet.eliminado= '0')
inner join PROPROGRAMACIONPROC propro on    propro.progpro_id = proprodet.progpro_id

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
--LEFT join PROPRODUCCIONROLLODET rollodet on rollodet.proroll_id = rollo.proroll_id

left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq
  where dis.movdismaq_proceso = '$procesos' and  dis.movdismaq_tipoocupacion = 'Programacion') tabla01
  on tabla01.movdismaq_idkanban= kandet.prokandet_id

where propro.estado = '0' and propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and propro.progpro_proceso = '$procesos' and propro.progpro_siguienteproc = '172'


";
        
        if($estado == '0'){
           $sql .= " and rollo.proroll_atendido = '0' ";
           
        }elseif($estado == '1'){
            $sql .= " and rollo.proroll_atendido = '1' ";
            
        }
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
    
         public function ListAvanceproduccTelaresXmaqConv2($ini,$fin,$estado,$procesos,$maquina) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $sql = "";
                $sql .= "
select 
rollo.proroll_id,proroll_mtrs_total,proroll_peso_total,proroll_atendido
,propro.progpro_id, CAST ( propro.progpro_fecprogramacion AS DATE) progpro_fecprogramacion, propro.progpro_atendido, propro.progpro_proceso,propro.fecha_creacion  fecha_creacion2

,kandet.* ,ved.cantped, ved.codart,ved.desart,vec.codcli,vec.razonsocial,kan.prokan_cantkanban
, proprodet.progprodet_fecha_ini, proprodet.progprodet_hora_ini , proprodet.progprodet_fecha_fin , proprodet.progprodet_hora_fin, proprodet.progprodet_atendido,proprodet.progprodet_id

,dis.movdismaq_maqid
,tabla01.movdismaq_mtrs as metros_procanterior, tabla01.movdismaq_idkanban as kanban
from PROPRODUCCIONROLLO rollo


inner JOIN PROPROGRAMACIONPROCDET proprodet on (proprodet.progprodet_id= rollo.progprodet_id and proprodet.eliminado= '0')
inner join PROPROGRAMACIONPROC propro on    propro.progpro_id = proprodet.progpro_id

INNER JOIN PROPROGKANBANDET kandet ON kandet.prokandet_id = propro.progpro_kanban
INNER JOIN PROPROGKANBAN kan on kan.prokan_nroped = kandet.prokandet_nroped and (kan.eliminado='0')
inner join " . $_SESSION['server_vinculado'] . "vepedidod ved on ved.nroped = kandet.prokandet_nroped
inner join " . $_SESSION['server_vinculado'] . "vepedidoc vec on vec.nroped = kandet.prokandet_nroped
inner join PROMOVDISPONIBILIDADMAQ dis on (kandet.prokandet_id = dis.movdismaq_idkanban and dis.movdismaq_proceso='$procesos' and dis.movdismaq_tipoocupacion != 'Puesta Marcha')

left join 
  (select dis.*,maq.maq_nombre from PROMOVDISPONIBILIDADMAQ   dis
  inner join PROMGMAQUINA maq on maq.maq_id = dis.movdismaq_idmaq
  where dis.movdismaq_proceso = '$procesos' and  dis.movdismaq_tipoocupacion = 'Programacion') tabla01
  on tabla01.movdismaq_idkanban= kandet.prokandet_id
  
where propro.estado = '0' and propro.eliminado = '0' AND ( CAST(propro.fecha_creacion AS DATE) >= '$ini' 
AND CAST( propro.fecha_creacion AS DATE)<='$fin') and propro.progpro_proceso = '$procesos' and propro.progpro_siguienteproc = '172'


";
        
        if($estado == '0'){
           $sql .= " and rollo.proroll_atendido = '0' ";
           
        }elseif($estado == '1'){
            $sql .= " and rollo.proroll_atendido = '1' ";
            
        }
        
           
        if($maquina != '-1'){
			   $sql .= "and dis.movdismaq_maqid = '$maquina' ";
		}
  
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    
    
    
       public function ConsultarTipoProducto($op) { //" . $_SESSION['server_vinculado'] . "
        $stmt = $this->objPdo->prepare("
select VED.nroped , VED.codart, VED.desart, ARTSEMI.artsemi_id, ARTSEMI.form_id ,tabla.*
from " . $_SESSION['server_vinculado'] . "VEPEDIDOD VED
INNER JOIN PROARTSEMITERMINADO ARTSEMI ON ARTSEMI.form_id= VED.codart
LEFT JOIN  (
select PivotTable.artsemi_id artsemi_id2, PivotTable.[15] as variedad, PivotTable.[19] as tipproducto, PivotTable.[21] as tipacabado , PivotTable.[11] as ancho , PivotTable.[48] as lagcorte
from (
			select  artsemi_id,itemcaracsemi_id, 
			case when valitemcarac_valor is null then 0 
			when valitemcarac_valor = '' then 0 
			when  TRY_CAST ( valitemcarac_valor as decimal(15,2))  is not null  then cast ( valitemcarac_valor as decimal(15,2))
			else 0
			 end as decimal1  from PROVALITEMSCARACT
			where  ( itemcaracsemi_id = '15' or itemcaracsemi_id= '19' or itemcaracsemi_id= '21' or  itemcaracsemi_id= '11' or  itemcaracsemi_id= '48') --and artsemi_id = '393' 
) as tabla01 pivot(avg(decimal1) for itemcaracsemi_id in ([15],[19],[21],[11],[48]) )as PivotTable
) tabla ON tabla.artsemi_id2 = ARTSEMI.artsemi_id

WHERE VED.nroped = '$op'


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    } 
    
    
    
    
       function consultarTramaUrd($semi_id, $tipo) {//producción 2019
        $lista = [];
             
        
$cuerpo =[];
 

$cintatrama =[];
$cintaurdimbre =[];

     $kanban = new kanban();
     
     
       $cuerpokanban = $kanban->cuerpokanban( $semi_id);

       
     
  
  if( $cuerpokanban){
		   foreach( $cuerpokanban as $listacue){
			    $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
		   }
}
	   if ($tipo == 'saco'){
		   $codTrama =  $cuerpo['13'];
$codUrdim =  $cuerpo['14']; 
		   
		   
	   }else{
		   
		   
		  $codTrama =  $cuerpo['85'];
$codUrdim =  $cuerpo['86'];  
		   
	   }
		
  

 $infoTrama = $kanban->caraccintas( $codTrama);
 $infoUrdimbre = $kanban->caraccintas( $codUrdim );
 
// print_r ($codTrama);
 // print_r ($codUrdim);
 
 
 
  if(  $infoTrama){
		   foreach(  $infoTrama as $listatra){
			    $cintatrama[$listatra['itemcaracsemi_id']] = $listatra['valor'];
		   }
}


 if(  $infoUrdimbre){
		   foreach(  $infoUrdimbre as $listaurd){
			    $cintaurdimbre[$listaurd['itemcaracsemi_id']] = $listaurd['valor'];
		   }
}

 $lista[1] = $cintatrama['1'];
 $lista[2] = $cintaurdimbre['1'];
        
        return $lista;
    } 
    
    
    
    
    
           public function caraccintasXid($artsemi_id) { 
        $stmt = $this->objPdo->prepare("
   select  tablafin.artsemi_id, tablafin.itemcaracsemi_id,tablafin.itemcaracsemi_descripcion, tablafin.valor --*
from (
select tablacombo.* from (
select tabla01.*,
case when  tabla02.nombre is null then '' else  tabla02.nombre end as valor
  from (
SELECT VAL.*, ITEM.itemcaracsemi_descripcion, item.itemcaracsemi_tipodato, ITEM.itemcaracsemi_tabla
,ITEM.itemcaracsemi_tabla_id, ITEM.itemcaracsemi_tabla_descripcion--, semi.artsemi_descripcion
 FROM PROVALITEMSCARACT VAL
INNER JOIN PROITEMCARACTSEMITERMINADO ITEM ON ITEM.itemcaracsemi_id = VAL.itemcaracsemi_id
inner join PROARTSEMITERMINADO  semi  on semi.artsemi_id = VAL.artsemi_id
WHERE semi.artsemi_id = '$artsemi_id' and itemcaracsemi_tipodato = '_combo' and semi.artsemi_estado='0') tabla01
left join 
(


select artsemi_id  as codigo, artsemi_descripcion as nombre,'artsemi_id' as tipotabla from PROARTSEMITERMINADO where tipsem_id = '1' or tipsem_id = '8'
union all
select col_id  as codigo, col_titulo as nombre,'col_id' as tipotabla from PROCOLORES
union all
select colimp_id  as codigo, colimp_nombre as nombre,'colimp_id' as tipotabla from PROCOLORESIMP
union all
select form_id  as codigo,form_identificacion as nombre,'form_id' as tipotabla from PROFORMULACION
union all
select prodi_id  as codigo,prodi_nombre as nombre, 'prodi_id' as tipotabla from PRODISENOS
union all
select tabgendet_id as codigo, tabgendet_nombre as nombre,'tabgendet_id' as tipotabla from PROTABLAGENDET
union all
select tipuso_id as codigo,tipuso_descripcion as nombre,'tipuso_id' as tipotabla from PROTIPOUSO
union all
select '-1' as codigo, '#' as nombre, '#' as tipotabla
) tabla02

on tabla02.tipotabla= tabla01.itemcaracsemi_tabla_id and tabla02.codigo= tabla01.valitemcarac_valor --and tabla01.itemcaracsemi_tipodato = '_combo'
)tablacombo
union all
SELECT VAL.*, ITEM.itemcaracsemi_descripcion, item.itemcaracsemi_tipodato, ITEM.itemcaracsemi_tabla
,ITEM.itemcaracsemi_tabla_id, ITEM.itemcaracsemi_tabla_descripcion, VAL.valitemcarac_valor as valor
--, semi.artsemi_descripcion
FROM PROVALITEMSCARACT VAL
INNER JOIN PROITEMCARACTSEMITERMINADO ITEM ON ITEM.itemcaracsemi_id = VAL.itemcaracsemi_id
inner join PROARTSEMITERMINADO  semi  on semi.artsemi_id = VAL.artsemi_id
WHERE semi.artsemi_id = '$artsemi_id' and itemcaracsemi_tipodato = '_caja' and semi.artsemi_estado='0'
)tablafin
order by  tablafin.itemcaracsemi_id

    
       
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
  
        public function cabecerakanbanXmaqSaco($op) { 
        $stmt = $this->objPdo->prepare("
select kandet.* ,kan.prokan_id, kan.prokan_larg_corte, kan.prokan_porcent_b, kan.prokan_mtrs_totales,kan.prokan_cantkanban, kan.prokan_mtrs_totalparche
,kan.prokan_cantkanbanparche,
vc.razonsocial,vd.codart, vd.desart,VD.cantped, vc.docref, comen.procoment_mensaje,maquina.nombre,artic.artsemi_descripcion  ,semi.artsemi_descripcion,artic.artsemi_descripcion as nombresemi

 from PROPROGKANBAN kan

 inner join ( select distinct prokandet_telar, prokandet_nroped,prokandet_tipo,artsemi_id from  PROPROGKANBANDET where prokandet_nroped = '$op' ) as kandet on kandet.prokandet_nroped = kan.prokan_nroped

inner join [192.168.10.242].[elaguila].[dbo].VEPEDIDOC vc on vc.nroped = kan.prokan_nroped and vc.tipped = 'VAB'
inner join [192.168.10.242].[elaguila].[dbo].VEPEDIDOd vd on vd.nroped = vc.nroped
inner join PROARTSEMITERMINADO semi on semi.form_id = vd.codart and (semi.tipsem_id ='2' or semi.tipsem_id = '8' ) and semi.form_id != '-1'
inner join PROARTSEMITERMINADO artic on artic.artsemi_id = kandet.artsemi_id
inner join (
select maq_id, maq_nombre,  SUBSTRING(maq_nombre,1,CHARINDEX('-' ,maq_nombre)-1) as nombre
from PROMGMAQUINA where are_id = '4'

)  maquina on maquina.maq_id = kandet.prokandet_telar

left join PROCOMENTARIOS comen on comen.procoment_id_doc= vc.nroped and (comen.procoment_id_usuario = '1' or comen.procoment_id_usuario='2')
where kandet.prokandet_nroped = '$op' and kandet.prokandet_telar is not null and kandet.prokandet_tipo = 'saco'



    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
     public function GuardarRegisArpille($op,$kanban,$a, $b,$cantenfardado,$proroll_id,$usuario_nickname) {
		 $Cantidad_mtrs= $a+ ($b*2);
		 $peso = $b;
        $div_entera_clasea = $cantenfardado;
      
        
        $kanbas = $kanban."/";
                
    //inicio clase A         
    $insertarregi = new kanban();
         if($div_entera_clasea >=1){
             for ($index = 1; $index <= $div_entera_clasea; $index++) {
                 //generacion de fardos en funcion del tamaño del fardo
            
                $insertarregi->insertarRegistroFardos($proroll_id, $op, $kanban, $cantenfardado, $cantenfardado, 'Clase A', $kanbas, $usuario_nickname, $usuario_nickname,'Total');
             
                
             }
            
         }
         
         
   
     }
     
    
      
public function calcular_tiempo1($velInicial, $mtrs,$fecdisp) {
	 date_default_timezone_set('America/Lima');
	  $kanban = new kanban();
	   $velocidadHora = $velInicial * 60; //METROS POR MINUTOS
	   $datos= [];
	 
	 if($mtrs> '4894'){
		 $bucle = round($mtrs/4894);
		 
		 for($i=1; $i <=  $bucle ; $i++){
			  $hora_primera = '23:58:48';
				$hora_prim_parte = $kanban->calcular_tiempo_hor( $hora_primera , '00:00');
                $min_prim_parte = $kanban->calcular_tiempo_min( $hora_primera , '00:00');
                
                $fecha_produccion = new DateTime($fecdisp);
                $fecha_produccion->modify("+$hora_prim_parte hour");
                $fecha_produccion->modify("+ $min_prim_parte minute");
               
                $nuevaFecha_prim_parte = $fecha_produccion->format('Y-m-d H:i:s'); 
                $fecdisp = $nuevaFecha_prim_parte;
                
			 
		 }
		
		 $resto = $mtrs%4894;
		 
				 $tiempo_decimal =  round (floatval( $resto  / $velocidadHora),2);
				 $hora_segunda = gmdate('H:i:s', floor($tiempo_decimal * 3600));
				 
				 $hora_segun_parte = $kanban->calcular_tiempo_hor( $hora_segunda , '00:00');
				 $min_segun_parte = $kanban->calcular_tiempo_min( $hora_segunda , '00:00');
				 
				 $fecha_produccion_fin = new DateTime($nuevaFecha_prim_parte);
				 $fecha_produccion_fin->modify("+$hora_segun_parte hour");
				 $fecha_produccion_fin->modify("+ $min_segun_parte minute");
				 $nuevaFecha_fin_parte = $fecha_produccion_fin->format('Y-m-d H:i:s'); 
				 
				 $hor_total = $hora_prim_parte +  $hora_segun_parte;
				//print_r($hor_total);
				 $min_total = $min_prim_parte +  $min_segun_parte;
		 
	 }else{
		
             
				$tiempo_decimal =  round (floatval($mtrs / $velocidadHora),2);
                $hora_primera = gmdate('H:i:s', floor($tiempo_decimal * 3600)); 
                
                $hora_prim_parte = $kanban->calcular_tiempo_hor( $hora_primera , '0:00');
                $min_prim_parte = $kanban->calcular_tiempo_min( $hora_primera , '0:00');
                
                 $fecha_produccion = new DateTime($fecdisp);
                $fecha_produccion->modify("+$hora_prim_parte hour");
                $fecha_produccion->modify("+ $min_prim_parte minute");
               
                $nuevaFecha_fin_parte = $fecha_produccion->format('Y-m-d H:i:s'); 
                
                 $hor_total = $hora_prim_parte ;
                 $min_total = $min_prim_parte;
                
                
	 }
	 
	 if($min_total >59){
		 
		$min =  $min_total %60;
		$entero = round ($min_total /60); // $min_total / 60;
		 
		
		$hor = $hor_total + $entero;
	 }elseif($min_total <= 59){
	  $min =  $min_total;
		 $hor = $hor_total;
	 }else{
		 $min =  $min_total;
		 $hor = $hor_total;
	 }
         
         
         //************** redondeando a 2 digitos
         $hor_texto= '';
          $min_texto = '';
         if(strlen($hor)==1){
             $hor_texto = '0'.$hor;
         }else{
              $hor_texto = $hor;
         }
          if(strlen($min)==1){
             $min_texto = '0'.$min;
         }else{
              $min_texto = $min;
         }
          //************** fin redondeando a 2 digitos
$tiempo_transcurrido = $hor_texto .':'.$min_texto.':00';
	 
	 $datos['1']= $nuevaFecha_fin_parte ;
	 $datos['2']= $tiempo_transcurrido ;
	 $datos['3']= $hor ;
	 $datos['4']=  $min  ;
	 print_r ('MOSTRAR-ENTERO');
	 print_r ($entero. ' - <BR>');
	 print_r ($hor_total .' HORAS TOTAL <BR>');
	print_r ($min_total.' MIN TOTAL <BR>');
	 print_r ($min.' MIN REG TOTAL <BR>');
	print_r ($hor.' HOR REG TOTAL <BR>');
	print_r ($hor.' HOR REG TOTAL <BR>');
	 
	 return $datos;
 
}

public function calcular_tiempo($velInicial, $mtrs,$fecdisp,$proceso,$long_corte) {
	 date_default_timezone_set('America/Lima');
         
          $kanban = new kanban();
	   $velocidadHora = $velInicial * 60; //METROS (unidades)POR HORA
         
         if($proceso== 170){
             $factor_pul_mtrs = 0.0254;
             $long_cort_mtrs = $long_corte*$factor_pul_mtrs;
           $total_sacos =  round ( floatval ( $mtrs/$long_cort_mtrs),1);    
            
             $horas_calc = round ( floatval (  $total_sacos/$velocidadHora));    
         }else{
              $horas_calc = round ( floatval ($mtrs/$velocidadHora),1);
         }
	 
          // $total_horas = $mtrs/$velocidadHora;
           $total_horas = $horas_calc;
	   $datos= [];
           
           
	 $resto_horas =  $total_horas %24;
		$dias_bucle = floor ($total_horas /24);
           
           
	 if($dias_bucle> 0){
		// $bucle = round($mtrs/4894);
		 
		 for($i=1; $i <=  $dias_bucle ; $i++){
			  $hora_primera = '23:59:59';
				$hora_prim_parte = $kanban->calcular_tiempo_hor( $hora_primera , '00:00');
                $min_prim_parte = $kanban->calcular_tiempo_min( $hora_primera , '00:00');
                
                $fecha_produccion = new DateTime($fecdisp);
                $fecha_produccion->modify("+$hora_prim_parte hour");
                $fecha_produccion->modify("+ $min_prim_parte minute");
               
                $nuevaFecha_prim_parte = $fecha_produccion->format('Y-m-d H:i:s'); 
                $fecdisp = $nuevaFecha_prim_parte;
                
			 
		 }
		
		 $resto = $resto_horas;
		 
				 $tiempo_decimal =  round (floatval( $resto),2);
				 $hora_segunda = gmdate('H:i:s', floor($tiempo_decimal * 3600));
				 
				 $hora_segun_parte = $kanban->calcular_tiempo_hor( $hora_segunda , '00:00');
				 $min_segun_parte = $kanban->calcular_tiempo_min( $hora_segunda , '00:00');
				 
				 $fecha_produccion_fin = new DateTime($nuevaFecha_prim_parte);
				 $fecha_produccion_fin->modify("+$hora_segun_parte hour");
				 $fecha_produccion_fin->modify("+ $min_segun_parte minute");
				 $nuevaFecha_fin_parte = $fecha_produccion_fin->format('Y-m-d H:i:s'); 
				 
				 $hor_total = $hora_prim_parte +  $hora_segun_parte;
				//print_r($hor_total);
				 $min_total = $min_prim_parte +  $min_segun_parte;
		 
	 }else{
		
             if($resto_horas ==0 && $dias_bucle==0){
                 $tiempo_decimal =  round (floatval($total_horas),2);
                $hora_primera = gmdate('H:i:s', floor($tiempo_decimal * 3600)); 
                
                $hora_prim_parte = $kanban->calcular_tiempo_hor( $hora_primera , '0:00');
                $min_prim_parte = $kanban->calcular_tiempo_min( $hora_primera , '0:00');
                
                 $fecha_produccion = new DateTime($fecdisp);
                $fecha_produccion->modify("+$hora_prim_parte hour");
                $fecha_produccion->modify("+ $min_prim_parte minute");
               
                $nuevaFecha_fin_parte = $fecha_produccion->format('Y-m-d H:i:s'); 
                
                 $hor_total = $hora_prim_parte ;
                 $min_total = $min_prim_parte;
                
             }else{
                 $tiempo_decimal =  round (floatval($resto_horas),2);
                $hora_primera = gmdate('H:i:s', floor($tiempo_decimal * 3600)); 
                
                $hora_prim_parte = $kanban->calcular_tiempo_hor( $hora_primera , '0:00');
                $min_prim_parte = $kanban->calcular_tiempo_min( $hora_primera , '0:00');
                
                 $fecha_produccion = new DateTime($fecdisp);
                $fecha_produccion->modify("+$hora_prim_parte hour");
                $fecha_produccion->modify("+ $min_prim_parte minute");
               
                $nuevaFecha_fin_parte = $fecha_produccion->format('Y-m-d H:i:s'); 
                
                 $hor_total = $hora_prim_parte ;
                 $min_total = $min_prim_parte;
                
             }
		
                
	 }
	 
	 if($min_total >59){
		 
		$min =  $min_total %60;
		$entero = round ($min_total /60); // $min_total / 60;
		 
		
		$hor = $hor_total + $entero;
	 }elseif($min_total <= 59){
	  $min =  $min_total;
		 $hor = $hor_total;
	 }else{
		 $min =  $min_total;
		 $hor = $hor_total;
	 }
         
         
         //************** redondeando a 2 digitos
         $hor_texto= '';
          $min_texto = '';
         if(strlen($hor)==1){
             $hor_texto = '0'.$hor;
         }else{
              $hor_texto = $hor;
         }
          if(strlen($min)==1){
             $min_texto = '0'.$min;
         }else{
              $min_texto = $min;
         }
          //************** fin redondeando a 2 digitos
$tiempo_transcurrido = $hor_texto .':'.$min_texto.':00';
	 
	 $datos['1']= $nuevaFecha_fin_parte ;
	 $datos['2']= $tiempo_transcurrido ;
	 $datos['3']= $hor ;
	 $datos['4']=  $min  ;
	 print_r ('MOSTRAR-ENTERO');
	 print_r ($entero. ' - <BR>');
	 print_r ($hor_total .' HORAS TOTAL <BR>');
	print_r ($min_total.' MIN TOTAL <BR>');
	 print_r ($min.' MIN REG TOTAL <BR>');
	print_r ($hor.' HOR REG TOTAL <BR>');
	print_r ($hor.' HOR REG TOTAL <BR>');
	 
	 return $datos;
 
}


function color_rand() {
 return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
 }
    
    
            public function conultarClaseB($codart,$tipo) { 
        $stmt = $this->objPdo->prepare("
select art.artsemi_id, art.form_id, val.valitemcarac_valor as codigofin
from PROARTSEMITERMINADO art
inner join PROVALITEMSCARACT val on ( val.artsemi_id = art.artsemi_id and val.itemcaracsemi_id = '$tipo')
where art.form_id = '$codart'


    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
    public function calcular_tiempoXsigno($velInicial, $mtrs,$fecdisp,$proceso,$long_corte,$signo) {
	 date_default_timezone_set('America/Lima');
         
          $kanban = new kanban();
	   $velocidadHora = $velInicial * 60; //METROS (unidades)POR HORA
         
         if($proceso== 170){
             $factor_pul_mtrs = 0.0254;
             $long_cort_mtrs = $long_corte*$factor_pul_mtrs;
           $total_sacos =  round ( floatval ( $mtrs/$long_cort_mtrs),1);    
            
             $horas_calc = round ( floatval (  $total_sacos/$velocidadHora));    
         }else{
              $horas_calc = round ( floatval ($mtrs/$velocidadHora),1);
         }
	 
          // $total_horas = $mtrs/$velocidadHora;
           $total_horas = $horas_calc;
	   $datos= [];
           
           
	 $resto_horas =  $total_horas %24;
		$dias_bucle = floor ($total_horas /24);
           
           
	 if($dias_bucle> 0){
		// $bucle = round($mtrs/4894);
		 
		 for($i=1; $i <=  $dias_bucle ; $i++){
			  $hora_primera = '23:59:59';
				$hora_prim_parte = $kanban->calcular_tiempo_hor( $hora_primera , '00:00');
                $min_prim_parte = $kanban->calcular_tiempo_min( $hora_primera , '00:00');
                
                $fecha_produccion = new DateTime($fecdisp);
                $fecha_produccion->modify("$signo $hora_prim_parte hour");
                $fecha_produccion->modify("$signo $min_prim_parte minute");
               
                $nuevaFecha_prim_parte = $fecha_produccion->format('Y-m-d H:i:s'); 
                $fecdisp = $nuevaFecha_prim_parte;
                
			 
		 }
		
		 $resto = $resto_horas;
		 
				 $tiempo_decimal =  round (floatval( $resto),2);
				 $hora_segunda = gmdate('H:i:s', floor($tiempo_decimal * 3600));
				 
				 $hora_segun_parte = $kanban->calcular_tiempo_hor( $hora_segunda , '00:00');
				 $min_segun_parte = $kanban->calcular_tiempo_min( $hora_segunda , '00:00');
				 
				 $fecha_produccion_fin = new DateTime($nuevaFecha_prim_parte);
				 $fecha_produccion_fin->modify("$signo $hora_segun_parte hour");
				 $fecha_produccion_fin->modify("$signo $min_segun_parte minute");
				 $nuevaFecha_fin_parte = $fecha_produccion_fin->format('Y-m-d H:i:s'); 
				 
				 $hor_total = $hora_prim_parte +  $hora_segun_parte;
				//print_r($hor_total);
				 $min_total = $min_prim_parte +  $min_segun_parte;
		 
	 }else{
		
             if($resto_horas ==0 && $dias_bucle==0){
                 $tiempo_decimal =  round (floatval($total_horas),2);
                $hora_primera = gmdate('H:i:s', floor($tiempo_decimal * 3600)); 
                
                $hora_prim_parte = $kanban->calcular_tiempo_hor( $hora_primera , '0:00');
                $min_prim_parte = $kanban->calcular_tiempo_min( $hora_primera , '0:00');
                
                 $fecha_produccion = new DateTime($fecdisp);
                $fecha_produccion->modify("$signo $hora_prim_parte hour");
                $fecha_produccion->modify("$signo $min_prim_parte minute");
               
                $nuevaFecha_fin_parte = $fecha_produccion->format('Y-m-d H:i:s'); 
                
                 $hor_total = $hora_prim_parte ;
                 $min_total = $min_prim_parte;
                
             }else{
                 $tiempo_decimal =  round (floatval($resto_horas),2);
                $hora_primera = gmdate('H:i:s', floor($tiempo_decimal * 3600)); 
                
                $hora_prim_parte = $kanban->calcular_tiempo_hor( $hora_primera , '0:00');
                $min_prim_parte = $kanban->calcular_tiempo_min( $hora_primera , '0:00');
                
                 $fecha_produccion = new DateTime($fecdisp);
                $fecha_produccion->modify("$signo $hora_prim_parte hour");
                $fecha_produccion->modify("$signo $min_prim_parte minute");
               
                $nuevaFecha_fin_parte = $fecha_produccion->format('Y-m-d H:i:s'); 
                
                 $hor_total = $hora_prim_parte ;
                 $min_total = $min_prim_parte;
                
             }
		
                
	 }
	 
	 if($min_total >59){
		 
		$min =  $min_total %60;
		$entero = round ($min_total /60); // $min_total / 60;
		 
		
		$hor = $hor_total + $entero;
	 }elseif($min_total <= 59){
	  $min =  $min_total;
		 $hor = $hor_total;
	 }else{
		 $min =  $min_total;
		 $hor = $hor_total;
	 }
         
         
         //************** redondeando a 2 digitos
         $hor_texto= '';
          $min_texto = '';
         if(strlen($hor)==1){
             $hor_texto = '0'.$hor;
         }else{
              $hor_texto = $hor;
         }
          if(strlen($min)==1){
             $min_texto = '0'.$min;
         }else{
              $min_texto = $min;
         }
          //************** fin redondeando a 2 digitos
$tiempo_transcurrido = $hor_texto .':'.$min_texto.':00';
	 
	 $datos['1']= $nuevaFecha_fin_parte ;
	 $datos['2']= $tiempo_transcurrido ;
	 $datos['3']= $hor ;
	 $datos['4']=  $min  ;
	 print_r ('MOSTRAR-ENTERO');
	 print_r ($entero. ' - <BR>');
	 print_r ($hor_total .' HORAS TOTAL <BR>');
	print_r ($min_total.' MIN TOTAL <BR>');
	 print_r ($min.' MIN REG TOTAL <BR>');
	print_r ($hor.' HOR REG TOTAL <BR>');
	print_r ($hor.' HOR REG TOTAL <BR>');
	 
	 return $datos;
 
}

   public function ConsultarMaqXprogpro_id($progpro_id) { 
        $stmt = $this->objPdo->prepare("

		 select * from PROPROGRAMACIONPROCDET  where progpro_id= '$progpro_id' AND estado= '0' AND eliminado= '0'

    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

       public function ConsultarArtsemiXnombre($artsemi_nombre) { 
        $stmt = $this->objPdo->prepare("

		select * from PROARTSEMITERMINADO 
where  artsemi_descripcion= '$artsemi_nombre'
and artsemi_estado ='0' and eliminado= '0' and tipsem_id= '1'
    ");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    
    
  
   }
   

  
  
  
  
?>









 
