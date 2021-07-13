<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/perfiles.php';
require_once 'model/usuarios.php';
require_once 'model/menu.php';
require_once 'model/submenu.php';
require_once 'controller/class.inputfilter.php';
include 'controller/validar-sesion.php';

function _formAction(){

    require 'view/rol-acceso-form.php';
}
function _listarbitacoraAction(){
    $bitacora = new bitacora();
    $listar = $bitacora->consultar();
    require 'view/bitacora-registro.php';
}

function _ajaxveraccesoAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $menu = new Menu();
    $menusper =$menu->getPorPerfil($id);
   
    
     $menus =$menu->getMenu();
    $menus1 =$menu->getMenu();
    
    $submenu = new Submenu();
    $submenus = $submenu->consultar();
    
    
    //$permiso = $_POST['permiso'];

    require_once 'view/vistahtml/perfilesrol-form.php';
}


?>