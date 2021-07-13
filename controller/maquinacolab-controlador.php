<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/maquinacolab.php';
require_once 'model/maquinas.php';
require_once 'model/usuarios.php';

require_once 'controller/class.inputfilter.php';


include 'controller/validar-sesion.php';



function _listarAction() { //producción 2019
   

    $maquinacolabordor = new maquinacolab();
  //  $maquinacolab = $maquinacolabordor->consultar();
  $maquinacolab = $maquinacolabordor->consultar();


    require 'view/maquinacolab-registro.php';
}

function _ajaxverdetallemaquinacolabAction() {//producción 2019
  
    
      $filter = new InputFilter();
      $id_emp = $filter->process($_POST["id_emp"]);
   
      $id_area = $filter->process($_POST["id_area"]);
      $permiso = $filter->process($_POST["permiso"]);

    
  $maquinas = new maquinas();
  $listar = $maquinas->ConsultarxAreaReferencia($id_area, $id_emp);



    require_once 'view/vistahtml/mostrarformmaqcolab-form.php';
}


function _ajaxasignarmaqcolAction() { //producción 2019
    $response = array();

    $usuario = $_SESSION['idusuario'];

    $idmaq = $_POST['idmaq']; 
    $id_emp= $_POST['id_emp'];
    $id= $_POST['id'];

    $accion = $_POST['accion'];

    if ($accion == "agregar") {
        $estado = 1;

             
         $maqcol = new maquinacolab();
        $status = $maqcol->insertarMaqColab($idmaq,$id_emp,  $estado,$usuario);
    } else {
       $estado = 0;
        $maqcol = new maquinacolab();

        $status = $maqcol->deleteMaqColab($id);
    }

    $response["status"] = $status;

    header('Content-Type: application/json');



    echo json_encode($response);
}
























function _ajaxverdetalleitemformAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $itemform = new itemformulacion();
    $itemform->obtenerxId($id);
    $permiso = $_POST['permiso'];

    $clasifsemit= new clasifsemit();
    $clasifsemiterminado = $clasifsemit->consultarActivos();
    
    $semiterminado= new semiterminado();
    $semiterminados = $semiterminado->consultarActivos();



    require_once 'view/maquinacolab-form.php';
}

function _insertarAction() { //producción 2019

    session_start();

    $filter = new InputFilter();


    $itemform_descripcion = $filter->process($_POST["itemform_descripcion"]);
    $itemform_pocision = $filter->process($_POST["itemform_pocision"]);

    $tipsem_id = $filter->process($_POST["tipsem_id"]);
    $clasem_id = $filter->process($_POST["clasem_id"]);

    $estado = $filter->process($_POST["optionsRadios"]);


    $accion = '';

    $usr = $_SESSION["idusuario"];


    
     try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            
            $id = $filter->process($_GET["id"]);
                $itemform = new itemformulacion($id, $itemform_descripcion, $itemform_pocision,  $tipsem_id,$clasem_id, $usr, $estado, NULL);
                $itemform->modificar();

                $accion = 'Modificar';
                $bitacora = new bitacora(null, $usr, $accion, 'PROITEMFORMULACION', null, null);
                $bitacora->insertar();
            
            
        } else {
            $itemform = new itemformulacion(null, $itemform_descripcion, $itemform_pocision, $tipsem_id,$clasem_id, $usr, $estado, NULL);
            $itemform->insertar();
            
                $accion = 'Modificar';
                $bitacora = new bitacora(null, $usr, $accion, 'PROITEMFORMULACION', null, null);
                $bitacora->insertar();
        }

        header("location: index.php?page=itemformulacion&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
 
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