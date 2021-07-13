<?php

require_once 'conexion.php';

class subsubmenu {

    private $sub_submenu_id;
    private $sub_titulosub;
    private $sub_enlacesub;
    private $submenu_id;
    private $usr_id;
    private $fechareg;
    private $eliminado;
    private $objPdo;

    public function __construct($sub_submenu_id = NULL, $sub_titulosub = '', $sub_enlacesub = '', $usr_id = '', $fechareg = '', $submenu_id = '', $eliminado= '' ) {
        $this->sub_submenu_id = $sub_submenu_id;
        $this->sub_titulosub = $sub_titulosub;
        $this->sub_enlacesub = $sub_enlacesub;
        $this->usr_id = $usr_id;
        $this->fecha_reg = $fechareg;
        $this->submenu_id = $submenu_id;
        $this->eliminado = $eliminado;
        $this->objPdo = new Conexion();
    }

    
        
    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("
         SELECT ssb.sub_submenu_id, ssb.sub_titulosub,ssb.sub_enlacesub, ssb.fechareg, sb.titulosub, sb.submenu_id
	 
	
  FROM PROMGSUBSUBMENU ssb
  inner join PROMGSUBMENU sb on sb.submenu_id= ssb.submenu_id
   where sb.eliminado = '0' and ssb.eliminado = '0'  ORDER BY ssb.sub_submenu_id
                
                ");
        $stmt->execute();
        $submenus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $submenus;
    }
    
      public function obtenerxId($sub_submenu_id) { //producción 2019
        $stmt = $this->objPdo->prepare('SELECT * FROM PROMGSUBSUBMENU WHERE sub_submenu_id = :sub_submenu_id');
        $stmt->execute(array('sub_submenu_id' => $sub_submenu_id));
        $submenus = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($submenus as $submenu) {
                $this->setSub_submenu_id($submenu['sub_submenu_id']);
                $this->setSub_titulosub($submenu['sub_titulosub']);
                $this->setSub_enlacesub($submenu['sub_enlacesub']);
                $this->setUsr_id($submenu['usr_id']);
                $this->setSubmenu_id($submenu['submenu_id']);
                $this->setFechareg($submenu['fechareg']);
            }
            return $this;
    }
    
    
    
    
    
     public function modificar() { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROMGSUBSUBMENU SET sub_titulosub=:sub_titulosub, sub_enlacesub=:sub_enlacesub, usr_id=:usr_id, fechareg = SYSDATETIME(), submenu_id=:submenu_id, eliminado = '0'            
            WHERE sub_submenu_id = :sub_submenu_id");
        $rows = $stmt->execute(array('sub_titulosub' => $this->sub_titulosub,
                                    'sub_enlacesub' => $this->sub_enlacesub,
                                    'usr_id' => $this->usr_id,
                                    'submenu_id' => $this->submenu_id,
                                    'sub_submenu_id' => $this->sub_submenu_id));
    }
    
        public function insertar() {  //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROMGSUBSUBMENU (sub_titulosub, sub_enlacesub, usr_id,  submenu_id, eliminado) 
                                        VALUES(:sub_titulosub,
                                               :sub_enlacesub,
                                               :usr_id,
                                               :submenu_id,
                                               :eliminado)');
        $rows = $stmt->execute(array('sub_titulosub' => $this->sub_titulosub,
                                     'sub_enlacesub' => $this->sub_enlacesub,
                                     'usr_id' => $this->usr_id,
                                     'submenu_id' => $this->submenu_id,
                                     'eliminado' => $this->eliminado));
    }
    
      public function eliminar($sub_submenu_id) { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROMGSUBSUBMENU SET ELIMINADO = '1'  WHERE sub_submenu_id = :sub_submenu_id");
        $rows = $stmt->execute(array('sub_submenu_id' => $sub_submenu_id));
        return $rows;
    }
    
    
    
    
    
    
    
    // public function consultarActivos() {
    //     $stmt = $this->objPdo->prepare("SELECT submenu_id, titulosub, enlacesub, usr_id, fechareg FROM submenu WHERE enlacesub = '1' 
    //                                     ORDER BY titulosub;");
    //     $stmt->execute();
    //     $submenus = $stmt->fetchAll(PDO::FETCH_OBJ);
    //     return $submenus;
    // }



  
    
  

    public function obtenerNombrexId($submenu){
        $stmt = $this->objPdo->prepare('SELECT titulosub FROM submenu WHERE submenu_id = :submenu_id');
        $stmt->execute(array('submenu_id' => $submenu));
        $submenus = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $submenus[0]->sub_titulosub;

    }
    
 
    function getSub_submenu_id() {
        return $this->sub_submenu_id;
    }

    function getSub_titulosub() {
        return $this->sub_titulosub;
    }

    function getSub_enlacesub() {
        return $this->sub_enlacesub;
    }

    function getSubmenu_id() {
        return $this->submenu_id;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getFechareg() {
        return $this->fechareg;
    }

    function getEliminado() {
        return $this->eliminado;
    }

    function setSub_submenu_id($sub_submenu_id) {
        $this->sub_submenu_id = $sub_submenu_id;
    }

    function setSub_titulosub($sub_titulosub) {
        $this->sub_titulosub = $sub_titulosub;
    }

    function setSub_enlacesub($sub_enlacesub) {
        $this->sub_enlacesub = $sub_enlacesub;
    }

    function setSubmenu_id($submenu_id) {
        $this->submenu_id = $submenu_id;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setFechareg($fechareg) {
        $this->fechareg = $fechareg;
    }

    function setEliminado($eliminado) {
        $this->eliminado = $eliminado;
    }



}

?>