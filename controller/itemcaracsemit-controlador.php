<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/itemcaracsemit.php';
require_once 'model/clasifsemit.php';
require_once 'model/usuarios.php';
require_once 'model/semiterminado.php';
require_once 'controller/class.inputfilter.php';


include 'controller/validar-sesion.php';



function _listarAction() { //producción 2019
    $filter = new InputFilter();

    $itemcaracsemit = new itemcarcsemiterminado();
    $itemcaracsemiterminado = $itemcaracsemit->consultar();


    require 'view/itemcaracsemit-registro.php';
}

function _ajaxverdetalleitemcaracsemitAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $itemcaracsemit = new itemcarcsemiterminado();
    $itemcaracsemit->obtenerxId($id);
    $permiso = $_POST['permiso'];

    $clasifsemit= new clasifsemit();
    $clasifsemiterminado = $clasifsemit->consultarActivos();
    
    $semiterminado= new semiterminado();
    $semiterminados = $semiterminado->consultarActivos();



    require_once 'view/itemcaracsemit-form.php';
}

function _insertarAction() { //producción 2019
//    $menu = new Menu();
//    $menus = $menu->consultar();
    session_start();

    $filter = new InputFilter();


    $itemcaracsemi_descripcion = $filter->process($_POST["itemcaracsemi_descripcion"]);
    $itemcaracsemi_pocision = $filter->process($_POST["itemcaracsemi_pocision"]);
//    $itemcaracsemi_pocision = $filter->process($_POST["$itemcaracsemi_pocision"]);
    $tipsem_id = $filter->process($_POST["tipsem_id"]);
    $clasem_id = $filter->process($_POST["clasem_id"]);

    $estado = $filter->process($_POST["optionsRadios"]);
    
    $itemcaracsemi_tipodato = $filter->process($_POST["itemcaracsemi_tipodato"]);
    $itemcaracsemi_tabla = $filter->process($_POST["itemcaracsemi_tabla"]);
    $itemcaracsemi_tabla_id = $filter->process($_POST["itemcaracsemi_tabla_id"]);
    $itemcaracsemi_tabla_descripcion = $filter->process($_POST["itemcaracsemi_tabla_descripcion"]);

    $accion = '';

    $usr = $_SESSION["idusuario"];


    
     try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            
            $id = $filter->process($_GET["id"]);
                $itemcaracsemit = new itemcarcsemiterminado($id, $itemcaracsemi_descripcion, $itemcaracsemi_pocision,  
                        $tipsem_id,$clasem_id, $usr, $estado, $itemcaracsemi_tipodato, $itemcaracsemi_tabla,$itemcaracsemi_tabla_id , $itemcaracsemi_tabla_descripcion,NULL);
                $itemcaracsemit->modificar();

                $accion = 'Modificar';
                $bitacora = new bitacora(null, $usr, $accion, 'PROITEMCARACTSEMITERMINADO', null, null);
                $bitacora->insertar();
            
            
        } else {
            $itemcaracsemit = new itemcarcsemiterminado(null, $itemcaracsemi_descripcion, $itemcaracsemi_pocision, 
                    $tipsem_id,$clasem_id, $usr, $estado, $itemcaracsemi_tipodato, $itemcaracsemi_tabla,$itemcaracsemi_tabla_id , $itemcaracsemi_tabla_descripcion,NULL);
                $itemcaracsemit->insertar();
            
                $accion = 'Modificar';
                $bitacora = new bitacora(null, $usr, $accion, 'PROITEMCARACTSEMITERMINADO', null, null);
                $bitacora->insertar();
        }

        header("location: index.php?page=itemcaracsemit&accion=listar");
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
        $itemcarcsemit = new itemcarcsemiterminado();

        $validar = $itemcarcsemit->ValidarItemCaracSemit($id);

        if ($validar) {

            echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Este registro mantiene relacion con otros registros')  ; 
              window.location = 'index.php?page=itemcaracsemit&accion=listar';
                </script>";
        } else {
            $submenu->eliminar($id);
            $accion = 'Eliminar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGMAQUINAS', null, null);
            $bitacora->insertar();

//            $menu->eliminar($id);
            header("location: index.php?page=itemcaracsemit&accion=listar");
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