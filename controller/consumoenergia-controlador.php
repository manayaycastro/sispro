<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/maquinas.php';
require_once 'model/maquinameta.php';
require_once 'model/usuarios.php';
require_once 'model/areas.php';
require_once 'controller/class.inputfilter.php';

require_once 'model/consumoenergia.php';
include 'controller/validar-sesion.php';

function _listarAction() { //producción 2019
    $filter = new InputFilter();

    $energiames = new consumoenergia();
    $energiameses = $energiames->consultar();


    require 'view/consumoenergia-registro.php';
}

function _ajaxverdetalleconenergAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }

    $consumomes = new consumoenergia();
    $consumomes->obtenerxId($id);
    $permiso = $_POST['permiso'];


    require_once 'view/consumoenergia-form.php';
}

function _insertarAction() { //producción 2019
    session_start();

    $filter = new InputFilter();

    $conener_anio = $filter->process($_POST["conener_anio"]);
    $conener_mes = $filter->process($_POST["conener_mes"]);
    $conener_valorimp = $filter->process($_POST["conener_valorimp"]);
    $conener_valorcon = $filter->process($_POST["conener_valorcon"]);

    $estado = $filter->process($_POST["optionsRadios"]);


    $accion = '';

    $usr = $_SESSION["idusuario"];


    $validacion = new consumoenergia();
    $validar = $validacion->validarConsumoMes($conener_anio, $conener_mes);



    if ($validar and empty($_GET["id"])) {
        echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Esta programación para esta mes y año ya existen')  ; 
              window.location = 'index.php?page=consumoenergia&accion=listar';
                </script>";
    } elseif ($validar and ! empty($_GET["id"])) {
        try {

            $id = $filter->process($_GET["id"]);
            $consumomes = new consumoenergia($id, $conener_anio, $conener_mes, $conener_valorimp, $conener_valorcon, $usr, $estado, NULL);
            $consumomes->modificar();

            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROCONSUMOENERG', null, null);
            $bitacora->insertar();


            header("location: index.php?page=consumoenergia&accion=listar");
            die;
        } catch (Exception $exc) {
            $error = urlencode($exc->getTraceAsString());
            header("location: error.php?mssg=:$error");
            die;
        }
    } else {
        try {


            $consumomes = new consumoenergia(null, $conener_anio, $conener_mes, $conener_valorimp, $conener_valorcon, $usr, $estado, NULL);
            $consumomes->insertar();



            $accion = 'Insertar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROCONSUMOENERG', null, null);
            $bitacora->insertar();


            header("location: index.php?page=consumoenergia&accion=listar");
            die;
        } catch (Exception $exc) {
            $error = urlencode($exc->getTraceAsString());
            header("location: error.php?mssg=:$error");
            die;
        }
    }
}

function _ajaxProrratearConsAreaAction() { //producción 2019
    $response = array();

    $usuario = $_SESSION['idusuario'];

    $idconsumomes = $_POST['idconsumomes'];
    $id_importe = $_POST['id_importe'];

    $accion = $_POST['accion'];
    $consumomensual = new consumoenergia();
    if ($accion == "agregar") {
        $estado = 0;

        $areas = new areas();
        $totalareas = $areas->consultarActivos();
        $prorrateo = 100 / count($totalareas);

        if ($totalareas) {
            foreach ($totalareas as $area) {
                $area_id = $area['are_id'];
                $status = $consumomensual->InserProrratArea($idconsumomes, $area_id, $prorrateo, $estado, $usuario);
            }
        }

        $status = $consumomensual->updateConEnerMen1($idconsumomes);
    } else {

        $status = $consumomensual->updateConEnerMen0($idconsumomes);
        $status = $consumomensual->deleteConEnerMen($idconsumomes);
    }

    $response["status"] = $status;

    header('Content-Type: application/json');



    echo json_encode($response);
}

function _ajaxverdetallePorcenAreasAction() { //producción 2019
    $filter = new InputFilter();
    $id = $filter->process($_POST["id"]);


    $listaporcentajeareas = new consumoenergia();
    $listar = $listaporcentajeareas->ConsumoPorcentMest($id);



    require_once 'view/vistahtml/consumoprorramesare-form.php';
}

function _ajaxProrratearConsMaquiAction() { //producción 2019
    $response = array();

    $usuario = $_SESSION['idusuario'];

    $idprorra_area = $_POST['idprorra_area']; // ID DE LA TABLA CONSUMO ENERGIA
    $id = $_POST['id']; // ID DEL AREA
     $valorporcentaje = $_POST['valorporcentaje'];

    $accion = $_POST['accion'];

    if ($accion == "agregar") {
        $estado = 0;

        $maquinas = new maquinas();
        $maquinasxarea = $maquinas->ConsultarxArea($id);

        $prorrateo = 100 / count($maquinasxarea);

        if ($maquinasxarea) {
            foreach ($maquinasxarea as $maq) {
                $maq_id = $maq['maq_id'];
                
                 $consumo = new consumoenergia();
                $status = $consumo->InserProrratMaq($idprorra_area, $maq_id, $prorrateo, $estado, $usuario);
            }
        }
        
         $consumomen = new consumoenergia();
        $status = $consumomen->updateConEnerProAreas($idprorra_area, $valorporcentaje);
    } else {

//         $status = $consumomensual->updateConEnerMen0($idconsumomes);
//         $status = $consumomensual->deleteConEnerMen($idconsumomes);
    }

    $response["status"] = $status;

    header('Content-Type: application/json');



    echo json_encode($response);
}


function _ajaxverdetallePorcenMaqAction() { //producción 2019
    $filter = new InputFilter();
    $id_consumomaqu = $filter->process($_POST["id_consumomaqu"]);
    $valorporcentaje= $filter->process($_POST["valorporcentaje"]);
    $id_area= $filter->process($_POST["id_area"]);


    $listaporcentajemaq = new consumoenergia();
    $listar = $listaporcentajemaq->ConsumoPorcentMesMaq($id_consumomaqu);



    require_once 'view/vistahtml/consumoprorramesmaq-form.php';
}



function _ajaxupdateporcemaqAction() { //producción 2019
    $response = array();

    $usuario = $_SESSION['idusuario'];

    $idprorra_maq = $_POST['idprorra_maq']; 
    $valorporcentaje= $_POST['valorporcentaje'];

    $accion = $_POST['accion'];

    if ($accion == "agregar") {
        $estado = 1;

             
         $consumomen = new consumoenergia();
        $status = $consumomen->updateConEnerMaq($estado,$idprorra_maq,$valorporcentaje);
    } else {

//         $status = $consumomensual->updateConEnerMen0($idconsumomes);
//         $status = $consumomensual->deleteConEnerMen($idconsumomes);
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