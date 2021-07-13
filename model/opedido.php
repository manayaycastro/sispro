<?php

require_once 'conexion.php';

class opedido {

  
    private $objPdo;

    public function __construct() { // produccion 20200327
      
        $this->objPdo = new Conexion();
    }

    public function consultar() { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
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
FROM ". $_SESSION['server_vinculado']."VEPEDIDOC VEC
inner join ". $_SESSION['server_vinculado']."ALALM ALMA ON ALMA.codalm = VEC.codalm
inner join (
select tc.codtabla, td.codelemento, td.descripcion
from ". $_SESSION['server_vinculado']."MGTABGENC  tc
inner join ". $_SESSION['server_vinculado']."MGTABGEND td on td.codtabla = tc.codtabla
where tc.codtabla = '015'
) estado on estado.codelemento = VEC.estado
inner join ". $_SESSION['server_vinculado']."VECLIENTE  clien on clien.codcli = VEC.codcli
inner join ". $_SESSION['server_vinculado']."VEVENDEDOR vended on vended.codven = VEC.codven
inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VED ON VED.nroped = VEC.nroped
WHERE  VEC.tipped = 'VAB' AND CAST(VEC.fecped AS DATE ) >= '2019-10-31'  --VEC.nroped = '29341' AND


        

    ");
        $stmt->execute();
        $ops = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ops;
    }
    
        public function consultar2($inicio, $fin) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
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
, art.codalt,diseno.*,CONPAG.descripcion as nomconpag,aprobado.prodped_id, aprobado.prodidet_id as disenoapro
,tablaimp.tabgendet_nombre
FROM ". $_SESSION['server_vinculado']."VEPEDIDOC VEC
inner join ". $_SESSION['server_vinculado']."ALALM ALMA ON ALMA.codalm = VEC.codalm
inner join (
select tc.codtabla, td.codelemento, td.descripcion
from ". $_SESSION['server_vinculado']."MGTABGENC  tc
inner join ". $_SESSION['server_vinculado']."MGTABGEND td on td.codtabla = tc.codtabla
where tc.codtabla = '015'
) estado on estado.codelemento = VEC.estado
inner join ". $_SESSION['server_vinculado']."VECLIENTE  clien on clien.codcli = VEC.codcli
inner join ". $_SESSION['server_vinculado']."VEVENDEDOR vended on vended.codven = VEC.codven
inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VED ON VED.nroped = VEC.nroped
    INNER JOIN ". $_SESSION['server_vinculado']."VECONPAG CONPAG ON CONPAG.CONPAG=VEC.CONPAG
    INNER  join ". $_SESSION['server_vinculado']."ALART art ON VED.CODART=art.CODART
        left join PROPEDIDOAPROB aprobado on  aprobado.prodped_op = VEC.nroped and aprobado.prodped_tipaprob = '1'
LEFT JOIN 
(
select disedet.prodidet_id, disedet.prodi_id, disedet.prodidet_url,disedet.prodidet_version,dise.prodi_codart,dise.prodi_cliente
from PRODISENOSDET disedet
inner join PRODISENOS dise on dise.prodi_id = disedet.prodi_id and disedet.prodidet_vigente = '1'
) AS diseno
on diseno.prodi_codart = VED.CODART

left join (
        select tabla.*, art.form_id from (
        SELECT val.*, imp.tabgendet_nombre FROM PROVALITEMSCARACT val
        inner join (
        select gendet.* from PROTABLAGEN gen
        inner join PROTABLAGENDET gendet on gendet.tabgen_id = gen.tabgen_id
        where gen.tabgen_id ='4'
        ) imp on val.valitemcarac_valor = imp.tabgendet_id
        WHERE  val.itemcaracsemi_id = '20'
        )tabla
        inner join PROARTSEMITERMINADO art on art.artsemi_id = tabla.artsemi_id
)tablaimp on tablaimp.form_id = VED.codart
WHERE  VEC.tipped = 'VAB' AND CAST(VEC.fecped AS DATE ) >= '$inicio' AND CAST(VEC.fecped AS DATE ) <= '$fin' --and aprobado.prodped_id is  null


        

    ");
        $stmt->execute();
        $ops = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ops;
    }
 
  

    public function consultarOp($op) { // produccion 20200327
        $stmt = $this->objPdo->prepare("
               
SELECT 
VEC.nroped, VEC.codalm, cast (VEC.fecped as date) as fecped , VEC.estado, VEC.codcli, VEC.codven, VEC.conpag, VEC.codmon, VEC.tasaigv,
VEC.razonsocial, VEC.direccion, VEC.nroid, VEC.observacion, cast ( fechaentrega as date ) as fechaentrega , VEC.occliente, VEC.valorventa,datediff( day,VEC.fecped ,VEC.fechaentrega) AS difer ,
VEC.imptotal, VEC.factorc,
ALMA.nombre,
estado.descripcion,
clien.lineacredito,
vended.apellidos, vended.nombres,
VED.codart, VED.desart, ved.cantped, VED.preuni, VED.coduser,
CONPAG.descripcion as nomconpag,
isnull (direcprin.razonsocial,direc.razonsocial) as razonsocialprincipal, art.codalt
FROM ". $_SESSION['server_vinculado']."VEPEDIDOC VEC
inner join ". $_SESSION['server_vinculado']."ALALM ALMA ON ALMA.codalm = VEC.codalm
inner join (
select tc.codtabla, td.codelemento, td.descripcion
from ". $_SESSION['server_vinculado']."MGTABGENC  tc
inner join ". $_SESSION['server_vinculado']."MGTABGEND td on td.codtabla = tc.codtabla
where tc.codtabla = '015'
) estado on estado.codelemento = VEC.estado
inner join ". $_SESSION['server_vinculado']."VECLIENTE  clien on clien.codcli = VEC.codcli
inner join ". $_SESSION['server_vinculado']."VEVENDEDOR vended on vended.codven = VEC.codven
inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VED ON VED.nroped = VEC.nroped
INNER JOIN ". $_SESSION['server_vinculado']."VECONPAG CONPAG ON CONPAG.CONPAG=VEC.CONPAG
left outer join ". $_SESSION['server_vinculado']."MGDIRECTORIO direc on VEC.codcli = direc.coddir
left outer join ". $_SESSION['server_vinculado']."MGDIRECTORIO direcprin on direcprin.coddir = direc.coddir
INNER  join ". $_SESSION['server_vinculado']."ALART art ON VED.CODART=art.CODART
WHERE  VEC.tipped = 'VAB' AND CAST(VEC.fecped AS DATE ) >= '2018-10-31' and VEC.nroped = '$op' 
      

");
        $stmt->execute();
        $ops = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ops;
    }
    
    
    
    public function consultarCatporarticulo($cod) { // produccion 20200327
        $stmt = $this->objPdo->prepare("
               
select distinct descategoria
from (
select t1.codart,t1.idcartecnica, t1.valor, t2.item, t2.descaracteristica, t2.valcartecnica, t2.categoria , t2.descategoria
from ( select codart, idcartecnica, cast(valor as float) valor  from ". $_SESSION['server_vinculado']."alcartecnica    )  t1
inner join ( select t1.idcartecnica, t2.item, t1.descripcion descaracteristica, t2.descripcion valcartecnica, 
             t1.categoria , t3.descripcion descategoria  from ". $_SESSION['server_vinculado']."ALITEMCARTECNICAC t1
             inner join ". $_SESSION['server_vinculado']."ALITEMCARTECNICAD t2 on t2.idcartecnica = t1.idcartecnica
			 inner join ". $_SESSION['server_vinculado']."mgtabgend t3 on t3.codtabla = 309 and t3.codelemento = t1.categoria
			 where t1.tipo in ('002','003')  and t1.eliminado = 0 ) t2 
			 on t2.idcartecnica = t1.idcartecnica and t1.valor = t2.item
union all
select t1.codart,t1.idcartecnica, t1.valor, t2.item, t2.descaracteristica, cast(t1.valor as varchar(100)) valcartecnica, t2.categoria , t2.descategoria
from ( select codart, idcartecnica, cast(valor as float) valor from ". $_SESSION['server_vinculado']."alcartecnica ) t1
inner join ( select t1.idcartecnica, 0 item , t1.descripcion descaracteristica, '' valcartecnica, 
             t1.categoria , t3.descripcion descategoria  from ". $_SESSION['server_vinculado']."ALITEMCARTECNICAC t1
             inner join ". $_SESSION['server_vinculado']."mgtabgend t3 on t3.codtabla = 309 and t3.codelemento = t1.categoria
			 where t1.tipo in ('001')  and t1.eliminado = 0 ) t2 on t2.idcartecnica = t1.idcartecnica 
			 )tab20
			 where tab20.codart = '$cod'
			 ORDER BY tab20.descategoria
      

");
        $stmt->execute();
        $ops = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ops;
    }

    
        public function MostrarValorXCatporarticulo($cod) { // produccion 20200327
        $stmt = $this->objPdo->prepare("
               
select *
from (
select t1.codart,t1.idcartecnica, t1.valor, t2.item, t2.descaracteristica, t2.valcartecnica, t2.categoria , t2.descategoria
from ( select codart, idcartecnica, cast(valor as float) valor  from ". $_SESSION['server_vinculado']."alcartecnica    )  t1
inner join ( select t1.idcartecnica, t2.item, t1.descripcion descaracteristica, t2.descripcion valcartecnica, 
             t1.categoria , t3.descripcion descategoria  from ". $_SESSION['server_vinculado']."ALITEMCARTECNICAC t1
             inner join ". $_SESSION['server_vinculado']."ALITEMCARTECNICAD t2 on t2.idcartecnica = t1.idcartecnica
			 inner join ". $_SESSION['server_vinculado']."mgtabgend t3 on t3.codtabla = 309 and t3.codelemento = t1.categoria
			 where t1.tipo in ('002','003')  and t1.eliminado = 0 ) t2 
			 on t2.idcartecnica = t1.idcartecnica and t1.valor = t2.item
union all
select t1.codart,t1.idcartecnica, t1.valor, t2.item, t2.descaracteristica, cast(t1.valor as varchar(100)) valcartecnica, t2.categoria , t2.descategoria
from ( select codart, idcartecnica, cast(valor as float) valor from ". $_SESSION['server_vinculado']."alcartecnica ) t1
inner join ( select t1.idcartecnica, 0 item , t1.descripcion descaracteristica, '' valcartecnica, 
             t1.categoria , t3.descripcion descategoria  from ". $_SESSION['server_vinculado']."ALITEMCARTECNICAC t1
             inner join ". $_SESSION['server_vinculado']."mgtabgend t3 on t3.codtabla = 309 and t3.codelemento = t1.categoria
			 where t1.tipo in ('001')  and t1.eliminado = 0 ) t2 on t2.idcartecnica = t1.idcartecnica 
			 )tab20
			 where tab20.codart = '$cod'
			 ORDER BY tab20.idcartecnica
      

");
        $stmt->execute();
        $ops = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ops;
    }
  
  public function consultarNotaPed($op) { // produccion 20200327
        $stmt = $this->objPdo->prepare("
 

SELECT TABLA_INICIAL.*
	, PESO.peso_saco AS PESO_SACO--, ROUND( TABLA_INICIAL.PRE_18/PESO.peso_saco,4,0) AS PESO_KILO1
, ROUND( PREUNI/1.18,4,0) AS PRE_UNI_SIN_IGV, 
ROUND(IMPORTE/1.18,4,0) AS PRE_PAR_TOT_SIN_IGV, 
ROUND(IMPTOTAL/1.18,4,0) AS PRE_TOT_SIN_IGV, ROUND((IMPTOTAL/1.18)*0.18,4.0) AS IGV
,CASE WHEN PESO.peso_tela IS NULL THEN ROUND( TABLA_INICIAL.PRE_18_SACO/PESO.peso_saco,4,0)
when    PESO.peso_tela IS NULL and   PESO.peso_saco IS NULL   then   '1'

 ELSE 
ROUND(			( 
					(CAST (PRE_18_TELA AS FLOAT))
			    )
				/
				(	
					(	(CAST (PESO.ancho_tela AS FLOAT))*
						(CAST (PESO.largo_tela AS FLOAT))*
						( CAST (PESO.peso_tela AS FLOAT))
					) /
					(CAST ( 1000 AS FLOAT)
					)
				)
	,4,0)

END PESO_KILO_SOLES

,CASE WHEN PESO.peso_tela IS NULL THEN ROUND ( ((ROUND( TABLA_INICIAL.PRE_18_SACO/PESO.peso_saco,4,0))/TABLA_INICIAL.tccompra),4,0) 
when    PESO.peso_tela IS NULL and   PESO.peso_saco IS NULL   then   '1'
ELSE 
ROUND (((ROUND(			( 
					(CAST (PRE_18_TELA AS FLOAT))
			    )
				/
				(	
					(	(CAST (PESO.ancho_tela AS FLOAT))*
						(CAST (PESO.largo_tela AS FLOAT))*
						( CAST (PESO.peso_tela AS FLOAT))
					) /
					(CAST ( 1000 AS FLOAT)
					)
				)
	,4,0))/TABLA_INICIAL.tccompra),4,0)

END PESO_KILO
, TABLA_INICIAL.tccompra



FROM 

(


SELECT T2.NROPED, T2.FECPED, T2.CODCLI, 
	-- T4.NROID,
	T2.CODVEN, T5.DESCRIPCION DESCONPAG, T1.CODART, T1.UM, T1.CANTPED,
	T3.DESCRIPCION DESART, CASE WHEN T7.CODMON = T2.CODMON THEN T1.PREUNI ELSE T1.PREUNIME END PREUNI,
    CASE WHEN T7.CODMON = T2.CODMON THEN T1.IMPORTE ELSE T1.IMPORTEME END IMPORTE,
 	T6.DIRECCION, T1.ITEM,CASE WHEN T7.CODMON = T2.CODMON THEN T2.IMPTOTAL ELSE T2.IMPTOTALME END IMPTOTAL,
    CASE WHEN T7.CODMON = T2.CODMON THEN T2.DESCOM ELSE T2.DESCOMME END DESCOM,  t2.observacion, t2.fecori,
    ISNULL(T8.CODCLISEG,T2.codcli) CODCLISEG, ISNULL(T8.NOMCLISEG,T2.razonsocial) cltesegundario,
    ISNULL(T8.CODCLIPRIN,T2.codcli) CODCLIPRIN, ISNULL(T8.NOMCLIPRIN,T2.razonsocial) clteprincipal
	, CASE WHEN T7.CODMON = T2.CODMON THEN ((T1.preuni/1.18)*1000) ELSE ((T1.preuni/1.18)*1000) END PRE_18_SACO -- ((T1.preuni/1.18)*1000) AS PRE_18
	,T2.codmon AS CODMON
	, CASE WHEN T7.CODMON = T2.CODMON THEN ((T1.preuni/1.18)) ELSE ((T1.preuni/1.18)) END PRE_18_TELA
	, tc.tccompra

FROM ". $_SESSION['server_vinculado']."VEPEDIDOD T1 
INNER JOIN ". $_SESSION['server_vinculado']."VEPEDIDOC T2 ON T1.NROPED=T2.NROPED
inner join ". $_SESSION['server_vinculado']."CGTIPCAM TC on TC.fecha = t2.fecped
LEFT OUTER JOIN ". $_SESSION['server_vinculado']."ALART T3 ON T1.CODART=T3.CODART
--LEFT OUTER JOIN MGDIRECTORIO T4 ON T2.CODCLI=T4.CODDIR
LEFT OUTER JOIN ". $_SESSION['server_vinculado']."VECONPAG T5 ON T2.CONPAG=T5.CONPAG
LEFT OUTER JOIN ". $_SESSION['server_vinculado']."MGDIRECCION T6 ON T2.CODCLI=T6.CODDIR AND T6.ITEM=0
INNER JOIN ". $_SESSION['server_vinculado']."MGCIA T7 ON T7.CODCIA = T2.CODCIA
-- left outer join MGDIRECTORIO T8 on T8.coddir = T4.coddirprin
LEFT OUTER JOIN (select t1.coddir CODCLIPRIN, t1.razonsocial NOMCLIPRIN, t2.coddir CODCLISEG, t2.razonsocial NOMCLISEG
                        from ". $_SESSION['server_vinculado']."MGDIRECTORIO t1
                inner join  ". $_SESSION['server_vinculado']."MGDIRECTORIO t2 on t1.coddir = t2.coddirprin
                where t2.coddirprin > 0) T8 ON T8.CODCLISEG = T2.CODCLI

WHERE T1.NROPED='$op'

) AS TABLA_INICIAL
left JOIN
(
select PivotTable.codart  as codigo_arti,
	PivotTable.[54] as ancho_saco, PivotTable.[56] as largo_saco , PivotTable.[58] as peso_saco,
PivotTable.[116] as ancho_tela, PivotTable.[118] as largo_tela, PivotTable.[120] as peso_tela --nuevatabla. as     [58] ,  [120],[54],[56], [116],[118]



from (
select tabla1.codart, tabla1.idcartecnica, cast (tabla1.valor as float  )  as decimal1
 from
  (
select articulo.codart, item.idcartecnica, 
	CASE al.valor WHEN '' THEN '0' ELSE al.valor END AS valor
from (
select * from ". $_SESSION['server_vinculado']."ALART
	where estado = 'A' ) articulo
inner join (
select distinct codart
	from  ". $_SESSION['server_vinculado']."ALARTALM
	where codalm = '005' or codalm = '006'
			) almacen  on almacen.codart = articulo.codart
inner join ". $_SESSION['server_vinculado']."ALCARTECNICA al  on al.codart = almacen.codart
left join 
(SELECT *
	FROM ". $_SESSION['server_vinculado']."ALITEMCARTECNICAC a
			WHERE a.idcartecnica = '58' or a.idcartecnica = '120' or a.idcartecnica = '54' or a.idcartecnica = '56' 
			or a.idcartecnica = '116' or a.idcartecnica = '118'
			) as item on item.idcartecnica = al.idcartecnica
)  tabla1) tabla2
PIVOT(avg(decimal1) FOR [idcartecnica] IN(
                                                         [58] ,
                                                         [120],
                                                         [54],
                                                         [56],
                                                         [116],
                                                         [118])) AS PivotTable

) AS PESO ON  cast (PESO.codigo_arti as int) = cast (TABLA_INICIAL.codart as int)


      

");
        $stmt->execute();
        $ops = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ops;
    }
    

 public function consultarcomentarios($id_doc, $tipdoc) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
       
select *
from PROCOMENTARIOS
where procoment_id_doc = '$id_doc'  and procoment_tip_doc = '$tipdoc'
  

    ");
        $stmt->execute();
        $ops_coments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ops_coments;
    }
    
        public function insertarcoments($procoment_tip_doc, $procoment_id_doc, $procoment_id_usuario, $procoment_mensaje, $procoment_nickname_usuario) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROCOMENTARIOS 
            (procoment_tip_doc,procoment_id_doc, procoment_id_usuario, procoment_mensaje, procoment_nickname_usuario) 
                values ('$procoment_tip_doc','$procoment_id_doc','$procoment_id_usuario', '$procoment_mensaje', '$procoment_nickname_usuario')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
     public function consultarobs($id_doc) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
       
select *
from PROOBSERVACIONES
where proobs_id_doc = '$id_doc'  and proobs_tip_doc = 'PEDIDO'
  

    ");
        $stmt->execute();
        $ops_obs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ops_obs;
    }
    
    
    
            public function insertarobs($proobs_tip_doc, $proobs_id_doc, $proobs_id_usuario_obs, $proobs_msn_obs, $proobs_nickname_usr_obs) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROOBSERVACIONES 
            (proobs_tip_doc,proobs_id_doc, proobs_id_usuario_obs, proobs_msn_obs, proobs_nickname_usr_obs) 
                values ('$proobs_tip_doc','$proobs_id_doc','$proobs_id_usuario_obs', '$proobs_msn_obs', '$proobs_nickname_usr_obs')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
              public function corregirobs($idobs,$usuario_id,$usuario_nickname,$op,$estado) { //producción 2020
        $stmt = $this->objPdo->prepare("
            update    PROOBSERVACIONES 
            set proobs_id_usuario_corrig ='$usuario_id', proobs_nickname_usr_corrig = '$usuario_nickname',fecha_creacion_corrig = SYSDATETIME() , proobs_finalizado = '$estado'
            where proobs_id = '$idobs' and proobs_id_doc = '$op' ");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
     public function consultarDisenoActivo($id) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
       
select disedet.prodidet_id, disedet.prodi_id, disedet.prodidet_url,disedet.prodidet_version,dise.prodi_codart,dise.prodi_cliente
from PRODISENOSDET disedet
inner join PRODISENOS dise on dise.prodi_id = disedet.prodi_id and disedet.prodidet_vigente = '1'
where dise.prodi_codart = '$id'

    ");
        $stmt->execute();
        $diseno = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $diseno;
    }
    
    
               public function insertarAprob($prodped_op,$iddiseno, $prodped_tipaprob, $prodped_usr) { //producción 2020
        $stmt = $this->objPdo->prepare("
            insert into   PROPEDIDOAPROB 
            (prodped_op,prodidet_id,prodped_tipaprob, prodped_usr) 
                values ('$prodped_op','$iddiseno','$prodped_tipaprob','$prodped_usr')");
        $rows = $stmt->execute(array());
        return $rows;
    }
    
    
         public function consultarVbVentas($inicio, $fin) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
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
, art.codalt,diseno.*,CONPAG.descripcion as nomconpag,aprobado.prodped_id, aprobado.prodidet_id as disenoapro,observado.*,nivelaprobacion.numaprobaciones
,tablaimp.tabgendet_nombre
,aprobado.prodped_fecaprob

FROM ". $_SESSION['server_vinculado']."VEPEDIDOC VEC
inner join ". $_SESSION['server_vinculado']."ALALM ALMA ON ALMA.codalm = VEC.codalm
inner join (
select tc.codtabla, td.codelemento, td.descripcion
from ". $_SESSION['server_vinculado']."MGTABGENC  tc
inner join ". $_SESSION['server_vinculado']."MGTABGEND td on td.codtabla = tc.codtabla
where tc.codtabla = '015'
) estado on estado.codelemento = VEC.estado
inner join ". $_SESSION['server_vinculado']."VECLIENTE  clien on clien.codcli = VEC.codcli
inner join ". $_SESSION['server_vinculado']."VEVENDEDOR vended on vended.codven = VEC.codven
inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VED ON VED.nroped = VEC.nroped
 


    INNER JOIN ". $_SESSION['server_vinculado']."VECONPAG CONPAG ON CONPAG.CONPAG=VEC.CONPAG
    INNER  join ". $_SESSION['server_vinculado']."ALART art ON VED.CODART=art.CODART
        left join PROPEDIDOAPROB aprobado on  aprobado.prodped_op = VEC.nroped and aprobado.prodped_tipaprob = '1'
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

left join (
        select tabla.*, art.form_id from (
        SELECT val.*, imp.tabgendet_nombre FROM PROVALITEMSCARACT val
        inner join (
        select gendet.* from PROTABLAGEN gen
        inner join PROTABLAGENDET gendet on gendet.tabgen_id = gen.tabgen_id
        where gen.tabgen_id ='4'
        ) imp on val.valitemcarac_valor = imp.tabgendet_id
        WHERE  val.itemcaracsemi_id = '20'
        )tabla
        inner join PROARTSEMITERMINADO art on art.artsemi_id = tabla.artsemi_id
)tablaimp on tablaimp.form_id = VED.codart

LEFT JOIN (
select prodped_op, COUNT(prodped_op) as numaprobaciones
 from PROPEDIDOAPROB

 group by prodped_op


)as nivelaprobacion on  nivelaprobacion.prodped_op = VEC.nroped
WHERE  VEC.tipped = 'VAB' AND CAST(aprobado.prodped_fecaprob AS DATE ) >= '$inicio' AND CAST(aprobado.prodped_fecaprob AS DATE ) <= '$fin' and aprobado.prodped_id is not null and  observado.proobs_id_doc is null


        

    ");
        $stmt->execute();
        $ops = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ops;
    }
 
  public function consultarObservados($inicio, $fin) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
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
, art.codalt,diseno.*,CONPAG.descripcion as nomconpag,aprobado.prodped_id, aprobado.prodidet_id as disenoapro,observado.*
FROM ". $_SESSION['server_vinculado']."VEPEDIDOC VEC
inner join ". $_SESSION['server_vinculado']."ALALM ALMA ON ALMA.codalm = VEC.codalm
inner join (
select tc.codtabla, td.codelemento, td.descripcion
from ". $_SESSION['server_vinculado']."MGTABGENC  tc
inner join ". $_SESSION['server_vinculado']."MGTABGEND td on td.codtabla = tc.codtabla
where tc.codtabla = '015'
) estado on estado.codelemento = VEC.estado
inner join ". $_SESSION['server_vinculado']."VECLIENTE  clien on clien.codcli = VEC.codcli
inner join ". $_SESSION['server_vinculado']."VEVENDEDOR vended on vended.codven = VEC.codven
inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VED ON VED.nroped = VEC.nroped
    INNER JOIN ". $_SESSION['server_vinculado']."VECONPAG CONPAG ON CONPAG.CONPAG=VEC.CONPAG
    INNER  join ". $_SESSION['server_vinculado']."ALART art ON VED.CODART=art.CODART
        left join PROPEDIDOAPROB aprobado on  aprobado.prodped_op = VEC.nroped and (aprobado.prodped_tipaprob = '1' and aprobado.eliminado = '0')
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
WHERE  VEC.tipped = 'VAB' AND CAST(VEC.fecped AS DATE ) >= '$inicio' AND CAST(VEC.fecped AS DATE ) <= '$fin' and aprobado.prodped_id is not null and  observado.proobs_id_doc is not null


        

    ");
        $stmt->execute();
        $ops = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ops;
    }
 
    
    
    
//         public function consultarVbPlanificacion($inicio, $fin) { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
//        $stmt = $this->objPdo->prepare("
//       
//SELECT 
//VEC.nroped, VEC.codalm, cast (VEC.fecped as date) as fecped , VEC.estado, VEC.codcli, VEC.codven, VEC.conpag, VEC.codmon, VEC.tasaigv,
//VEC.razonsocial, VEC.direccion, VEC.nroid, VEC.observacion, cast ( fechaentrega as date ) as fechaentrega , VEC.occliente, VEC.valorventa,
//VEC.imptotal, VEC.factorc,
//ALMA.nombre,
//estado.descripcion,
//clien.lineacredito,
//vended.apellidos, vended.nombres,
//VED.codart, VED.desart, ved.cantped, VED.preuni, VED.coduser
//, art.codalt,diseno.*,CONPAG.descripcion as nomconpag,aprobado.prodped_id, aprobado.prodidet_id as disenoapro,observado.*,nivelaprobacion.numaprobaciones
//FROM ". $_SESSION['server_vinculado']."VEPEDIDOC VEC
//inner join ". $_SESSION['server_vinculado']."ALALM ALMA ON ALMA.codalm = VEC.codalm
//inner join (
//select tc.codtabla, td.codelemento, td.descripcion
//from ". $_SESSION['server_vinculado']."MGTABGENC  tc
//inner join ". $_SESSION['server_vinculado']."MGTABGEND td on td.codtabla = tc.codtabla
//where tc.codtabla = '015'
//) estado on estado.codelemento = VEC.estado
//inner join ". $_SESSION['server_vinculado']."VECLIENTE  clien on clien.codcli = VEC.codcli
//inner join ". $_SESSION['server_vinculado']."VEVENDEDOR vended on vended.codven = VEC.codven
//inner join ". $_SESSION['server_vinculado']."VEPEDIDOD VED ON VED.nroped = VEC.nroped
//    INNER JOIN ". $_SESSION['server_vinculado']."VECONPAG CONPAG ON CONPAG.CONPAG=VEC.CONPAG
//    INNER  join ". $_SESSION['server_vinculado']."ALART art ON VED.CODART=art.CODART
//        left join PROPEDIDOAPROB aprobado on  aprobado.prodped_op = VEC.nroped and aprobado.prodped_tipaprob = '2'
//        left join (
//SELECT proobs_id_doc, COUNT(proobs_id_doc) AS obs
//FROM PROOBSERVACIONES
//WHERE  proobs_finalizado = '0'
//GROUP BY proobs_id_doc
//
//) as observado on observado.proobs_id_doc =  VEC.nroped
//LEFT JOIN 
//(
//select disedet.prodidet_id, disedet.prodi_id, disedet.prodidet_url,disedet.prodidet_version,dise.prodi_codart,dise.prodi_cliente
//from PRODISENOSDET disedet
//inner join PRODISENOS dise on dise.prodi_id = disedet.prodi_id and disedet.prodidet_vigente = '1'
//) AS diseno
//on diseno.prodi_codart = VED.CODART
//
//LEFT JOIN (
//select prodped_op, COUNT(prodped_op) as numaprobaciones
// from PROPEDIDOAPROB
//
// group by prodped_op
//
//
//)as nivelaprobacion on  nivelaprobacion.prodped_op = VEC.nroped
//WHERE  VEC.tipped = 'VAB' AND CAST(VEC.fecped AS DATE ) >= '$inicio' AND CAST(VEC.fecped AS DATE ) <= '$fin' and aprobado.prodped_id is not null and  observado.proobs_id_doc is null
//
//
//        
//
//    ");
//        $stmt->execute();
//        $ops = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        return $ops;
//    }
// 
}

?>
