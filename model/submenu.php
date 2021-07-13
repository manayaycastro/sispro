<?php

require_once 'conexion.php';

class Submenu {

    private $submenu_id;
    private $titulosub;
    private $enlacesub;
    private $menu_id;
    private $usr_id;
    private $fechareg;
    private $eliminado;
    private $objPdo;

    public function __construct($submenu_id = NULL, $titulosub = '', $enlacesub = '', $usr_id = '', $fechareg = '', $menu_id = '', $eliminado= '' ) {
        $this->submenu_id = $submenu_id;
        $this->titulosub = $titulosub;
        $this->enlacesub = $enlacesub;
        $this->usr_id = $usr_id;
        $this->fecha_reg = $fechareg;
        $this->menu_id = $menu_id;
        $this->eliminado = $eliminado;
        $this->objPdo = new Conexion();
    }

    
        
    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("
             SELECT sb.submenu_id, sb.titulosub, sb.enlacesub, sb.usr_id, sb.fechareg, m.titulo, sb.menu_id
  FROM PROMGSUBMENU sb
  inner join PROMGMENU m on m.menu_id = sb.menu_id
   where sb.eliminado = '0' and m.eliminado = '0'  ORDER BY sb.submenu_id;
                
                ");
        $stmt->execute();
        $submenus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $submenus;
    }
    
      public function obtenerxId($submenu_id) { //producción 2019
        $stmt = $this->objPdo->prepare('SELECT * FROM PROMGSUBMENU WHERE submenu_id = :submenu_id');
        $stmt->execute(array('submenu_id' => $submenu_id));
        $submenus = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($submenus as $submenu) {
                $this->setSubmenu_id($submenu['submenu_id']);
                $this->setTitulosub($submenu['titulosub']);
                $this->setEnlacesub($submenu['enlacesub']);
                $this->setUsr_id($submenu['usr_id']);
                $this->setMenu_id($submenu['menu_id']);
                $this->setFechareg($submenu['fechareg']);
            }
            return $this;
    }
    
     public function modificar() { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROMGSUBMENU SET titulosub=:titulosub, enlacesub=:enlacesub, usr_id=:usr_id, fechareg = SYSDATETIME(), menu_id=:menu_id, eliminado = '0'            
            WHERE submenu_id = :submenu_id");
        $rows = $stmt->execute(array('titulosub' => $this->titulosub,
                                    'enlacesub' => $this->enlacesub,
                                    'usr_id' => $this->usr_id,
                                    'menu_id' => $this->menu_id,
                                    'submenu_id' => $this->submenu_id));
    }
    
        public function insertar() {  //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROMGSUBMENU (titulosub, enlacesub, usr_id,  menu_id, eliminado) 
                                        VALUES(:titulosub,
                                               :enlacesub,
                                               :usr_id,
                                               :menu_id,
                                               :eliminado)');
        $rows = $stmt->execute(array('titulosub' => $this->titulosub,
                                     'enlacesub' => $this->enlacesub,
                                     'usr_id' => $this->usr_id,
                                     'menu_id' => $this->menu_id,
                                     'eliminado' => $this->eliminado));
    }
    
      public function eliminar($submenu_id) { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROMGSUBMENU SET ELIMINADO = '1'  WHERE submenu_id = :submenu_id");
        $rows = $stmt->execute(array('submenu_id' => $submenu_id));
        return $rows;
    }
    
    
    
        public function validarSubMenucount($id) {  //producción 2019
        $stmt = $this->objPdo->prepare("
        SELECT PROMGSUBSUBMENU.submenu_id, PROMGSUBSUBMENU.sub_submenu_id,PROMGSUBSUBMENU.sub_enlacesub,PROMGSUBSUBMENU.sub_titulosub
        from PROMGSUBSUBMENU
         inner join PROMGSUBMENU  on PROMGSUBMENU.submenu_id= PROMGSUBSUBMENU.submenu_id  
        
           where PROMGSUBMENU.submenu_id = '$id' and PROMGSUBSUBMENU.eliminado = '0' order by PROMGSUBSUBMENU.sub_submenu_id asc  


                                   ");
        $stmt->execute();
        $menu = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $menu;
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

        return $submenus[0]->titulosub;

    }
    
   
    
    public function getSubmenu_id() {
        return $this->submenu_id;
    }

    public function setSubmenu_id($submenu_id) {
        $this->submenu_id = $submenu_id;
    }

    public function getTitulosub() {
        return $this->titulosub;
    }

    public function setTitulosub($titulosub) {
        $this->titulosub = $titulosub;
    }

    public function getEnlacesub() {
        return $this->enlacesub;
    }

    public function setEnlacesub($enlacesub) {
        $this->enlacesub = $enlacesub;
    }

    public function getUsr_id() {
        return $this->usr_id;
    }

    public function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    public function getMenu_id() {
        return $this->menu_id;
    }

    public function setMenu_id($menu_id) {
        $this->menu_id = $menu_id;
    }    

    public function getFechareg() {
        return $this->fechareg;
    }

    public function setFechareg($fechareg) {
        $this->fechareg = $fechareg;
    }
    
    function getEliminado() {
        return $this->eliminado;
    }

    function setEliminado($eliminado) {
        $this->eliminado = $eliminado;
    }



}

?>