<?php

require_once 'conexion.php';

class parada {

    private $par_id;
    private $par_nombre;
    private $par_estado;
    private $usr_id;
    private $tippar_id;
    private $are_id;
    private $eliminado;
    private $fecha_creacion;
    private $objPdo;

    public function __construct(
    $par_id = NULL, $par_nombre = '', $par_estado = '', $usr_id = '', $tippar_id = '', $are_id = '', $eliminado = '', $fecha_creacion = ''
    ) {
        $this->par_id = $par_id;
        $this->par_nombre = $par_nombre;
        $this->par_estado = $par_estado;
        $this->usr_id = $usr_id;
        $this->tippar_id = $tippar_id;
        $this->are_id = $are_id;
        $this->eliminado = $eliminado;
        $this->fecha_creacion = $fecha_creacion;
        $this->objPdo = new Conexion();
    }

    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("
  SELECT PAR.*, TIP.tippar_id, TIP.tippar_titulo, ARE.are_id, ARE.are_titulo
  FROM PROMGPARADA PAR
  inner join PROMGTIPOPARADA TIP on TIP.tippar_id = PAR.tippar_id
  inner join PROMGAREAS ARE ON ARE.are_id = PAR.are_id
   where TIP.eliminado = '0' and PAR.eliminado = '0'  ORDER BY PAR.par_nombre;
                
                ");
        $stmt->execute();
        $parada = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $parada;
    }

    public function obtenerxId($par_id) { //producción 2019
        $stmt = $this->objPdo->prepare("
    SELECT par_id, par_nombre, par_estado,usr_id,tippar_id ,are_id,eliminado,  fecha_creacion
   FROM PROMGPARADA WHERE par_id = :par_id");
        $stmt->execute(array('par_id' => $par_id));
        $paradas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($paradas as $parada) {
            $this->setPar_id($parada['par_id']);
            $this->setPar_nombre($parada['par_nombre']);
            $this->setPar_estado($parada['par_estado']);
            $this->setUsr_id($parada['usr_id']);
            $this->setTippar_id($parada['tippar_id']);
            $this->setAre_id($parada['are_id']);
            $this->setEliminado($parada['eliminado']);
            $this->setFecha_creacion($parada['fecha_creacion']);
        }
        return $this;
    }

    public function insertar() {  //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROMGPARADA 
            (par_nombre, par_estado, usr_id,  tippar_id,are_id) 
                                        VALUES(:par_nombre,
                                               :par_estado,
                                               :usr_id,
                                               :tippar_id,
                                               :are_id)');
        $rows = $stmt->execute(array(
            'par_nombre' => $this->par_nombre,
            'par_estado' => $this->par_estado,
            'usr_id' => $this->usr_id,
            'tippar_id' => $this->tippar_id,
            'are_id' => $this->are_id));
    }

    public function modificar() { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROMGPARADA SET 
            par_nombre=:par_nombre, 
            par_estado=:par_estado, 
            usr_id=:usr_id, 
            tippar_id=:tippar_id, 
            are_id=:are_id, 
            fecha_creacion = SYSDATETIME()         
            WHERE par_id = :par_id");
        $rows = $stmt->execute(array(
            'par_nombre' => $this->par_nombre,
            'par_estado' => $this->par_estado,
            'usr_id' => $this->usr_id,
            'tippar_id' => $this->tippar_id,
            'are_id' => $this->are_id,
            'par_id' => $this->par_id));
    }

    public function ListarRegistro() { //producción 2019
        $stmt = $this->objPdo->prepare("
  SELECT PARREG.* , PAR.*, TIP.tippar_id, TIP.tippar_titulo, ARE.are_id, ARE.are_titulo
  FROM PROMGPARADAREG PARREG
  INNER JOIN PROMGPARADA PAR ON PAR.par_id = PARREG.par_id
  inner join PROMGTIPOPARADA TIP on TIP.tippar_id = PAR.tippar_id
  inner join PROMGAREAS ARE ON ARE.are_id = PAR.are_id
   where TIP.eliminado = '0' and PAR.eliminado = '0'  ORDER BY PAR.par_nombre;
                
                ");
        $stmt->execute();
        $parada = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $parada;
    }

    public function getparada($tippar_id) {//producción 2019
        $stmt = $this->objPdo->prepare("
select *
from PROMGPARADA
where tippar_id  = '$tippar_id'
                
                ");
        $stmt->execute();
        $paradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $paradas;
    }

    public function insertarreg($inicio, $fin, $maq_id, $par_id, $usr, $observacion) {//producción 2019
        $stmt = $this->objPdo->prepare("INSERT INTO PROMGPARADAREG 
            (parreg_inicio, parreg_fin, maq_id, par_id,usr_id, parreg_obs ) 
           VALUES('$inicio', '$fin', '$maq_id', '$par_id', '$usr','$observacion')");
        $rows = $stmt->execute();
    }

    public function eliminar($par_id) {
        $stmt = $this->objPdo->prepare("UPDATE PROMGPARADA SET ELIMINADO = '1'  WHERE par_id = :par_id");
        $rows = $stmt->execute(array('par_id' => $par_id));
        return $rows;
    }

    //************************************** 26-11-2020
    function consultarParadas($ini, $fin, $area, $estado, $maquina) {//producción 2019
        $lista = [];
        $consultar = new parada();
        // $paradas = $parada->ListarRegistro();
        //  $consultar = new kanban();

        if ($maquina == '-1') {
            $lista = $consultar->ListarRegistroParadas($ini, $fin, $estado);
        } else {
            $lista = $consultar->ListarRegistroParadasXmaq($ini, $fin, $estado, $area, $maquina);
        }

        return $lista;
    }

    public function ListarRegistroParadas($ini, $fin, $estado) {//producción 2019
       
        $sql = "";
                $sql .= "

SELECT PARREG.* , PAR.*, TIP.tippar_id, TIP.tippar_titulo,  ARE.are_titulo
  FROM PROMGPARADAREG PARREG
  INNER JOIN PROMGPARADA PAR ON PAR.par_id = PARREG.par_id
  inner join PROMGTIPOPARADA TIP on TIP.tippar_id = PAR.tippar_id
  inner join PROMGAREAS ARE ON ARE.are_id = PAR.are_id
   where TIP.eliminado = '0' and PAR.eliminado = '0'  and cast ( PARREG.parreg_inicio as date )>= '$ini'
   and  cast(PARREG.parreg_fin as date ) <= '$fin' 
  
";
        
        if($estado == '2'){//PENDIENTE
           $sql .= " and PARREG.estado = '0'   ORDER BY PAR.par_nombre  ";
           
        }elseif($estado == '1'){//INICIADO
            $sql .= " and PARREG.estado = '1'   ORDER BY PAR.par_nombre ";
            
        }elseif($estado == '0'){ //CERRADO
            $sql .= " and PARREG.estado = '3'   ORDER BY PAR.par_nombre ";
            
        }else{
             $sql .= "   ORDER BY PAR.par_nombre ";
        }
        
           
       
        $stmt = $this->objPdo->prepare($sql);
        $stmt->execute();
        $paradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $paradas;
    }

    public function ListarRegistroParadasXmaq($ini, $fin, $estado, $maquina) {//producción 2019
        $stmt = $this->objPdo->prepare("
SELECT PARREG.* , PAR.*, TIP.tippar_id, TIP.tippar_titulo, ARE.are_id, ARE.are_titulo
  FROM PROMGPARADAREG PARREG
  INNER JOIN PROMGPARADA PAR ON PAR.par_id = PARREG.par_id
  inner join PROMGTIPOPARADA TIP on TIP.tippar_id = PAR.tippar_id
  inner join PROMGAREAS ARE ON ARE.are_id = PAR.are_id
   where TIP.eliminado = '0' and PAR.eliminado = '0'  and cast ( PARREG.parreg_inicio as date )>= '$ini'
   and  cast(PARREG.parreg_fin as date ) <= '$fin' and PARREG.estado = '$estado'  and PARREG.maq_id = '$maquina'
    ORDER BY PAR.par_nombre 

                
                ");
        $stmt->execute();
        $paradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $paradas;
    }

    function getPar_id() {
        return $this->par_id;
    }

    function getPar_nombre() {
        return $this->par_nombre;
    }

    function getPar_estado() {
        return $this->par_estado;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getTippar_id() {
        return $this->tippar_id;
    }

    function getEliminado() {
        return $this->eliminado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setPar_id($par_id) {
        $this->par_id = $par_id;
    }

    function setPar_nombre($par_nombre) {
        $this->par_nombre = $par_nombre;
    }

    function setPar_estado($par_estado) {
        $this->par_estado = $par_estado;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setTippar_id($tippar_id) {
        $this->tippar_id = $tippar_id;
    }

    function setEliminado($eliminado) {
        $this->eliminado = $eliminado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }

    function getAre_id() {
        return $this->are_id;
    }

    function setAre_id($are_id) {
        $this->are_id = $are_id;
    }

}

?>
