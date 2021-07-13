<?php

require_once 'conexion.php';

class maquinas {

    private $maq_id;
    private $maq_nombre;
    private $maq_estado;
    private $maq_fec_adq;
    private $maq_fec_pue_mar;
    private $maq_vid_util;
    private $maq_porce_depreanual;
    private $maq_valor_adqui;
//    private $eliminado;
    private $usr_id;
    private $are_id;
    private $fecha_creacion;
    private $objPdo;

    public function __construct(
            $maq_id = NULL, 
            $maq_nombre = '', 
            $maq_estado = '', 
            $maq_fec_adq = '', 
            $maq_fec_pue_mar = '', 
            $maq_vid_util = '', 
            $maq_porce_depreanual = '', 
            $maq_valor_adqui = '', 
//            $eliminado = '', 
            $usr_id = '', 
            $are_id = '', 
            $fecha_creacion = ''
    ) {
        $this->maq_id = $maq_id;
        $this->maq_nombre = $maq_nombre;
        $this->maq_estado = $maq_estado;
        $this->maq_fec_adq = $maq_fec_adq;
        $this->maq_fec_pue_mar = $maq_fec_pue_mar;
        $this->maq_vid_util = $maq_vid_util;
        $this->maq_porce_depreanual = $maq_porce_depreanual;
        $this->maq_valor_adqui = $maq_valor_adqui;
//        $this->eliminado = $eliminado;
        $this->usr_id = $usr_id;
        $this->are_id = $are_id;
        $this->fecha_creacion = $fecha_creacion;


        $this->objPdo = new Conexion();
    }

    
    
    
    
    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("
  SELECT MAQ.*, ARE.are_id, ARE.are_titulo, maqfam.maq_id as maq_id2
  FROM PROMGMAQUINA MAQ
  inner join PROMGAREAS ARE on MAQ.are_id = ARE.are_id
    left  join PROMAQUINAFAMILIA maqfam on maqfam.maq_id = MAQ.maq_id
   where ARE.eliminado = '0' and MAQ.eliminado = '0'  ORDER BY MAQ.maq_nombre;
                
                ");
        $stmt->execute();
        $maquinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $maquinas;
    }
    
    
        public function ConsultarxArea($id) { //producción 2019
        $stmt = $this->objPdo->prepare("
  SELECT MAQ.*, ARE.are_id, ARE.are_titulo
  FROM PROMGMAQUINA MAQ
  inner join PROMGAREAS ARE on MAQ.are_id = ARE.are_id
   where ARE.eliminado = '0' and MAQ.eliminado = '0'  and  ARE.are_id = '$id' ORDER BY MAQ.maq_nombre;
                
                ");
        $stmt->execute();
        $maquinasxarea = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $maquinasxarea;
    }
    

    public function obtenerxId($maquina_id) { //producción 2019
        $stmt = $this->objPdo->prepare('SELECT maq_id, maq_nombre, maq_estado, maq_vid_util, maq_porce_depreanual, maq_valor_adqui, eliminado, usr_id, are_id, fecha_creacion,
    CONVERT (date , maq_fec_adq) as maq_fec_adq,  CONVERT (date , maq_fec_pue_mar) as maq_fec_pue_mar
   FROM PROMGMAQUINA WHERE maq_id = :maq_id');
        $stmt->execute(array('maq_id' => $maquina_id));
        $maquinas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($maquinas as $maquina) {
            $this->setMaq_id ($maquina['maq_id']);
            $this->setMaq_nombre($maquina['maq_nombre']);
            $this->setMaq_estado($maquina['maq_estado']);
            $this->setMaq_fec_adq($maquina['maq_fec_adq']);
            $this->setMaq_fec_pue_mar($maquina['maq_fec_pue_mar']);
            $this->setMaq_vid_util($maquina['maq_vid_util']);
            $this->setMaq_porce_depreanual($maquina['maq_porce_depreanual']);
            $this->setMaq_valor_adqui($maquina['maq_valor_adqui']);
            $this->setEliminado($maquina['eliminado']);
            $this->setUsr_id($maquina['usr_id']);
            $this->setAre_id($maquina['are_id']);
            $this->setFecha_creacion($maquina['fecha_creacion']);
        }
        return $this;
    }

     public function insertar() {  //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROMGMAQUINA 
            (maq_nombre, maq_estado, maq_fec_adq, maq_fec_pue_mar, maq_vid_util, 
            maq_porce_depreanual, maq_valor_adqui, usr_id,  are_id) 
                                        VALUES(:maq_nombre,
                                               :maq_estado,
                                               :maq_fec_adq,
                                               :maq_fec_pue_mar,
                                               :maq_vid_util,
                                               :maq_porce_depreanual,
                                               :maq_valor_adqui,
                                               :usr_id,
                                               :are_id)');
        $rows = $stmt->execute(array(
            'maq_nombre' => $this->maq_nombre,
            'maq_estado' => $this->maq_estado,
            'maq_fec_adq' => $this->maq_fec_adq,
            'maq_fec_pue_mar' => $this->maq_fec_pue_mar,
            'maq_vid_util' => $this->maq_vid_util,
            'maq_porce_depreanual' => $this->maq_porce_depreanual,
            'maq_valor_adqui' => $this->maq_valor_adqui,
            'usr_id' => $this->usr_id,
            'are_id' => $this->are_id));
    }
    
public function modificar() { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROMGMAQUINA SET 
            maq_nombre=:maq_nombre, 
            maq_estado=:maq_estado, 
            maq_fec_adq=:maq_fec_adq, 
            maq_fec_pue_mar=:maq_fec_pue_mar, 
            maq_vid_util=:maq_vid_util, 
            maq_porce_depreanual=:maq_porce_depreanual, 
            maq_valor_adqui=:maq_valor_adqui, 
            usr_id=:usr_id, 
            are_id=:are_id, 
            fecha_creacion = SYSDATETIME()         
            WHERE maq_id = :maq_id");
        $rows = $stmt->execute(array(
            'maq_nombre' => $this->maq_nombre,
            'maq_estado' => $this->maq_estado,
            'maq_fec_adq' => $this->maq_fec_adq,
            'maq_fec_pue_mar' => $this->maq_fec_pue_mar,
            'maq_vid_util' => $this->maq_vid_util,
            'maq_porce_depreanual' => $this->maq_porce_depreanual,
            'maq_valor_adqui' => $this->maq_valor_adqui,
            'usr_id' => $this->usr_id,
            'are_id' => $this->are_id,
            
            'maq_id' => $this->maq_id));
    }

       public function depresiacion($maquina_id) { //producción 2019
        $stmt = $this->objPdo->prepare("
  select depre.*, (depre.maq_valor_adqui - depre.depresiacion_acumulada) as depresiacion_residual, (CAST (depre.depresiacion_anual as float)/ CAST(12 as float)) as depresiacion_mensual
  from (
   SELECT maq_id, maq_nombre, maq_estado, maq_vid_util, maq_porce_depreanual, maq_valor_adqui, eliminado, usr_id, are_id, fecha_creacion,
    CONVERT (date , maq_fec_adq) as maq_fec_adq,  CONVERT (date , maq_fec_pue_mar) as maq_fec_pue_mar, 
	maq_valor_adqui*(cast ((DATEDIFF (DAY,maq_fec_pue_mar,GETDATE()) ) as float) / cast (3653 as float)) as depresiacion_acumulada,
	CAST(maq_valor_adqui AS FLOAT)*CAST(( CAST (maq_porce_depreanual AS FLOAT) / CAST (100 AS FLOAT)) AS FLOAT) AS depresiacion_anual
   FROM PROMGMAQUINA WHERE maq_id = '$maquina_id'
   ) as depre
                
                ");
        $stmt->execute();
        $maquinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $maquinas;
    }
    
    
        public function Listarmeta() { //producción 2019
        $stmt = $this->objPdo->prepare("
                    select met.* , maq.maq_nombre
		  from    PROMGMAQUINAMETA met
		  inner join    PROMGMAQUINA maq on maq.maq_id = met.maq_id
                
                ");
        $stmt->execute();
        $parada = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $parada;
    }
    
    
       public function getmaquina($are_id) {//producción 2019
        $stmt = $this->objPdo->prepare("
select *
from PROMGMAQUINA
where are_id = '$are_id'
                
                ");
        $stmt->execute();
        $maquinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $maquinas;
    } 
    
    


    public function eliminarespera($submenu_id) {
        $stmt = $this->objPdo->prepare("UPDATE PROMGSUBMENU SET ELIMINADO = '1'  WHERE submenu_id = :submenu_id");
        $rows = $stmt->execute(array('submenu_id' => $submenu_id));
        return $rows;
    }

    
    
      public function ConsultarxAreaReferencia($idrefe, $emp) { //producción 2019
        $stmt = $this->objPdo->prepare("
  select tabla03.maq_id, tabla03.maq_nombre, tabla03.maq_estado, tabla03.are_id, tabla03.are_titulo,  case when tabla03.maqcol_id  is null then '0' else  tabla03.maqcol_id end as maqcol_id,
    case when tabla03.coddir  is null then '0' else  tabla03.coddir end as coddir,  case when tabla03.estado  is null then '0' else  tabla03.estado end as estado,
	    case when tabla03.maq_id2  is null then '0' else  tabla03.maq_id2 end as maq_id2
  from (
   select *  from 
            ( select maq.maq_id ,maq.maq_nombre, maq.maq_estado, maq.are_id , are.are_titulo
              from PROMGMAQUINA maq
              inner join PROMGAREAS are on are.are_id = maq.are_id
              where  (ARE.eliminado = '0' and MAQ.eliminado = '0' and ARE.are_referencia = '$idrefe') ) tabla01
   left join 
            (select mc.maqcol_id,mc.coddir,mc.estado ,mc.maq_id as maq_id2
             from PROMAQUINACOLAB mc
             inner join PROMGMAQUINA  maqu on maqu.maq_id = mc.maq_id
             inner join PROMGAREAS area on area.are_id = maqu.are_id
             where coddir = '$emp' and are_referencia = '$idrefe') tabla02 on tabla02.maq_id2 = tabla01.maq_id )tabla03
 ");
        $stmt->execute();
        $maquinasxarea = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $maquinasxarea;
    }
    
    
            public function ConsultarxAreaReferencia2($idrefe, $emp) { //producción 2019 , sustiruido por la funcion anterior
        $stmt = $this->objPdo->prepare("

  SELECT MAQ.*, ARE.are_id, ARE.are_titulo, ARE.are_referencia, maqcol.coddir, maqcol.estado, maqcol.maqcol_id
  FROM PROMGMAQUINA MAQ
  inner join PROMGAREAS ARE on MAQ.are_id = ARE.are_id
  left join PROMAQUINACOLAB maqcol on (maqcol.maq_id = MAQ.maq_id)
   where  (ARE.eliminado = '0' and ARE.are_referencia = '$idrefe')  or maqcol.coddir = '$emp' 
   
     ORDER BY MAQ.maq_nombre;
                
                ");
        $stmt->execute();
        $maquinasxarea = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $maquinasxarea;
    }
    
    

    
                public function MaquinaporTipoSemniterminado($tipsemi_id) { //producción 2019 , sustiruido por la funcion anterior
        $stmt = $this->objPdo->prepare("

 select maq.maq_id, maq.maq_nombre, tipsemi.tipsem_id, maq.maq_estado
from PROMGMAQUINA maq
inner join PROMGAREAS ar on ar.are_id = maq.are_id
inner join PROTIPOSEMITERMINADO tipsemi on tipsemi.are_id = ar.are_id
where tipsemi.tipsem_id = '$tipsemi_id' and maq_estado = '0'
                
                ");
        $stmt->execute();
        $maquinasxsemiterminado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $maquinasxsemiterminado;
    }
    
      public function gettipTuboXmaquina($maquina){
        $sql = "
    select maq.maq_nombre,maq.maq_id,peso.pespro_id, peso.pespro_descripcion,valitem.itemcaractipmaq_id,valitem.valitemcaractipmaq_id,valitem.valitemcaractipmaq_valor
from PROVALITEMSCARACTTIPMAQUINA valitem
inner join PROITEMCARACTTIPMAQUINA item on item.itemcaractipmaq_id = valitem.itemcaractipmaq_id
inner join PROMAQUINAFAMILIA maqfam on maqfam.maqfami_id=valitem.maqfami_id
inner join PROMGMAQUINA maq on maq.maq_id = maqfam.maq_id
inner join PROPESOPRODUCT peso on peso.pespro_id = valitem.valitemcaractipmaq_valor
where maq.maq_id = '$maquina'         
";

        $stmt = $this->objPdo->prepare($sql);

        $stmt->execute();

        
           $tiptubos = $stmt->fetchAll(PDO::FETCH_ASSOC);

           return $tiptubos;


    }
    
        public function gettipTubo(){
        $sql = "
         select *
from PROPESOPRODUCT where pespro_tipo = '1' and pespro_estado = '0' and eliminado = '0'

";

        $stmt = $this->objPdo->prepare($sql);

        $stmt->execute();

        
           $tiptubos = $stmt->fetchAll(PDO::FETCH_ASSOC);

           return $tiptubos;


    }
    
        
        public function getEnvasado(){
        $sql = "
         select *
from PROPESOPRODUCT where pespro_tipo = '2' and pespro_estado = '0' and eliminado = '0'

";

        $stmt = $this->objPdo->prepare($sql);

        $stmt->execute();

        
           $tiptubos = $stmt->fetchAll(PDO::FETCH_ASSOC);

           return $tiptubos;


    }
    
         public function getCarrito(){
        $sql = "
         select *
from PROPESOPRODUCT where pespro_tipo = '3' and pespro_estado = '0' and eliminado = '0'

";

        $stmt = $this->objPdo->prepare($sql);

        $stmt->execute();

        
           $tiptubos = $stmt->fetchAll(PDO::FETCH_ASSOC);

           return $tiptubos;


    }
    
    public function getConsultarPesos($extotpro_tiptubo,$extotpro_tipenvase,$extotpro_numcarro){
        $sql = "
         select *  from  PROPESOPRODUCT 
         where pespro_id = '$extotpro_tiptubo' or pespro_id= '$extotpro_tipenvase' or pespro_id = '$extotpro_numcarro' and pespro_estado = '0' and eliminado = '0'

";

        $stmt = $this->objPdo->prepare($sql);

        $stmt->execute();

        
           $pesos = $stmt->fetchAll(PDO::FETCH_ASSOC);

           return $pesos;


    }
    
    
    
    function getMaq_id() {
        return $this->maq_id;
    }

    function getMaq_nombre() {
        return $this->maq_nombre;
    }

    function getMaq_estado() {
        return $this->maq_estado;
    }

    function getMaq_fec_adq() {
        return $this->maq_fec_adq;
    }

    function getMaq_fec_pue_mar() {
        return $this->maq_fec_pue_mar;
    }

    function getMaq_vid_util() {
        return $this->maq_vid_util;
    }

    function getMaq_porce_depreanual() {
        return $this->maq_porce_depreanual;
    }

    function getMaq_valor_adqui() {
        return $this->maq_valor_adqui;
    }

    function getEliminado() {
        return $this->eliminado;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getAre_id() {
        return $this->are_id;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setMaq_id($maq_id) {
        $this->maq_id = $maq_id;
    }

    function setMaq_nombre($maq_nombre) {
        $this->maq_nombre = $maq_nombre;
    }

    function setMaq_estado($maq_estado) {
        $this->maq_estado = $maq_estado;
    }

    function setMaq_fec_adq($maq_fec_adq) {
        $this->maq_fec_adq = $maq_fec_adq;
    }

    function setMaq_fec_pue_mar($maq_fec_pue_mar) {
        $this->maq_fec_pue_mar = $maq_fec_pue_mar;
    }

    function setMaq_vid_util($maq_vid_util) {
        $this->maq_vid_util = $maq_vid_util;
    }

    function setMaq_porce_depreanual($maq_porce_depreanual) {
        $this->maq_porce_depreanual = $maq_porce_depreanual;
    }

    function setMaq_valor_adqui($maq_valor_adqui) {
        $this->maq_valor_adqui = $maq_valor_adqui;
    }

    function setEliminado($eliminado) {
        $this->eliminado = $eliminado;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setAre_id($are_id) {
        $this->are_id = $are_id;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }

  
    
    
    
}

?>