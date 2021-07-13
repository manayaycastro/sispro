<?php

require_once 'conexion.php';

class maquinameta {

    private $maqmet_id;
    private $maqmet_anio;
    private $maqmet_unidadmed;
    private $maqmet_valor;
    private $maq_id;
    private $usr_id;
    private $estado;
    private $fecha_creacion;
    private $objPdo;

    public function __construct( //producción 2019
            $maqmet_id = NULL, 
            $maqmet_anio = '', 
            $maqmet_unidadmed = '', 
            $maqmet_valor = '', 
            $maq_id = '', 
            $usr_id = '', 
            $estado = '', 
            $fecha_creacion = ''
    ) {
        $this->maqmet_id = $maqmet_id;
        $this->maqmet_anio = $maqmet_anio;
        $this->maqmet_unidadmed = $maqmet_unidadmed;
        $this->maqmet_valor = $maqmet_valor;
        $this->maq_id = $maq_id;
        $this->usr_id = $usr_id;
        $this->estado = $estado;
        $this->fecha_creacion = $fecha_creacion;


        $this->objPdo = new Conexion();
    }

    
    
    
    
    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("
  select meta.*, maq.maq_nombre, maq.maq_id
	from 	PROMGMAQUINAMETA meta
	inner join PROMGMAQUINA maq on maq.maq_id = meta.maq_id
	where meta.eliminado = '0' and maq.eliminado = '0'
                
                ");
        $stmt->execute();
        $maquinasmeta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $maquinasmeta;
    }
    

    public function obtenerxId($maqmet_id) { //producción 2019
        $stmt = $this->objPdo->prepare('SELECT maqmet_id, maqmet_anio, maqmet_unidadmed, 
     maqmet_valor, maq_id, usr_id, estado
 
   FROM PROMGMAQUINAMETA WHERE maqmet_id = :maqmet_id');
        $stmt->execute(array('maqmet_id' => $maqmet_id));
        $maquinametas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($maquinametas as $maquinameta) {
            $this->setMaqmet_id ($maquinameta['maqmet_id']);
            $this->setMaqmet_anio($maquinameta['maqmet_anio']);
            $this->setMaqmet_unidadmed($maquinameta['maqmet_unidadmed']);
            $this->setMaqmet_valor($maquinameta['maqmet_valor']);
            $this->setMaq_id($maquinameta['maq_id']);
            $this->setUsr_id($maquinameta['usr_id']);
            $this->setEstado($maquinameta['estado']);

        }
        return $this;
    }

     public function insertar() {  //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROMGMAQUINAMETA 
            (maqmet_anio, maqmet_unidadmed, maqmet_valor, maq_id, usr_id,  estado) 
                                        VALUES(:maqmet_anio,
                                               :maqmet_unidadmed,
                                               :maqmet_valor,
                                               :maq_id,
                                               :usr_id,
                                               :estado)');
        $rows = $stmt->execute(array(
            'maqmet_anio' => $this->maqmet_anio,
            'maqmet_unidadmed' => $this->maqmet_unidadmed,
            'maqmet_valor' => $this->maqmet_valor,
            'maq_id' => $this->maq_id,
            'usr_id' => $this->usr_id,
            'estado' => $this->estado));
    }
    
public function modificar() { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROMGMAQUINAMETA SET 
            maqmet_anio=:maqmet_anio, 
            maqmet_unidadmed=:maqmet_unidadmed, 
            maqmet_valor=:maqmet_valor, 
            maq_id=:maq_id, 
            usr_id=:usr_id, 
            estado=:estado, 
            fecha_creacion = SYSDATETIME()         
            WHERE maqmet_id = :maqmet_id");
        $rows = $stmt->execute(array(
            'maqmet_anio' => $this->maqmet_anio,
            'maqmet_unidadmed' => $this->maqmet_unidadmed,
            'maqmet_valor' => $this->maqmet_valor,
            'maq_id' => $this->maq_id,
            'usr_id' => $this->usr_id,
            'estado' => $this->estado,
            'maqmet_id' => $this->maqmet_id));
    }


    
        public function Listarmeta() { //producción 2019 revisar
        $stmt = $this->objPdo->prepare("
                    select met.* , maq.maq_nombre
		  from    PROMGMAQUINAMETA met
		  inner join    PROMGMAQUINA maq on maq.maq_id = met.maq_id
                
                ");
        $stmt->execute();
        $parada = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $parada;
    }
    
    
    public function validarMetaMaquina($año, $maquina) {  //producción 2019
        $stmt = $this->objPdo->prepare("
              
   SELECT maqmet_id, maqmet_anio, maqmet_unidadmed,  maqmet_valor, maq_id, usr_id, estado
 
   FROM PROMGMAQUINAMETA WHERE maqmet_anio = '$año' and maq_id= '$maquina' 

");
        $stmt->execute(array());
        $validar = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $validar;
    }
    
    
       public function insertarmaqmetdet ($i,$maqmet_anio, $maqmet_valor, $maq_id,$estado, $usr){//producción 2019
        $stmt = $this->objPdo->prepare("INSERT INTO PROMGMAQUINAMETADET 
                                         (maqmetdet_mes, maqmetdet_anio, maqmetdet_valor, maq_id,estado, usr_id ) 
                                     VALUES('$i', '$maqmet_anio', '$maqmet_valor', '$maq_id', '$estado','$usr')");
        $rows = $stmt->execute();

    }
    
    
        public function listarmaqmetdet($año, $maquina) { //producción 2019
        $stmt = $this->objPdo->prepare("
  

select metdet.*, met.maqmet_unidadmed,
case 
when metdet.maqmetdet_mes = 1 THEN  'Enero'
when metdet.maqmetdet_mes = 2 THEN  'Febrero'
when metdet.maqmetdet_mes = 3 THEN  'Marzo'
when metdet.maqmetdet_mes = 4 THEN  'Abril'
when metdet.maqmetdet_mes = 5 THEN  'Mayo'
when metdet.maqmetdet_mes = 6 THEN  'Junio'
when metdet.maqmetdet_mes = 7 THEN  'Julio'
when metdet.maqmetdet_mes = 8 THEN  'Agosto'
when metdet.maqmetdet_mes = 9 THEN  'Septiembre'
when metdet.maqmetdet_mes = 10 THEN  'Octubre'
when metdet.maqmetdet_mes = 11 THEN  'Noviembre'
when metdet.maqmetdet_mes = 12 THEN  'Diciembre'
end  as nombre_mes
from PROMGMAQUINAMETADET metdet
inner join  PROMGMAQUINAMETA met on  (met.maqmet_anio = metdet.maqmetdet_anio and met.maq_id = metdet.maq_id)
where met.maqmet_anio = '$año' and met.maq_id = '$maquina'
                
                ");
        $stmt->execute();
        $maquinasmetadet = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $maquinasmetadet;
    }
    
     public function updatemetdet ($idmetdet,$valormensual,$estado,$usuario){//producción 2019
        $stmt = $this->objPdo->prepare("
           update PROMGMAQUINAMETADET 
 set  maqmetdet_valor = '$valormensual', estado = '$estado', usr_id = '$usuario'
  where maqmetdet_id = '$idmetdet' 


                ");
        $rows = $stmt->execute();

    }
    
    
    
    
    
    

 

    
    
    function getMaqmet_id() {
        return $this->maqmet_id;
    }

    function getMaqmet_anio() {
        return $this->maqmet_anio;
    }

    function getMaqmet_unidadmed() {
        return $this->maqmet_unidadmed;
    }

    function getMaqmet_valor() {
        return $this->maqmet_valor;
    }

    function getMaq_id() {
        return $this->maq_id;
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

    function setMaqmet_id($maqmet_id) {
        $this->maqmet_id = $maqmet_id;
    }

    function setMaqmet_anio($maqmet_anio) {
        $this->maqmet_anio = $maqmet_anio;
    }

    function setMaqmet_unidadmed($maqmet_unidadmed) {
        $this->maqmet_unidadmed = $maqmet_unidadmed;
    }

    function setMaqmet_valor($maqmet_valor) {
        $this->maqmet_valor = $maqmet_valor;
    }

    function setMaq_id($maq_id) {
        $this->maq_id = $maq_id;
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