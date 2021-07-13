<?php

require_once 'conexion.php';

class consumoenergia {

    private $conener_id;
    private $conener_anio;
    private $conener_mes;
    private $conener_valorimp;
    private $conener_valorcon;
    private $usr_id;
    private $estado;
    private $fecha_creacion;
    private $objPdo;

    public function __construct( //producción 2019
            $conener_id = NULL, 
            $conener_anio = '', 
            $conener_mes = '', 
            $conener_valorimp = '', 
            $conener_valorcon = '', 
            $usr_id = '', 
            $estado = '', 
            $fecha_creacion = ''
    ) {
        $this->conener_id = $conener_id;
        $this->conener_anio = $conener_anio;
        $this->conener_mes = $conener_mes;
        $this->conener_valorimp = $conener_valorimp;
        $this->conener_valorcon = $conener_valorcon;
        $this->usr_id = $usr_id;
        $this->estado = $estado;
        $this->fecha_creacion = $fecha_creacion;


        $this->objPdo = new Conexion();
    }


    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("
 select *, 
 case 
when conener_mes = 1 THEN  'Enero'
when conener_mes = 2 THEN  'Febrero'
when conener_mes = 3 THEN  'Marzo'
when conener_mes = 4 THEN  'Abril'
when conener_mes = 5 THEN  'Mayo'
when conener_mes = 6 THEN  'Junio'
when conener_mes = 7 THEN  'Julio'
when conener_mes = 8 THEN  'Agosto'
when conener_mes = 9 THEN  'Septiembre'
when conener_mes = 10 THEN  'Octubre'
when conener_mes = 11 THEN  'Noviembre'
when conener_mes = 12 THEN  'Diciembre'
end  as nombre_mes
from PROCONSUMOENERG
where eliminado = '0'
                
                ");
        $stmt->execute();
        $consumes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $consumes;
    }
    

    public function obtenerxId($conener_id) { //producción 2019
        $stmt = $this->objPdo->prepare('SELECT conener_id, conener_anio, conener_mes, 
     conener_valorimp, conener_valorcon, usr_id, estado
 
   FROM PROCONSUMOENERG WHERE conener_id = :conener_id');
        $stmt->execute(array('conener_id' => $conener_id));
        $consmensuales = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($consmensuales as $consmensual) {
            $this->setConener_id ($consmensual['conener_id']);
            $this->setConener_anio($consmensual['conener_anio']);
            $this->setConener_mes($consmensual['conener_mes']);
            $this->setConener_valorimp($consmensual['conener_valorimp']);
            $this->setConener_valorcon($consmensual['conener_valorcon']);
            $this->setUsr_id($consmensual['usr_id']);
            $this->setEstado($consmensual['estado']);

        }
        return $this;
    }

     public function insertar() {  //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROCONSUMOENERG 
            (conener_anio, conener_mes, conener_valorimp, conener_valorcon, 
            usr_id,  estado) 
                                        VALUES(:conener_anio,
                                               :conener_mes,
                                               :conener_valorimp,
                                               :conener_valorcon,
                                               :usr_id,
                                               :estado)');
        $rows = $stmt->execute(array(
            'conener_anio' => $this->conener_anio,
            'conener_mes' => $this->conener_mes,
            'conener_valorimp' => $this->conener_valorimp,
            'conener_valorcon' => $this->conener_valorcon,
            'usr_id' => $this->usr_id,
            'estado' => $this->estado));
    }
    
public function modificar() { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROCONSUMOENERG SET 
            conener_anio=:conener_anio, 
            conener_mes=:conener_mes, 
            conener_valorimp=:conener_valorimp, 
            conener_valorcon=:conener_valorcon, 
            usr_id=:usr_id, 
            estado=:estado, 
            fecha_creacion = SYSDATETIME()         
            WHERE conener_id = :conener_id");
        $rows = $stmt->execute(array(
            'conener_anio' => $this->conener_anio,
            'conener_mes' => $this->conener_mes,
            'conener_valorimp' => $this->conener_valorimp,
            'conener_valorcon' => $this->conener_valorcon,
            'usr_id' => $this->usr_id,
            'estado' => $this->estado,
            'conener_id' => $this->conener_id));
    }

   public function validarConsumoMes($año, $mes) {  //producción 2019
        $stmt = $this->objPdo->prepare("
              
   SELECT conener_id, conener_anio, conener_mes,  conener_valorimp, conener_valorcon, usr_id, estado
 
   FROM PROCONSUMOENERG WHERE conener_anio = '$año' and conener_mes= '$mes' 

");
        $stmt->execute(array());
        $validar = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $validar;
    }
    
    
    
      public function InserProrratArea ($idconsumomes,$area_id,$id_importe,$estado,$usuario){//producción 2019
        $stmt = $this->objPdo->prepare("
           insert into PROCONSUMOENERGPROAREAS
 (conener_id,are_id,conmenproare_valor,estado,usr_id)
 values ('$idconsumomes','$area_id','$id_importe','$estado','$usuario')
               " );
        $rows = $stmt->execute();

    }
    
    
         public function updateConEnerMen1 ($id){//producción 2019
        $stmt = $this->objPdo->prepare("
          update PROCONSUMOENERG
set estado ='1'
where conener_id ='$id' 

                ");
        $rows = $stmt->execute();

    }
    
         public function updateConEnerMen0 ($id){//producción 2019
        $stmt = $this->objPdo->prepare("
          update PROCONSUMOENERG
set estado ='0'
where conener_id ='$id' 

                ");
        $rows = $stmt->execute();

    }
    
          public function deleteConEnerMen ($id){//producción 2019
        $stmt = $this->objPdo->prepare("
          delete from  PROCONSUMOENERGPROAREAS
            where conener_id ='$id' 

                ");
        $rows = $stmt->execute();

    }
      
        public function ConsumoPorcentMest($id) { //producción 2019
        $stmt = $this->objPdo->prepare("
  select proare.*, are.are_titulo
 from PROCONSUMOENERGPROAREAS proare
 inner join PROMGAREAS are on are.are_id = proare.are_id
 where conener_id = '$id'
                
                ");
        $stmt->execute();
        $consumes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $consumes;
    }
    
    
    
    
         public function InserProrratMaq ($idprorra_area,$maq_id,$prorrateo,$estado,$usuario){//producción 2019
        $stmt = $this->objPdo->prepare("
           insert into PROCONSUMOENERGPROMAQ
 (conmenproare_id,maq_id,conmenpromaq_valor,estado,usr_id)
 values ('$idprorra_area','$maq_id','$prorrateo','$estado','$usuario') " );
        $rows = $stmt->execute();

    }
    
         public function updateConEnerProAreas ($id, $valorporcentaje){//producción 2019
        $stmt = $this->objPdo->prepare("
          update PROCONSUMOENERGPROAREAS
set estado = '1' , conmenproare_valor = '$valorporcentaje'
where conmenproare_id ='$id' 

                ");
        $rows = $stmt->execute();

    }
    
    
         public function ConsumoPorcentMesMaq($id) { //producción 2019
        $stmt = $this->objPdo->prepare("
  select promaq.*, maq.maq_id, maq.maq_nombre
  from PROCONSUMOENERGPROMAQ promaq
 inner join PROMGMAQUINA maq on maq.maq_id = promaq.maq_id
 where conmenproare_id = '$id'
                
                ");
        $stmt->execute();
        $consumes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $consumes;
    }
    
    
      public function updateConEnerMaq ($estado,$id, $valor){//producción 2019
        $stmt = $this->objPdo->prepare("
          update PROCONSUMOENERGPROMAQ
set conmenpromaq_valor = '$valor', estado = '$estado',  fecha_creacion = SYSDATETIME() 
where conmenpromaq_id ='$id' 

                ");
        $rows = $stmt->execute();

    }
    
    
    
    

    function getConener_id() {
        return $this->conener_id;
    }

    function getConener_anio() {
        return $this->conener_anio;
    }

    function getConener_mes() {
        return $this->conener_mes;
    }

    function getConener_valorimp() {
        return $this->conener_valorimp;
    }

    function getConener_valorcon() {
        return $this->conener_valorcon;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getEstado() {
        return $this->estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setConener_id($conener_id) {
        $this->conener_id = $conener_id;
    }

    function setConener_anio($conener_anio) {
        $this->conener_anio = $conener_anio;
    }

    function setConener_mes($conener_mes) {
        $this->conener_mes = $conener_mes;
    }

    function setConener_valorimp($conener_valorimp) {
        $this->conener_valorimp = $conener_valorimp;
    }

    function setConener_valorcon($conener_valorcon) {
        $this->conener_valorcon = $conener_valorcon;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }



    
    
    
  
    
    
    
}

?>