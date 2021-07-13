<?php

/**
 * 
 */
require_once 'conexion.php';

// fetch (PDO :: FETCH_ASSOC) – Las filas son matrices con índices con nombre.
//fetch (PDO :: FETCH_NUM) – Las filas son matrices con índices numéricos.
//fetch (PDO :: FETCH_OBJ) o fetch (PDO :: FETCH_CLASS) dependiendo de si especifica 

class Menu {

    private $menu_id;
    private $titulo;
    private $enlace;
    private $posicion;
    private $usr_id;
    private $fecha_creacion;
    private $icon;
    private $eliminado;
    
    private $objPdo;

    public function __construct($menu_id = Null, $titulo = '', $enlace = '', $posicion = '', $usr_id = '', $fecha_creacion = '', $icon= '',$eliminado = '') {
        $this->menu_id = $menu_id;
        $this->titulo = $titulo;
        $this->enlace = $enlace;
        $this->posicion = $posicion;
        $this->usr_id = $usr_id;
        $this->fecha_creacion = $fecha_creacion;
        $this->icon = $icon;
        $this->eliminado = $eliminado;
        $this->objPdo = new Conexion();
    }

    public function insertar() { //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROMGMENU (titulo, enlace, posicion, usr_id, icon,eliminado) 
                                        VALUES(:titulo,
                                               :enlace,
                                               :posicion,
                                               :usr_id,
                                               :icon,
                                               :eliminado)');
        $rows = $stmt->execute(array('titulo' => $this->titulo,
            'enlace' => $this->enlace,
            'posicion' => $this->posicion,
            'usr_id' => $this->usr_id,
            'icon' => $this->icon,
            'eliminado' => $this->eliminado));
    }

    public function obtenerxId($menu_id) { //producción 2019
        $stmt = $this->objPdo->prepare('SELECT * FROM PROMGMENU WHERE menu_id = :menu_id');
        $stmt->execute(array('menu_id' => $menu_id));
        $mus = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($mus)) {
            foreach ($mus as $mu) {
                $this->setmenu_id($mu ['menu_id']);
                $this->settitulo($mu ['titulo']);
                $this->setenlace($mu ['enlace']);
                $this->setposicion($mu ['posicion']);
                $this->setusr_id($mu ['usr_id']);
                $this->setIcon($mu ['icon']);
                $this->setfecha_creacion($mu ['fecha_creacion']);
            }
        }
        return $this;
    }

    public function modificar() { //producción 2019
        $stmt = $this->objPdo->prepare('UPDATE PROMGMENU SET titulo=:titulo, enlace=:enlace, posicion=:posicion, usr_id=:usr_id, icon=:icon ,fecha_creacion = SYSDATETIME()
                                        WHERE menu_id = :menu_id');
        $rows = $stmt->execute(array('titulo' => $this->titulo,
            'enlace' => $this->enlace,
            'posicion' => $this->posicion,
            'usr_id' => $this->usr_id,
            'icon' => $this->icon,
            'menu_id' => $this->menu_id));
    }
    

    public function getPorPerfil($per_id) {   //producción 2019
        $stmt = $this->objPdo->prepare("
            SELECT per.menu_id , ico.ico_descripcion,men.titulo
	
FROM PROMGMENU_PERFIL per
inner join PROMGMENU men on men.menu_id = per.menu_id
LEFT join PROMGICONS ico on ico.ico_id = men.icon
 WHERE per_id = '$per_id' ORDER BY menu_id
                ");
        $stmt->execute();
        $menu = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        return $menu;
    }

    public function eliminar($menu_id) { //producción 2019
        $stmt = $this->objPdo->prepare("update  PROMGMENU set eliminado = '1' WHERE menu_id=:menu_id");
        $rows = $stmt->execute(array('menu_id' => $menu_id));
        return $rows;
    }
        
    
    public function consultar() {//producción 2019
        $stmt = $this->objPdo->prepare("SELECT m.*,ico.ico_descripcion
 FROM PROMGMENU  m
 left join PROMGICONS ico on ico.ico_id = m.icon
 where m.eliminado = '0' ORDER BY m.posicion asc;");
        $stmt->execute();
        $menus = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        return $menus;
    }
    
    public function validarMenucount($id) {  //producción 2019
        $stmt = $this->objPdo->prepare("SELECT PROMGMENU.menu_id

                                    FROM PROMGSUBMENU 
                                    inner join PROMGMENU on PROMGMENU.menu_id = PROMGSUBMENU.menu_id

                                   WHERE PROMGMENU.menu_id=:id and PROMGSUBMENU.eliminado = '0'");
        $stmt->execute(array('id' => $id));
        $menu = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $menu;
    }
    
        public function getMenu() {  //producción 2019
        $stmt = $this->objPdo->prepare("SELECT m.*,ico.ico_descripcion
 FROM PROMGMENU  m
 left join PROMGICONS ico on ico.ico_id = m.icon
 where m.eliminado = '0' ORDER BY m.posicion asc;");
        $stmt->execute();
        $menu = $stmt->fetchAll();
        return $menu;
    }
    
        public function getSubMenu($id) {//producción 2019
        $stmt = $this->objPdo->prepare("SELECT submenu_id, titulosub, enlacesub, menu_id FROM PROMGSUBMENU WHERE menu_id=:id and eliminado = '0' order by submenu_id asc");
        $stmt->execute(array('id' => $id));
        $menu = $stmt->fetchAll();
        return $menu;
    }
    
    
    public function Subsubmenu($sub) {

        $stmt = $this->objPdo->prepare("SELECT PROMGSUBSUBMENU.submenu_id, PROMGSUBSUBMENU.sub_submenu_id,PROMGSUBSUBMENU.sub_enlacesub,PROMGSUBSUBMENU.sub_titulosub
                                            from PROMGSUBSUBMENU
                                            inner join PROMGSUBMENU  on PROMGSUBMENU.submenu_id= PROMGSUBSUBMENU.submenu_id  
                                            inner join PROMGMENU on  PROMGMENU.menu_id =PROMGSUBMENU.menu_id
                                            where PROMGSUBMENU.submenu_id =:id and PROMGSUBSUBMENU.eliminado = '0' order by PROMGSUBSUBMENU.sub_submenu_id asc");
        $stmt->execute(array('id' => $sub));
        $menu = $stmt->fetchAll();
        return $menu;
    }
    
    
    public function obtenerNombrexId($menu) {
        $stmt = $this->objPdo->prepare('SELECT titulo FROM menu WHERE menu_id = :menu_id');
        $stmt->execute(array('menu_id' => $submenu));
        $menus = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $menus[0]->titulo;
    }

    public function getSubMenu2($menu_id) {
        $sql = "SELECT *
                FROM  submenu sub
                INNER JOIN menu men
                ON sub.menu_id = men.menu_id
                WHERE men.menu_id = :menu_id;";

        $stmt = $this->objPdo->prepare($sql);

        $stmt->execute(array('menu_id' => $menu_id));


        $submenu = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $submenu;
    }

    public function getSubMenucount($id) {
        $stmt = $this->objPdo->prepare('SELECT count(PROMGMENU.menu_id) as count1

                                    FROM PROMGSUBMENU 
                                    inner join PROMGMENU on PROMGMENU.menu_id = PROMGSUBMENU.menu_id

                                   WHERE PROMGMENU.menu_id=:id');
        $stmt->execute(array('id' => $id));
        $menu = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $menu;
    }





    public function Subsubmenucount($sub) {

        $stmt = $this->objPdo->prepare("SELECT  count (PROMGSUBSUBMENU.submenu_id) as count1
                                            from PROMGSUBSUBMENU
                                            inner join PROMGSUBMENU  on PROMGSUBMENU.submenu_id= PROMGSUBSUBMENU.submenu_id  
                                            inner join PROMGMENU on  PROMGMENU.menu_id =PROMGSUBMENU.menu_id
                                            where PROMGSUBMENU.submenu_id = '$sub' ");
        $stmt->execute();
        $menu = $stmt->fetchAll();
        return $menu;
    }
    
     public function listaricons() {//producción 2019
        $stmt = $this->objPdo->prepare("SELECT * from PROMGICONS");
        $stmt->execute();
        $icons = $stmt->fetchAll(PDO :: FETCH_ASSOC);
        return $icons;
    }


    

    public function getmenu_id() {
        return $this->menu_id;
    }

    public function setmenu_id($menu_id) {
        $this->menu_id = $menu_id;
    }

    public function gettitulo() {
        return $this->titulo;
    }

    public function settitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getenlace() {
        return $this->enlace;
    }

    public function setenlace($enlace) {
        $this->enlace = $enlace;
    }

    public function getposicion() {
        return $this->posicion;
    }

    public function setposicion($posicion) {
        $this->posicion = $posicion;
    }

    public function getusr_id() {
        return $this->usr_id;
    }

    public function setusr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    public function getfecha_creacion() {
        return $this->fecha_creacion;
    }

    public function setfecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }
    function getEliminado() {
        return $this->eliminado;
    }

    function setEliminado($eliminado) {
        $this->eliminado = $eliminado;
    }
    function getIcon() {
        return $this->icon;
    }

    function setIcon($icon) {
        $this->icon = $icon;
    }



}
?>

