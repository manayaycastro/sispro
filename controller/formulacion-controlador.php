<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/formulacion.php';
require_once 'model/semiterminado.php';
require_once 'model/usuarios.php';
require_once 'model/maquinas.php';
require_once 'model/areas.php';
require_once 'controller/class.inputfilter.php';


include 'controller/validar-sesion.php';



function _listarAction() { //producción 2019
    $filter = new InputFilter();

    $form = new formulacion();
    $formulacion = $form->consultar();


    require 'view/formulacion-registro.php';
}

function _ajaxverdetalleformulacionAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $form = new formulacion();
    $form->obtenerxId($id);
    $permiso = $_POST['permiso'];

    $semit = new semiterminado();
    $semiterminado = $semit->consultarActivos();
 


    require_once 'view/formulacion-form.php';
}

function _insertarAction() { //producción 2019

    session_start();

    $filter = new InputFilter();

    $tipsem_id = $filter->process($_POST["tipsem_id"]);
    $form_identificacion = $filter->process($_POST["form_identificacion"]);
    $form_campo1 = '1';
    $form_campo2 =  '2';

    $estado = $filter->process($_POST["optionsRadios"]);


    $accion = '';

    $usr = $_SESSION["idusuario"];


        try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
                $form = new formulacion($id, $form_identificacion, $form_campo1, $form_campo2, $tipsem_id, $usr, $estado, NULL);
                $form->modificar();

                $accion = 'Modificar';
                $bitacora = new bitacora(null, $usr, $accion, 'PROFORMULACION', null, null);
                $bitacora->insertar();
        } else {
               $form = new formulacion(null, $form_identificacion, $form_campo1, $form_campo2, $tipsem_id, $usr, $estado, NULL);
                $form->insertar();
              
                $accion = 'Insertar';
                $bitacora = new bitacora(null, $usr, $accion, 'PROFORMULACION', null, null);
                $bitacora->insertar();
            
        }

        header("location: index.php?page=formulacion&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
    
    
    
}











function _ajaxverdetalleformulaciondetAction() {//producción 2019
    
     $filter = new InputFilter();
      $id_form = $filter->process($_POST["id_form"]);
      $tipsem_id = $filter->process($_POST["tipsem_id"]);
      $tipsem_titulo= $filter->process($_POST["tipsem_titulo"]);
//       $form_id= $filter->process($_POST["form_id"]);
    
  $form = new formulacion();
  $listar = $form->listarformulaciondet($tipsem_id,$id_form);



    require_once 'view/vistahtml/mostrarformdet-form.php';
}








function _ajaxmanejarestadoitemformAction() { //producción 2019


    $response = array();

    $usuario = $_SESSION['idusuario'];
    $valitemform_valor = $_POST['valor'];
    $itemform_id= $_POST['id_item_form'];
    $form_id= $_POST['form_id'];
    
    

    $accion= $_POST['accion'];


   

    if ($accion == "agregar") {
        $estado = 0;
        $updateform = new formulacion();
        $status = $updateform->insertarvaloresformul($valitemform_valor,$form_id, $itemform_id, $estado, $usuario);

       
    } else {
        $estado = 1;
        $updateform = new formulacion();
        $status = $updateform->deletevaloresforml($itemform_id,$form_id);
        
    }

    $response["status"] = $status;

    header('Content-Type: application/json');



    echo json_encode($response);
}


function _eliminarAction() {


//    $usr = $_SESSION["idusuario"];
    $usr = $filter->process($_SESSION["idusuario"]);
    $filter = new InputFilter();

    try {



        $id = $filter->process($_GET['id']);
        $maquina = new maquinas();

        $validar = $maquina->validarSubMenucount($id);

        if ($validar) {

            echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Este registro mantiene relacion con otros registros')  ; 
              window.location = 'index.php?page=submenu&accion=listar';
                </script>";
        } else {
            $submenu->eliminar($id);
            $accion = 'Eliminar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGMAQUINAS', null, null);
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