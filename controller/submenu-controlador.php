<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/submenu.php';
require_once 'model/usuarios.php';
require_once 'model/menu.php';
require_once 'controller/class.inputfilter.php';


include 'controller/validar-sesion.php';

function _formAction(){
 
   require 'view/submenu-form.php';
}

function _listarAction(){   //producción 2019  

    $submenu = new Submenu();
    $submenus = $submenu->consultar();
    $usuario = new Usuario();

   
    require 'view/submenu-registro.php';
}

function _ajaxverdetallesubmenuAction() {//producción 2019
   
    if(!empty($_POST['id'])){
         $id = $_POST['id'];
     
    }else{
        $id = 0;
    }
       $submenu = new Submenu();
    $submenu->obtenerxId($id);
    $permiso = $_POST['permiso'];
      
    $menu = new Menu();
    $menus = $menu->consultar();

    require_once 'view/submenu-form.php';
}



function _insertarAction(){ //producción 2019
//    $menu = new Menu();
//    $menus = $menu->consultar();

    session_start();
    
    $filter = new InputFilter();
    
    $submenu1 = $filter->process($_POST["submenu"]);
    $menu = $filter->process($_POST["menu"]);
    $enlacesub = $filter->process($_POST["enlacesub"]);
    $usr = $_SESSION["idusuario"];

    $accion= '';
   
    try{
        if (!empty($_GET["id"])){
            $id = $filter->process($_GET["id"]);
            $submenu = new Submenu($id, $submenu1, $enlacesub, $usr, null, $menu,'0');
            $submenu->modificar();
            
             $accion = 'Modificar';
            $bitacora = new bitacora(null,$usr,$accion,'PROMGSUBMENU',null,null);
            $bitacora->insertar();

        }else{
            $submenu = new Submenu(null, $submenu1, $enlacesub, $usr,NULL, $menu, '0');
            $submenu->insertar();
            
             $accion = 'Insertar';
            $bitacora = new bitacora(null,$usr,$accion,'PROMGSUBMENU',null,null);
            $bitacora->insertar();
          
        }

        header("location: index.php?page=submenu&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}

function _modificarAction(){ //producción 2019
    $filter = new InputFilter();
    
    $id = $filter->process($_GET['id']);
    
    $submenu = new Submenu();
    $submenu->obtenerxId($id);

           $menu = new Menu();
    $menus = $menu->consultar();
    $oMenus = new Menu();



    require 'view/submenu-form.php';   
}

function _eliminarAction(){
    /*
     * Funcion para eliminar un registro
     */
//    session_start();

//    $usr = $_SESSION["idusuario"];
  

    $filter = new InputFilter();
       $usr = $filter->process($_SESSION["idusuario"]);
    try{
        
        
        
        $id = $filter->process($_GET['id']); 
        $submenu = new Submenu();
      
        
        
//         $id = $filter->process($_GET['id']);
//        $menu = new Menu();
        $validar = $submenu->validarSubMenucount($id);

        if ($validar) {

            echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Este registro mantiene relacion con otros registros')  ; 
              window.location = 'index.php?page=submenu&accion=listar';
                </script>";
        } else {
              $submenu->eliminar($id);
                $accion = 'Eliminar';
            $bitacora = new bitacora(null,$usr,$accion,'PROMGSUBMENU',null,null);
            $bitacora->insertar();
              
              
//            $menu->eliminar($id);
            header("location: index.php?page=submenu&accion=listar");
        }
        
        
        
        
        
        

       
//        header("location: index.php?page=submenu&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}

?>