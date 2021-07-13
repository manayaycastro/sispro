<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/parada.php';
require_once 'model/maquinas.php';
require_once 'model/usuarios.php';
require_once 'model/paradatipo.php';
require_once 'model/kanban.php';
require_once 'model/areas.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';

function _formAction() {//producción 2019  PRUEBAAAAAAAAAAAAAAAAAAAAAAAAAAAA
    require 'view/paradareg2-form.php';
}

function _listarAction() {   //producción 2019  
    $parada = new parada();
    $paradas = $parada->consultar();
    $usuario = new Usuario();


    require 'view/parada-registro.php';
}



function _ajaxverdetalleparadaAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $parada = new parada();
    $parada->obtenerxId($id);
    $permiso = $_POST['permiso'];
//        $permiso = "disabled";

    $paradatipo = new paradatipo();
    $paradatipos = $paradatipo->consultarActivos();

    $area = new areas();
    $areas = $area->consultarActivos();

    require_once 'view/parada-form.php';
//     require 'view/paradareg2-form.php';
}

function _insertarAction() { //producción 2019
    session_start();

    $filter = new InputFilter();

//    $par_id = $filter->process($_POST["par_id"]);
    $par_nombre = $filter->process($_POST["par_nombre"]);


    $tippar_id = $filter->process($_POST["tippar_id"]);
    $are_id = $filter->process($_POST["are_id"]);
    $par_estado = $filter->process($_POST["optionsRadios"]);


    $accion = '';

    $usr = $_SESSION["idusuario"];



    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            $parada = new parada($id, $par_nombre, $par_estado, $usr, $tippar_id, $are_id, NULL);
            $parada->modificar();

            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGPARADA', null, null);
            $bitacora->insertar();
        } else {
            $parada = new parada(null, $par_nombre, $par_estado, $usr, $tippar_id, $are_id, NULL);
            $parada->insertar();

            $accion = 'Insertar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGPARADA', null, null);
            $bitacora->insertar();
        }

        header("location: index.php?page=parada&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}

function _modificarAction() { //producción 2019
    $filter = new InputFilter();

    $id = $filter->process($_GET['id']);

    $parada = new parada();
    $parada->obtenerxId($id);

    $paradatipo = new paradatipo();
    $paradatipos = $paradatipo->consultar();




    require 'view/parada-form.php';
}

function _regformAction() { //producción 2019
    $filter = new InputFilter();

    $parada = new parada();
    $paradas = $parada->consultar();
    $usuario = new Usuario();



    require 'view/paradareg-form.php';
}

function _reglistarAction() { //producción 2019
    $filter = new InputFilter();

    $parada = new parada();
    $paradas = $parada->ListarRegistro();


    require 'view/paradareg-registro.php';
}

function _ajaxparadaregAction() {//producción 2019
    $parada = new parada();
    $paradas = $parada->consultar();

    $paradatipo = new paradatipo();
    $paradatipos = $paradatipo->consultarActivos();

    $area = new areas();
    $areas = $area->consultarActivos();

    $maquina = new maquinas();
    $maquinas = $maquina->consultar();

    require_once 'view/paradareg2-form.php';
}

function _paradaregAction() {//producción 2019
    $parada = new parada();
    $paradas = $parada->consultar();

    $paradatipo = new paradatipo();
    $paradatipos = $paradatipo->consultarActivos();

    $area = new areas();
    $areas = $area->consultarActivos();

    $maquina = new maquinas();
    $maquinas = $maquina->consultar();

    require_once 'view/paradareg2-form.php';
}

function _insertarregAction() { //producción 2019
    session_start();

    $filter = new InputFilter();

//    $par_id = $filter->process($_POST["par_id"]);
    $are_id = $filter->process($_POST["are_id"]);


    $tippar_id = $filter->process($_POST["tippar_id"]);
    $par_id = $filter->process($_POST["par_id"]);
    $maq_id = $filter->process($_POST["maq_id"]);

    $observacion = $filter->process($_POST["observacion"]);
    $inicio = $filter->process($_POST["inicio"]);
    $fin = $filter->process($_POST["fin"]);



    $accion = '';

    $usr = $_SESSION["idusuario"];



    try {

        $parada = new parada ();
        $parada->insertarreg($inicio, $fin, $maq_id, $par_id, $usr, $observacion);

        $accion = 'Insertar';
        $bitacora = new bitacora(null, $usr, $accion, 'PROMGPARADAREG', null, null);
        $bitacora->insertar();



        header("location: index.php?page=parada&accion=reglistar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}

function _eliminarrevAction() {


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

function _ajaxGetmaquinaAction() {

    $are_id = $_POST['area_id'];

    $oarea = new maquinas();

    $maquinas = $oarea->getmaquina($are_id);

     if (count($maquinas)): ?>
      
        <?php foreach ($maquinas as $maquina): ?>
            <option value="<?php echo $maquina ['maq_id'] ;?>" >
            <?php echo $maquina ['maq_nombre']; ?>
            </option>
        <?php endforeach; ?>
     <?php else : ?>
        <?php echo '<option value=-1> No existen registros </option>'; ?>
    <?php endif; ?>
        
        <?php
}

function _ajaxGetparadaAction() {

    $tippar_id = $_POST['tippar_id'];

    $otipoparada = new parada();

    $paradas = $otipoparada->getparada($tippar_id);

     if (count($paradas)): ?>
      
        <?php foreach ($paradas as $parada): ?>
            <option value="<?php echo $parada ['par_id'] ;?>" >
            <?php echo $parada ['par_nombre']; ?>
            </option>
        <?php endforeach; ?>
     <?php else : ?>
        <?php echo '<option value=-1> No existen registros </option>'; ?>
    <?php endif; ?>
        
        <?php
}
 //**********************************************NUEVO FORMULARIO **********************
 
 function _listparadaAction() {//producción 2019  ConsultarMaqXarea
    $proceso_id = '167';
    $area_proc = '4';
    
    
   $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
  
    $listamaquinas = $procesos->ConsultarMaqXarea( $area_proc);
  require_once 'view/paradasregistro-registro.php';
}

function _ajaxparadasAction() {//producción 2019  ajaxvercomentarioped
   
   
    $filter = new InputFilter();

    $id_parada = $filter->process($_POST['id_parada']);
  
    
 
       $parada = new parada();
    $parada->obtenerxId($id_parada);
   // $permiso = $_POST['permiso'];
//        $permiso = "disabled";

    $paradatipo = new paradatipo();
    $paradatipos = $paradatipo->consultarActivos();

    $area = new areas();
    $areas = $area->consultarActivos();
    require_once 'view/vistahtml/mostrarformparada.php';
}

function _insertarreg2Action() { //producción 2019
    session_start();

    $filter = new InputFilter();

//    $par_id = $filter->process($_POST["par_id"]);
    $are_id = $filter->process($_POST["area_id"]);


    $tippar_id = $filter->process($_POST["tippar_id"]);
    $par_id = $filter->process($_POST["par_id"]);
    $maq_id = $filter->process($_POST["maquina_id"]);

    $observacion = $filter->process($_POST["observacion"]);
    $inicio = $filter->process($_POST["id-date-picker-1"]);
    $fin = $filter->process($_POST["id-date-picker-2"]);



    $accion = '';

    $usr = $_SESSION["idusuario"];



    try {

        $parada = new parada ();
        $parada->insertarreg($inicio, $fin, $maq_id, $par_id, $usr, $observacion);

        $accion = 'Insertar';
        $bitacora = new bitacora(null, $usr, $accion, 'PROMGPARADAREG', null, null);
        $bitacora->insertar();



        header("location: index.php?page=parada&accion=listparada");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}


?>
