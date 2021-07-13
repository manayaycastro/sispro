<?php

require_once 'conexion.php';

class diseno {

  private $prodi_id;
  private $prodi_codart;
  private $prodi_nombre;
  private $prodi_comentario;
  private $prodi_cliente;
  
    private $objPdo;

    public function __construct($prodi_id = null, $prodi_codart= '', $prodi_nombre = '', $prodi_comentario= '', $prodi_cliente = '') { // produccion 20200327
        $this->prodi_id = $prodi_id;
        $this->prodi_codart = $prodi_codart;
        $this->prodi_nombre = $prodi_nombre;
        $this->prodi_comentario = $prodi_comentario;
        $this->prodi_cliente = $prodi_cliente;
        $this->objPdo = new Conexion();
    }

    public function consultar() { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
       

			 select dise.* , art.descripcion, art.codalt, clie.razonsocial,didet.prodidet_version
from PRODISENOS dise
inner  join ". $_SESSION['server_vinculado']."alart art on  art.codart = dise.prodi_codart
inner join  ". $_SESSION['server_vinculado']."vcliente clie on clie.codcli = dise.prodi_cliente 
inner join PRODISENOSDET didet on (didet.prodi_id = dise.prodi_id and didet.prodidet_vigente = '1')
where art.codclase = '0090'

        

    ");
        $stmt->execute();
        $diseno = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $diseno;
    }
    
        public function consultarART() { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
       
select art.*, tabla01.artsemi_id

from ". $_SESSION['server_vinculado']."alart art
LEFT JOIN (
SELECT * FROM PROARTSEMITERMINADO
WHERE tipsem_id ='2'
)tabla01 on tabla01.form_id = art.codart    

where art.codclase = '0090' and ( art.codsubclase = '0010' OR  art.codsubclase = '0050' OR  art.codsubclase = '0040' OR art.codsubclase = '0020')
        

    ");
        $stmt->execute();
        $diseno = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $diseno;
    }
    
    
            public function consultarARTdiseno() { // produccion 20200327 ". $_SESSION['server_vinculado'] ."
        $stmt = $this->objPdo->prepare("
       

select art.*, tabla01.prodi_codart

from ". $_SESSION['server_vinculado']."alart art
LEFT JOIN (
SELECT * FROM PRODISENOS

)tabla01 on tabla01.prodi_codart = art.codart    

where art.codclase = '0090' and ( art.codsubclase = '0010' OR  art.codsubclase = '0050' OR  art.codsubclase = '0040')
        

    ");
        $stmt->execute();
        $diseno = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $diseno;
    }
    
    
    
            public function consultarCLI() {
        $stmt = $this->objPdo->prepare("
       
select clien.codcli, clien.razonsocial, clien.nroid

from ". $_SESSION['server_vinculado']."vcliente clien

    ");
        $stmt->execute();
        $diseno = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $diseno;
    }
    
    
    public function obtenerxId($id) {// produccion 2019
        $stmt = $this->objPdo->prepare("SELECT * FROM PRODISENOS WHERE prodi_codart = :id");
        $stmt->execute(array('id' => $id));
        $disenos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($disenos as $diseno) {
            $this->setProdi_id($diseno ['prodi_id']);
            $this->setProdi_codart($diseno ['prodi_codart']);
            $this->setProdi_nombre($diseno ['prodi_nombre']);
            $this->setProdi_comentario($diseno ['prodi_comentario']);
            $this->setProdi_cliente($diseno ['prodi_cliente']);
        }
        return $this;
    }
    
                public function consultarDetalleDise($codart) {
        $stmt = $this->objPdo->prepare("
       
select det.*, dise.prodi_codart
from PRODISENOSDET det
inner join PRODISENOS dise on dise.prodi_id = det.prodi_id
where dise.prodi_codart = '$codart'

    ");
        $stmt->execute();
        $diseno = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $diseno;
    }
    
    public function insertarDISENO($prodi_codart, $prodi_nombre, $prodi_comentario, $prodi_cliente) { //producción 2020
$stmt = $this->objPdo->prepare("
    insert into   PRODISENOS 
    (prodi_codart,prodi_nombre, prodi_comentario, prodi_cliente) 
        values ('$prodi_codart','$prodi_nombre','$prodi_comentario', '$prodi_cliente')");
$rows = $stmt->execute(array());
return $rows;
    }
    
        public function insertarDisenoDet($prodi_id, $prodidet_version, $prodidet_url,$prodidet_comentario) { //producción 2020
$stmt = $this->objPdo->prepare("
    insert into   PRODISENOSDET 
    (prodi_id,prodidet_version, prodidet_url,prodidet_comentario) 
        values ('$prodi_id','$prodidet_version', '".$prodidet_url."','$prodidet_comentario')");
$rows = $stmt->execute(array());
return $rows;
    }
    
    
            public function consultarTop1() {
        $stmt = $this->objPdo->prepare("
       SELECT TOP 1 * FROM PRODISENOS ORDER BY prodi_id DESC


    ");
        $stmt->execute();
        $diseno = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $diseno;
    }
    
          public function updateversion($idreg,$estado) {
        $stmt = $this->objPdo->prepare("
       update PRODISENOSDET set prodidet_vigente = '$estado'where prodidet_id = '$idreg'

    ");
       $diseno = $stmt->execute();
    
        return $diseno;
    }
    
          public function updateversionTODOS($estado,$iddiseno ) {
        $stmt = $this->objPdo->prepare("
       update PRODISENOSDET set prodidet_vigente = '$estado'  where prodi_id = '$iddiseno'

    ");
       $diseno = $stmt->execute();
    
        return $diseno;
    }
    
    

    
    
    
    
    


    
    function getProdi_id() {
        return $this->prodi_id;
    }

    function getProdi_codart() {
        return $this->prodi_codart;
    }

    function getProdi_nombre() {
        return $this->prodi_nombre;
    }

    function getProdi_comentario() {
        return $this->prodi_comentario;
    }

    function getProdi_cliente() {
        return $this->prodi_cliente;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setProdi_id($prodi_id) {
        $this->prodi_id = $prodi_id;
    }

    function setProdi_codart($prodi_codart) {
        $this->prodi_codart = $prodi_codart;
    }

    function setProdi_nombre($prodi_nombre) {
        $this->prodi_nombre = $prodi_nombre;
    }

    function setProdi_comentario($prodi_comentario) {
        $this->prodi_comentario = $prodi_comentario;
    }

    function setProdi_cliente($prodi_cliente) {
        $this->prodi_cliente = $prodi_cliente;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }


}

?>
