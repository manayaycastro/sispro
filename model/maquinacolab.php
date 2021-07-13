<?php

require_once 'conexion.php';

class maquinacolab {

    private $maqcol_id;
//    private $itemform_descripcion;
//    private $itemform_pocision;
//    private $eliminado;
    private $maq_id;
    private $coddir;
    private $usr_id;
    private $estado;
    private $fecha_creacion;
    private $objPdo;

    public function __construct(//producción 2019
    $maqcol_id = NULL,
//            $itemform_descripcion = '', 
//            $itemform_pocision = '', 
//            $eliminado = '', 
            $maq_id = '', $coddir = '', $usr_id = '', $estado = '', $fecha_creacion = ''
    ) {
        $this->maqcol_id = $maqcol_id;
//        $this->itemform_descripcion = $itemform_descripcion;
//        $this->itemform_pocision = $itemform_pocision;
//        $this->eliminado = $eliminado;
        $this->maq_id = $maq_id;
        $this->coddir = $coddir;

        $this->usr_id = $usr_id;
        $this->estado = $estado;
        $this->fecha_creacion = $fecha_creacion;


        $this->objPdo = new Conexion();
    }

    
//    select e.*, direc.apellidopaterno, direc.apellidomaterno, direc.primernombre, direc.segundonombre
//from [192.168.10.242].ELAGUILA.DBO.RHEMPLEADO e
//inner join [192.168.10.242].ELAGUILA.DBO.MGDIRECTORIO direc on direc.coddir = e.codempl
    
    
    
    
    
    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("


select e.*, direc.apellidopaterno, direc.apellidomaterno, direc.primernombre, direc.segundonombre, direc.nroid,  ar.descripcion as area, ar.codarea , car.descripcion as cargo
,INF.codgrupo, GRU.abreviatura
from  ". $_SESSION['server_vinculado']."RHEMPLEADO e
inner join ". $_SESSION['server_vinculado']."MGDIRECTORIO direc on direc.coddir = e.codempl
INNER JOIN ". $_SESSION['server_vinculado']."RHINFLABORAL INF ON ( INF.codempl = E.codempl  AND INF.eliminado= '0')
INNER JOIN ". $_SESSION['server_vinculado']."RHAREA ar on ar.codarea = INF.tipoarea
inner join ". $_SESSION['server_vinculado']."rhcargo car on  car.codcargo = INF.cargo

inner join ". $_SESSION['server_vinculado']."RHGRUPO GRU on  GRU.codgrupo = INF.codgrupo
WHERE (GRU.abreviatura = 'G1' OR GRU.abreviatura = 'G2' OR GRU.abreviatura = 'G3') and ar.codarea != '9' and  e.eliminado='0'-- and  direc.nroid = '45817277'
ORDER BY direc.apellidopaterno
    
                ");
        $stmt->execute();
        $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $item;
    }
    
       public function consultar2() { //producción 2019
        $stmt = $this->objPdo->prepare("
select  coddir, primernombre, segundonombre, apellidopaterno, apellidomaterno, nroid
from MGDIRECTORIO
 where    tipopersona = '1' and esempleado = '1'     
                ");
        $stmt->execute();
        $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $item;
    }

    
          public function insertarMaqColab ($maq,$emp, $estado , $usr){//producción 2019
        $stmt = $this->objPdo->prepare("
          insert into  PROMAQUINACOLAB (maq_id, coddir, usr_id, estado )
          values ('$maq','$emp','$usr','$estado') 


                ");
        $rows = $stmt->execute();

    }
    
              public function deleteMaqColab ($id){//producción 2019
        $stmt = $this->objPdo->prepare("
          delete from  PROMAQUINACOLAB
            where maqcol_id ='$id' 

                ");
        $rows = $stmt->execute();

    }
    
    
    
    
    public function obtenerxId($maqcol_id) { //producción 2019
        $stmt = $this->objPdo->prepare('SELECT maqcol_id, 
      maq_id,coddir , usr_id, estado
 
   FROM PROMAQUINACOLAB WHERE maqcol_id = :maqcol_id');
        $stmt->execute(array('maqcol_id' => $maqcol_id));
        $maquinacolaborador = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($maquinacolaborador as $maquinacolab) {
            $this->setMaqcol_id($maquinacolab['maqcol_id']);
//            $this->setItemform_descripcion($item['itemform_descripcion']);
//            $this->setItemform_pocision($item['itemform_pocision']);
//            $this->setEliminado($item['eliminado']);
            $this->setMaq_id($maquinacolab['maq_id']);
            $this->setCoddir($maquinacolab['coddir']);
            $this->setUsr_id($maquinacolab['usr_id']);
            $this->setEstado($maquinacolab['estado']);
        }
        return $this;
    }



    function getMaqcol_id() {
        return $this->maqcol_id;
    }

    function getMaq_id() {
        return $this->maq_id;
    }

    function getCoddir() {
        return $this->coddir;
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

    function setMaqcol_id($maqcol_id) {
        $this->maqcol_id = $maqcol_id;
    }

    function setMaq_id($maq_id) {
        $this->maq_id = $maq_id;
    }

    function setCoddir($coddir) {
        $this->coddir = $coddir;
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
