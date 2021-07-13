<?php

require_once 'conexion.php';

class extordentrabajo {

    private $extot_id;
    
    
    private $tipdoc_id;
    private $codempl;
    private $extot_peine;
    
    private $are_id;
    private $tur_id;
    private $maq_id;
    
    private $extot_fecdoc;
    private $extot_num_baj;
    private $tip_tubo;
    
    private $observacion;
    
    private $fecha_creacion;
    private $usuario_creacion;
    private $fecha_modificacion;
    private $usuario_modificacion;
    
    private $estado;    
    private $objPdo ;

    public function __construct( //producción 2020 14022020 165800
            $extot_id = NULL, 
            $tipdoc_id = '', 
            $codempl = '', 
            $extot_peine = '', 
            
            $are_id = '',
            $tur_id = '', 
            $maq_id = '',
            
            $extot_fecdoc = '',
            $extot_num_baj = '',
            $tip_tubo = '',
            
            $observacion = '',
            
            $fecha_creacion = '',
            $usuario_creacion = '', 
            $fecha_modificacion = '',
            $usuario_modificacion = '',
            
            $estado= ''
    ) {
        $this->extot_id = $extot_id;
        $this->tipdoc_id = $tipdoc_id;
        $this->codempl = $codempl;
        $this->extot_peine = $extot_peine;
        
        $this->are_id = $are_id;
        $this->tur_id = $tur_id;
        $this->maq_id= $maq_id;
        
        $this->extot_fecdoc = $extot_fecdoc;
        $this->extot_num_baj = $extot_num_baj;
        $this->tip_tubo= $tip_tubo;
      
        $this-> observacion =  $observacion;
        
        $this->fecha_creacion = $fecha_creacion;
        $this->usuario_creacion = $usuario_creacion;
        $this->fecha_modificacion = $fecha_modificacion;
        $this->usuario_modificacion = $usuario_modificacion;
        
        $this->estado = $estado;


        $this->objPdo = new Conexion();
    }


    
    public function consultar() { //producción 2020  14022020 172500
        $stmt = $this->objPdo->prepare("

SELECT OT.*, DOC.tipdoc_titulo, are.are_titulo,tur.tur_titulo, maq.maq_nombre, pes.pespro_descripcion--CLASI.itemcaractipmaq_descripcion
,desart.artsemi_id, desart.artsemi_descripcion, desart.artsemi_id2, desart.artsemi_descripcion2

FROM PROEXTORDENTRABAJO OT
INNER JOIN PROADMTIPDOCUMENTOS DOC ON DOC.tipdoc_id = OT.tipdoc_id
inner join PROMGAREAS are on are.are_referencia = OT.are_id
inner join PROADMTURNOS tur on tur.tur_id  = ot.tur_id
inner join PROMGMAQUINA maq on maq.maq_id = ot.maq_id
inner join PROPESOPRODUCT pes on pes.pespro_id = ot.tip_tubo

inner join 
(



select tabla01.* --, tabla02.artsemi_descripcion as artsemi_descripcion2 , tabla02.artsemi_id as artsemi_id2 
,case when  tabla02.artsemi_descripcion is null then '' else tabla02.artsemi_descripcion  end as artsemi_descripcion2
,case when  tabla02.artsemi_id is null then '' else  tabla02.artsemi_id  end as artsemi_id2


from (
		select det.extot_id,det.artsemi_id, art.artsemi_descripcion
		from PROEXTORDENTRABAJODET DET
		INNER  join PROARTSEMITERMINADO art on art.artsemi_id= DET.artsemi_id
		where extotdet_items = '1'
)tabla01
left join (
		select det.extot_id,det.artsemi_id, art.artsemi_descripcion
		from PROEXTORDENTRABAJODET DET
		INNER  join PROARTSEMITERMINADO art on art.artsemi_id= DET.artsemi_id
		where extotdet_items= '2'

)tabla02 on tabla01.extot_id = tabla02.extot_id


) as desart on desart.extot_id = ot.extot_id
where ot.eliminado = '0'
                
                ");
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
    
        
    public function consultarXfecha($ini,$fin) { //producción 2020  14022020 172500
        $stmt = $this->objPdo->prepare("

SELECT OT.*, DOC.tipdoc_titulo, are.are_titulo,tur.tur_titulo, maq.maq_nombre, pes.pespro_descripcion--CLASI.itemcaractipmaq_descripcion
,desart.artsemi_id, desart.artsemi_descripcion, desart.artsemi_id2, desart.artsemi_descripcion2

FROM PROEXTORDENTRABAJO OT
INNER JOIN PROADMTIPDOCUMENTOS DOC ON DOC.tipdoc_id = OT.tipdoc_id
inner join PROMGAREAS are on are.are_referencia = OT.are_id
inner join PROADMTURNOS tur on tur.tur_id  = ot.tur_id
inner join PROMGMAQUINA maq on maq.maq_id = ot.maq_id
inner join PROPESOPRODUCT pes on pes.pespro_id = ot.tip_tubo

inner join 
(



select tabla01.* --, tabla02.artsemi_descripcion as artsemi_descripcion2 , tabla02.artsemi_id as artsemi_id2 
,case when  tabla02.artsemi_descripcion is null then '' else tabla02.artsemi_descripcion  end as artsemi_descripcion2
,case when  tabla02.artsemi_id is null then '' else  tabla02.artsemi_id  end as artsemi_id2


from (
		select det.extot_id,det.artsemi_id, art.artsemi_descripcion
		from PROEXTORDENTRABAJODET DET
		INNER  join PROARTSEMITERMINADO art on art.artsemi_id= DET.artsemi_id
		where extotdet_items = '1'
)tabla01
left join (
		select det.extot_id,det.artsemi_id, art.artsemi_descripcion
		from PROEXTORDENTRABAJODET DET
		INNER  join PROARTSEMITERMINADO art on art.artsemi_id= DET.artsemi_id
		where extotdet_items= '2'

)tabla02 on tabla01.extot_id = tabla02.extot_id


) as desart on desart.extot_id = ot.extot_id
where ot.eliminado = '0' and cast (OT.extot_fecdoc as date)>='$ini' and cast(ot.extot_fecdoc as date)<= '$fin' and cast(ot.extot_fecdoc as date) > '2020-10-02'
                
                ");
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
    
    
        public function consultar2() { //producción 2020  14022020 172500
        $stmt = $this->objPdo->prepare("

SELECT OT.*, DOC.tipdoc_titulo, are.are_titulo,tur.tur_titulo, maq.maq_nombre,  pes.pespro_descripcion -- CLASI.itemcaractipmaq_descripcion
FROM PROEXTORDENTRABAJO OT
INNER JOIN PROADMTIPDOCUMENTOS DOC ON DOC.tipdoc_id = OT.tipdoc_id
inner join PROMGAREAS are on are.are_referencia = OT.are_id
inner join PROADMTURNOS tur on tur.tur_id  = ot.tur_id
inner join PROMGMAQUINA maq on maq.maq_id = ot.maq_id
inner join PROPESOPRODUCT pes on pes.pespro_id = ot.tip_tubo
--INNER JOIN PROITEMCARACTTIPMAQUINA CLASI ON CLASI.itemcaractipmaq_id = OT.tip_tubo
where ot.eliminado = '0'
                
                ");
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
    
  
    public function obtenerxId($extot_id) { //producción 2020 140220 173700
        $stmt = $this->objPdo->prepare('SELECT *, CAST (extot_fecdoc as date) as fechadoc
 
   FROM PROEXTORDENTRABAJO WHERE extot_id = :extot_id');
        $stmt->execute(array('extot_id' => $extot_id));
        $extordentrabajo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($extordentrabajo as $lista) {
            $this->setExtot_id ($lista['extot_id']);
            $this->setTipdoc_id($lista['tipdoc_id']);
            $this->setCodempl($lista['codempl']);
            $this->setExtot_peine($lista['extot_peine']);
            
            
            $this->setAre_id($lista['are_id']);
            $this->setTur_id($lista['tur_id']);
            $this->setMaq_id($lista['maq_id']);
            
            $this->setExtot_fecdoc($lista['fechadoc']);
             $this->setExtot_num_baj($lista['extot_num_baj']);
            $this->setTip_tubo($lista['tip_tubo']);
            
            $this->setObservacion($lista['observacion']);
            
            $this->setFecha_creacion($lista['fecha_creacion']);
             $this->setUsuario_creacion($lista['usuario_creacion']);
            $this->setFecha_modificacion($lista['fecha_modificacion']);
            $this->setUsuario_modificacion($lista['usuario_modificacion']);
            
            $this->setEstado($lista['estado']);

        }
        return $this;
    }

    
     public function insertar() {  //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROEXTORDENTRABAJO 
            (tipdoc_id, 
            codempl,
            extot_peine, 
            
            are_id, 
            tur_id,
            maq_id,
            
            extot_fecdoc, 
            extot_num_baj,
            tip_tubo,
            usuario_creacion,
            usuario_modificacion,
            
            observacion ) 
                            VALUES(:tipdoc_id,
                                   :codempl,
                                   :extot_peine,

                                   :are_id,
                                   :tur_id,
                                   :maq_id,

                                   :extot_fecdoc,
                                   :extot_num_baj,
                                   :tip_tubo,
                                   
                                   :usuario_creacion,
                                   :usuario_modificacion,

                                   :observacion)');
        $rows = $stmt->execute(array(
            'tipdoc_id' => $this->tipdoc_id,
            'codempl' => $this->codempl,
            'extot_peine' => $this->extot_peine,
            
            'are_id' => $this->are_id,
            'tur_id' => $this->tur_id,
            'maq_id' => $this->maq_id,
            
            'extot_fecdoc' => $this->extot_fecdoc,
            'extot_num_baj' => $this->extot_num_baj,
            'tip_tubo' => $this->tip_tubo,
            
            'usuario_creacion' => $this->usuario_creacion,
            'usuario_modificacion' => $this->usuario_modificacion,
            
            'observacion' => $this->observacion
          
                ));
    }
    
    
    
    public function modificar() { //producción 2020 140220 175700
        $stmt = $this->objPdo->prepare("UPDATE PROEXTORDENTRABAJO SET 
           
            
            tipdoc_id=:tipdoc_id, 
            codempl=:codempl,
            extot_peine=:extot_peine, 
            
            are_id=:are_id,
            tur_id=:tur_id, 
            maq_id=:maq_id, 
            
            extot_fecdoc=:extot_fecdoc, 
            extot_num_baj=:extot_num_baj,
            tip_tubo=:tip_tubo,
            
            observacion=:observacion,
             
            
            fecha_modificacion = SYSDATETIME(), 
            usuario_modificacion=:usuario_modificacion
            
            WHERE extot_id =:extot_id");
        $rows = $stmt->execute(array(
            'tipdoc_id' => $this->tipdoc_id,
            'codempl' => $this->codempl,
            'extot_peine' => $this->extot_peine,
            
            'are_id' => $this->are_id,
            'tur_id' => $this->tur_id,
            'maq_id' => $this->maq_id,
            
            'extot_fecdoc' => $this->extot_fecdoc,
            'extot_num_baj' => $this->extot_num_baj,
            'tip_tubo' => $this->tip_tubo,
            
            'observacion' => $this->observacion,
            
           // 'fecha_modificacion' => $this->fecha_modificacion,
            'usuario_modificacion' => $this->usuario_modificacion,
             'extot_id' => $this->extot_id));
    }


      public function eliminar($extot_id) { //producción 19022020  145800
        $stmt = $this->objPdo->prepare("update  PROEXTORDENTRABAJO set eliminado = '1' WHERE extot_id=:extot_id");
        $rows = $stmt->execute(array('extot_id' => $extot_id));
        return $rows;
    }

        public function ValidarExtOT($extot_id) { //producción 19022020 164500
        $stmt = $this->objPdo->prepare("
     select *
	from PROEXTORDENTRABAJODET
	where extot_id = '$extot_id'
                
                ");
        $stmt->execute();
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lista;
    }
  
      public function insertardetalle($extot_id,$items,$lado,$semiterminado,$tipcinta,$value,$formulacion_actual) { // produccion 19022020 153000
        $stmt = $this->objPdo->prepare("
 insert into PROEXTORDENTRABAJODET
(extot_id,extotdet_items,extotdet_lado,artsemi_id,extotdet_tipcinta,extotdet_num_baj,extotdet_formulacion)
values ('$extot_id','$items','$lado','$semiterminado','$tipcinta','$value','$formulacion_actual')");
        
        $insertdet = $stmt->execute();
        return $insertdet;
    }
    
    
    public function insertardetalleproduc($extot_id,$extotdet_id,$usr_nickname,$index1) { // produccion 19022020 154500
        $stmt = $this->objPdo->prepare("
 insert into PROEXTORDENTRABAJOPRODUCCION
(extot_id,extotdet_id,usuario_creacion, extotdet_items)
values ('$extot_id','$extotdet_id','$usr_nickname', '$index1')");
        
        $insertdet_prod = $stmt->execute();
        return $insertdet_prod;
    }
          public function consultarUltimoIDextot() { // produccion 19022020 165200
        $stmt = $this->objPdo->prepare("
            select top 1 *
from PROEXTORDENTRABAJO
order by extot_id desc
 ");
        $stmt->execute();
        $ot = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ot;
    }
    
    
        public function consultarUltimoIDextotdet() { // produccion 19022020 172600
        $stmt = $this->objPdo->prepare("
            select top 1 *
from PROEXTORDENTRABAJODET
order by extotdet_id desc
 ");
        $stmt->execute();
        $ot = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ot;
    }
    
      public function listardetalleot($id_ot) { // produccion 19022020 172600
        $stmt = $this->objPdo->prepare("
    SELECT EXT.*, ARTS.artsemi_descripcion
FROM PROEXTORDENTRABAJODET EXT
INNER JOIN PROARTSEMITERMINADO ARTS ON ARTS.artsemi_id = EXT.artsemi_id
WHERE extot_id = '$id_ot' and  ext.eliminado = '0'
 ");
        $stmt->execute();
        $ot_det = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ot_det;
    }
    
    
        public function listardetalleotProducc($id_ot, $id_otdet) { // produccion 19022020 172600
        $stmt = $this->objPdo->prepare("
SELECT *
FROM  PROEXTORDENTRABAJOPRODUCCION
WHERE (extotdet_id = '$id_otdet' and extot_id = '$id_ot') and eliminado = '0'
order by extotdet_items, estado
 ");
        $stmt->execute();
        $ot_det_pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ot_det_pro;
    }
    
       public function registrar_produccionOT($extotpro_id,$numcaja,$numbob,$peso, $usuario,$estado,$barcode,$extotpro_tiptubo,$extotpro_tipenvase,$extotpro_numcarro,$peso_dest) { // produccion 2019
        $stmt = $this->objPdo->prepare("
 update PROEXTORDENTRABAJOPRODUCCION set 
 extotpro_numcaja= '$numcaja', extotpro_numbob = '$numbob', extotpro_peso = '$peso',
     usuario_creacion = '$usuario', estado = '$estado', codbarra = '$barcode', fecha_creacion = sysdatetime(), 
         extotpro_tiptubo = '$extotpro_tiptubo',extotpro_tipenvase = '$extotpro_tipenvase' ,extotpro_numcarro = '$extotpro_numcarro',extotpro_pesodest = '$peso_dest'
         where extotpro_id = '$extotpro_id'
 ");
        
        $lista = $stmt->execute();
        return $lista;
    }
    
       public function update_produccionOT($extotpro_id,$estado ,$usr_nickname) { // produccion 2019
        $stmt = $this->objPdo->prepare("
 update PROEXTORDENTRABAJOPRODUCCION  set 
 eliminado = '$estado' , usuario_creacion = '$usr_nickname'
where extotpro_id = '$extotpro_id'
 ");
        
        $lista = $stmt->execute();
        return $lista;
    }
    
        public function insertarCANTLote($artsemi_id,$lote,$artlot_cantinicial,$artlot_cantfinal,$usuario_creacion ,$artlot_cajinicial,$artlot_cajfinal,$artlot_bobinicial,$artlot_bobfinal) { // produccion 09032020 111800
        $stmt = $this->objPdo->prepare("
 insert into PROARTLOTE
(artsemi_id,artlot_numerolot, artlot_cantinicial,artlot_cantfinal ,usuario_creacion
,artlot_cajinicial,artlot_cajfinal,artlot_bobinicial,artlot_bobfinal)
values ('$artsemi_id','$lote','$artlot_cantinicial','$artlot_cantfinal', '$usuario_creacion','$artlot_cajinicial','$artlot_cajfinal','$artlot_bobinicial','$artlot_bobfinal')");
        
        $insertart_lote = $stmt->execute();
        return $insertart_lote;
    }
    
 public function kardexsSEMITERMINADO(
         $are_cod,$tipdoc_id,$promov_fecmov,$artsemi_id,$promov_und_med,$promov_cant_mov,$promov_cost_unit,$usuario_creacion,$usuario_modificacion,$promov_lote,$promov_kamban) { // produccion 09032020 111800
        $stmt = $this->objPdo->prepare("
 insert into PROMOVIMIENTOPRODUC
(are_cod,tipdoc_id, promov_fecmov,artsemi_id, promov_und_med,
promov_cant_mov,promov_cost_unit ,usuario_creacion,usuario_modificacion,promov_lote, promov_kamban)
values ('$are_cod','$tipdoc_id', convert (datetime,'$promov_fecmov',103),'$artsemi_id','$promov_und_med', '$promov_cant_mov','$promov_cost_unit', '$usuario_creacion', '$usuario_modificacion', '$promov_lote','$promov_kamban')");
        
        $kardexs = $stmt->execute();
        return $kardexs;
    }
   
           public function regsalidacinta( $id) { // produccion 10032020 172600
        $stmt = $this->objPdo->prepare("
	  select lot.*, prod.extotpro_numcarro, prod.extotpro_tiptubo, prod.extotpro_tipenvase, carro.pespro_peso as pesocarro, tubo.pespro_peso as pesotubo
		 ,envase.pespro_peso as pesoenvase
                  ,semi.artsemi_descripcion
from PROARTLOTE lot
inner join  PROEXTORDENTRABAJOPRODUCCION  prod on prod.codbarra = lot.artlot_numerolot
inner join PROPESOPRODUCT carro on carro.pespro_id = prod.extotpro_numcarro
inner join PROPESOPRODUCT tubo on tubo.pespro_id = prod.extotpro_tiptubo
inner join PROPESOPRODUCT envase on envase.pespro_id = prod.extotpro_tipenvase
inner join PROARTSEMITERMINADO semi on semi.artsemi_id = lot.artsemi_id

where artlot_numerolot = '$id' and lot.eliminado = '0'
 ");
        $stmt->execute();
        $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pro;
    }
    
                public function regsalidacintaXart( $id) { // produccion 10032020 172600
        $stmt = $this->objPdo->prepare("
		  select TOP 1 lot.*, prod.extotpro_numcarro, prod.extotpro_tiptubo, prod.extotpro_tipenvase, carro.pespro_peso as pesocarro, tubo.pespro_peso as pesotubo
		 ,envase.pespro_peso as pesoenvase
from PROARTLOTE lot
inner join  PROEXTORDENTRABAJOPRODUCCION  prod on prod.codbarra = lot.artlot_numerolot
inner join PROPESOPRODUCT carro on carro.pespro_id = prod.extotpro_numcarro
inner join PROPESOPRODUCT tubo on tubo.pespro_id = prod.extotpro_tiptubo
inner join PROPESOPRODUCT envase on envase.pespro_id = prod.extotpro_tipenvase
where artsemi_id = '$id' and (lot.artlot_cantinicial-lot.artlot_cantfinal)>0 and (lot.artlot_cajinicial-lot.artlot_cajfinal)>0 and (lot.artlot_bobinicial-lot.artlot_bobfinal)>0
     and CAST(lot.fecha_creacion as date)>'2020-10-02'
ORDER BY  artlot_numerolot DESC

 ");
        $stmt->execute();
        $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pro;
    }
    
 public function update_LOTEart($artlot_id,$numcaj ,$numbob, $numkil) { // produccion 11032020 1649
$stmt = $this->objPdo->prepare("
update PROARTLOTE  set 
artlot_cajfinal = '$numcaj' , artlot_bobfinal = '$numbob' , artlot_cantfinal = '$numkil'
where artlot_id = '$artlot_id'
 ");
        
        $lista = $stmt->execute();
        return $lista;
    }
    
    
    
                 public function kardexs( $inicio,  $fin , $art) { // produccion 10032020 172600
        $stmt = $this->objPdo->prepare("

select  mov.promov_id,mov.tipdoc_id, cast(mov.promov_fecmov as date ) as fecdoc, mov.artsemi_id,mov.promov_cant_mov, mov.usuario_creacion, mov.promov_lote
,mov.promov_kamban, docs.tipdoc_titulo, art.artsemi_descripcion,  sum(sum(promov_cant_mov)) over (order  by promov_id asc) as acumulado, docs.tipdoc_tipletra
from PROMOVIMIENTOPRODUC mov
inner join PROADMTIPDOCUMENTOS docs on docs.tipdoc_id=mov.tipdoc_id
inner join PROARTSEMITERMINADO art on art.artsemi_id = mov.artsemi_id
where cast (mov.promov_fecmov as date ) <= '$fin' and cast (mov.promov_fecmov as date ) >= '$inicio' and mov.artsemi_id= '$art' AND  cast(mov.promov_fecmov as date )>'2020-10-02'
AND MOV.eliminado= '0'
group by  mov.promov_id,mov.tipdoc_id,mov.promov_fecmov, mov.artsemi_id,mov.promov_cant_mov, mov.usuario_creacion, mov.promov_lote
,mov.promov_kamban, docs.tipdoc_titulo, art.artsemi_descripcion, docs.tipdoc_tipletra


 ");
        $stmt->execute();
        $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pro;
    } 
    
                 public function SaldoInicial( $fecha , $art) { // produccion 10032020 172600
        $stmt = $this->objPdo->prepare("
	SELECT artsemi_id, SUM(promov_cant_mov) AS stock
		FROM PROMOVIMIENTOPRODUC
		where cast (promov_fecmov as date ) <= '$fecha' and artsemi_id = '$art' AND  cast (promov_fecmov as date ) > '2020-10-03'
		GROUP BY artsemi_id

 ");
        $stmt->execute();
        $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pro;
    }
    
    
                     public function FormulacionActual( $art) { // produccion 10032020 172600
        $stmt = $this->objPdo->prepare("

select * from PROVALITEMSCARACT
where artsemi_id = '$art' and itemcaracsemi_id='5'

 ");
        $stmt->execute();
        $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pro;
    }
    
                     public function OtItemsCodBarras( $barras) { // produccion 10032020 172600
        $stmt = $this->objPdo->prepare("

SELECT * FROM PROEXTORDENTRABAJOPRODUCCION WHERE codbarra = '$barras'



 ");
        $stmt->execute();
        $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pro;
    }
    
                         public function OtItemsCod( $cod) { // produccion 10032020 172600
        $stmt = $this->objPdo->prepare("

SELECT * FROM PROEXTORDENTRABAJOPRODUCCION WHERE extotpro_id = '$cod'



 ");
        $stmt->execute();
        $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pro;
    }
    
    function getExtot_id() {
        return $this->extot_id;
    }

    function getTipdoc_id() {
        return $this->tipdoc_id;
    }

    function getCodempl() {
        return $this->codempl;
    }

    function getExtot_peine() {
        return $this->extot_peine;
    }

    function getAre_id() {
        return $this->are_id;
    }

    function getTur_id() {
        return $this->tur_id;
    }

    function getMaq_id() {
        return $this->maq_id;
    }

    function getExtot_fecdoc() {
        return $this->extot_fecdoc;
    }

    function getExtot_num_baj() {
        return $this->extot_num_baj;
    }

    function getTip_tubo() {
        return $this->tip_tubo;
    }

    function getObservacion() {
        return $this->observacion;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getUsuario_creacion() {
        return $this->usuario_creacion;
    }

    function getFecha_modificacion() {
        return $this->fecha_modificacion;
    }

    function getUsuario_modificacion() {
        return $this->usuario_modificacion;
    }

    function getEstado() {
        return $this->estado;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setExtot_id($extot_id) {
        $this->extot_id = $extot_id;
    }

    function setTipdoc_id($tipdoc_id) {
        $this->tipdoc_id = $tipdoc_id;
    }

    function setCodempl($codempl) {
        $this->codempl = $codempl;
    }

    function setExtot_peine($extot_peine) {
        $this->extot_peine = $extot_peine;
    }

    function setAre_id($are_id) {
        $this->are_id = $are_id;
    }

    function setTur_id($tur_id) {
        $this->tur_id = $tur_id;
    }

    function setMaq_id($maq_id) {
        $this->maq_id = $maq_id;
    }

    function setExtot_fecdoc($extot_fecdoc) {
        $this->extot_fecdoc = $extot_fecdoc;
    }

    function setExtot_num_baj($extot_num_baj) {
        $this->extot_num_baj = $extot_num_baj;
    }

    function setTip_tubo($tip_tubo) {
        $this->tip_tubo = $tip_tubo;
    }

    function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setUsuario_creacion($usuario_creacion) {
        $this->usuario_creacion = $usuario_creacion;
    }

    function setFecha_modificacion($fecha_modificacion) {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    function setUsuario_modificacion($usuario_modificacion) {
        $this->usuario_modificacion = $usuario_modificacion;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }


    

    
 
    
  
    
    
    
}

?>
