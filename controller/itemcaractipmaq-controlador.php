<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/itemcaractipmaq.php';
require_once 'model/clasiftipmaq.php';
require_once 'model/usuarios.php';
require_once 'model/tipmaquina.php';
require_once 'controller/class.inputfilter.php';


include 'controller/validar-sesion.php';



function _listarAction() { //producción 2020
    $filter = new InputFilter();

    $itemcaractipmaq = new itemcaractipmaquina();
    $itemcaractipmaquina = $itemcaractipmaq->consultar();


    require 'view/itemcaractipmaq-registro.php';
}

function _ajaxverdetalleitemcaractipmaqAction() {//producción 2020
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $itemcaractipmaq = new itemcaractipmaquina();
    $itemcaractipmaq->obtenerxId($id);
    $permiso = $_POST['permiso'];

    $clasiftipmaq= new clasiftipmaq();
    $clasiftipmaquina = $clasiftipmaq->consultarActivos();
    
    $tipmaquina= new tipomaquina();
    $tipomaquina = $tipmaquina->consultarActivos();



    require_once 'view/itemcaractipmaq-form.php';
}

function _insertarAction() { //producción 2020
//    $menu = new Menu();
//    $menus = $menu->consultar();
    session_start();

    $filter = new InputFilter();


    $itemcaractipmaq_descripcion = $filter->process($_POST["itemcaractipmaq_descripcion"]);
    $itemcaractipmaq_pocision = $filter->process($_POST["itemcaractipmaq_pocision"]);
//    $itemcaracsemi_pocision = $filter->process($_POST["$itemcaracsemi_pocision"]);
    $tipmaq_id = $filter->process($_POST["tipmaq_id"]);
    $clatipmaq_id = $filter->process($_POST["clatipmaq_id"]);

    $estado = $filter->process($_POST["optionsRadios"]);
    
    $itemcaractipmaq_tipodato = $filter->process($_POST["itemcaractipmaq_tipodato"]);
    $itemcaractipmaq_tabla = $filter->process($_POST["itemcaractipmaq_tabla"]);
    $itemcaractipmaq_tabla_id = $filter->process($_POST["itemcaractipmaq_tabla_id"]);
    $itemcaractipmaq_tabla_descripcion = $filter->process($_POST["itemcaractipmaq_tabla_descripcion"]);

    $accion = '';

    $usr = $_SESSION["idusuario"];


    
     try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            
            $id = $filter->process($_GET["id"]);
                $itemcaractipmaq = new itemcaractipmaquina($id, $itemcaractipmaq_descripcion, $itemcaractipmaq_pocision,  
                        $tipmaq_id,$clatipmaq_id, $usr, $estado, $itemcaractipmaq_tipodato, $itemcaractipmaq_tabla,$itemcaractipmaq_tabla_id , $itemcaractipmaq_tabla_descripcion,NULL);
                $itemcaractipmaq->modificar();

                $accion = 'Modificar';
                $bitacora = new bitacora(null, $usr, $accion, 'PROITEMCARACTTIPMAQUINA', null, null);
                $bitacora->insertar();
            
            
        } else {
            $itemcaractipmaq = new itemcaractipmaquina(null, $itemcaractipmaq_descripcion, $itemcaractipmaq_pocision, 
                    $tipmaq_id,$clatipmaq_id, $usr, $estado, $itemcaractipmaq_tipodato, $itemcaractipmaq_tabla,$itemcaractipmaq_tabla_id , $itemcaractipmaq_tabla_descripcion,NULL);
                $itemcaractipmaq->insertar();
            
                $accion = 'Modificar';
                $bitacora = new bitacora(null, $usr, $accion, 'PROITEMCARACTTIPMAQUINA', null, null);
                $bitacora->insertar();
        }

        header("location: index.php?page=itemcaractipmaq&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
 
}



function _eliminarAction() {//producción 2019

    $filter = new InputFilter();
//    $usr = $_SESSION["idusuario"];
    $usr = $filter->process($_SESSION["idusuario"]);


    try {



        $id = $filter->process($_GET['id']);
        $itemcarctipmaq = new itemcaractipmaquina();

        $validar = $itemcarctipmaq->ValidarItemCaracSemit($id);

        if ($validar) {

            echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Este registro mantiene relacion con otros registros')  ; 
              window.location = 'index.php?page=itemcaractipmaq&accion=listar';
                </script>";
        } else {
            $submenu->eliminar($id);
            $accion = 'Eliminar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROITEMCARACTTIPMAQUINA', null, null);
            $bitacora->insertar();

//            $menu->eliminar($id);
            header("location: index.php?page=itemcaractipmaq&accion=listar");
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