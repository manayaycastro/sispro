<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/diseno.php';
require_once 'model/usuarios.php';
require_once 'model/articulocaractecnicas.php';
require_once 'controller/class.inputfilter.php';
require_once 'model/artsemiterminado.php';
require_once 'model/itemcaracsemit.php';
require_once 'model/semiterminado.php';

include 'controller/validar-sesion.php';


function _listarAction() { //producción 2019
	$tipsem_id = '2';
	
    $artsemiter = new articulocaractecnicas();
    $artsemiterminado_lista = $artsemiter->consultar($tipsem_id);


    require 'view/articulocaractecnicas-registro.php';
}

function _ajaxverformAction() {   //PRODUCCION 2019 
   if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
      $tipsemi = $_POST['tipsemi'];
      
    
    
    $artsemiter = new artsemiterminado();
    $artsemiter->obtenerxId($id);
    $permiso = "disabled";
    
    $art = new diseno();
    $articulos = $art->consultarART();
    
    $idsemiterminado = $id;
    
//***********************prueba
    
$artcaractecnicas = new articulocaractecnicas();
    $clasif =$artcaractecnicas->listaClasificacion($tipsemi);
    $clasif1 =$artcaractecnicas->listaClasificacion($tipsemi);

    $items = $artcaractecnicas->consultaritemXtipoFinal($id,$tipsemi);

   
    require 'view/articulocaractecnicas-form.php';
}

function _ajaxverformparchAction() {   //PRODUCCION 2019 
   if (!empty($_POST['id'])) {
        $id = $_POST['id'];
         $descr = $_POST['descr'];
    } else {
        $id = 0;
         $descr = '';
    }
      $tipsemi = $_POST['tipsemi'];
       
      
    
    
    $artsemiter = new artsemiterminado();
    $artsemiter->obtenerxId($id);
    $permiso = "disabled";
    
    $art = new diseno();
    $articulos = $art->consultarART();
    
    $idsemiterminado = $id;
    
//***********************prueba
    
$artcaractecnicas = new articulocaractecnicas();
    $clasif =$artcaractecnicas->listaClasificacion($tipsemi);
    $clasif1 =$artcaractecnicas->listaClasificacion($tipsemi);

    $items = $artcaractecnicas->consultaritemXtipoFinal($id,$tipsemi);

   
    require 'view/articulocaractecnicasparch-form.php';
}


function _insertarAction() { //producción 2019

    session_start();

    $filter = new InputFilter();


    $artsemi_descripcion = $filter->process($_POST["nombreart"]); //nombre del articulo
    $col_id = '0';
//    $itemcaracsemi_pocision = $filter->process($_POST["$itemcaracsemi_pocision"]);
    $tipsem_id =  $filter->process($_POST["tipsemi"]); // tipo de semiterminado SACOS
    $form_id = '0';

    $estado = '0';


    $accion = '';

    $usr = $_SESSION["idusuario"];
     $artsemi_art = $filter->process($_POST["articulos"]);
     $idsemiterminado = $filter->process($_POST["idsemiterminado"]);//codigo  del semiterminado
     


    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);

          //  $id = $filter->process($_GET["id"]);
            $artsemiter = new artsemiterminado($id, $artsemi_descripcion, $col_id, $tipsem_id, $artsemi_art, $usr, $estado, NULL);
            $artsemiter->modificar();

                            $listaitemcarac = new itemcarcsemiterminado();
                            $items = $listaitemcarac->consultaritemXtipoFinal($tipsem_id,$idsemiterminado);

                            if ($items) {
                                foreach ($items as $item) {
                                   
                                        $valor = $filter->process($_POST[$item["itemcaracsemi_id"]]); //valor del campo de texto - item carac
                                        $itemcarac = $item["itemcaracsemi_id"]; //valor del campo de texto - item carac
                                        $val_item_carac_id = $item["valitemcarac_id"]; // verificar si un nuevo item a sido insertado me mostrara 0 , entonces hay que insertarlo
                                        
                                        if($val_item_carac_id > 0){
                                            $modif = new artsemiterminado();
                                        $modif->modificarValores($id, $itemcarac ,  $valor, $usr, '1'); 
                                        }else{
                                            $insertar = new artsemiterminado();
                                        $insertar->insertarValores($id,$itemcarac, $valor, $usr, '0');
                                        }
                                        
                                      
                                 
                                }
                            }


        } else {
            $artsemiter = new artsemiterminado(null, $artsemi_descripcion, $col_id, $tipsem_id, $artsemi_art, $usr, $estado, NULL);
            $artsemiter->insertar();

            $nuevoID = $artsemiter->nuevoIdRegistro();
            if ($nuevoID) {
                foreach ($nuevoID as $nid) {
                    $idfin = $nid["id"];
                }
            }


            $listaitemcarac = new itemcarcsemiterminado();
            $items = $listaitemcarac->consultaritemXtipo($tipsem_id);

            if ($items) {
                foreach ($items as $item) {
                    $valor = $filter->process($_POST[$item["itemcaracsemi_id"]]);
                    $insertar = new artsemiterminado();
                    $insertar->insertarValores($idfin, $item["itemcaracsemi_id"], $valor, $usr, '0');
                }
            }



        }
	if($tipsem_id == '2'){
		
		header("location: index.php?page=articulocaractecnicas&accion=listar");
	}else{
		header("location: index.php?page=articulocaractecnicas&accion=listarParch");
		
	}
	
        
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}
function _cargarportipsemiAction() {//producción 2019

    $id = $_GET["id2"];
    $permiso = $_GET["permiso"];
    $idart = $_GET["idsemiterminado"];

    $listaitemcarac = new itemcarcsemiterminado();
    $items = $listaitemcarac->consultaritemXtipoFinal($id, $idart);

    $clasifi = $listaitemcarac->consultaritemXtipoXclase($id);

    $html = " ";

    $a = 0;
    
    

    
        $html .= "<div>  no existe carácteristicas para este tipo de formulación. Dede crearlas antes.</div>";
    


    echo $html;
}


function _ajaxListarTelaresAction() {//producción 2019  ajaxvercomentarioped
   
    
    $idsemiterminado = $_POST['idsemiterminado'];
    $tipsemi = $_POST['tipsemi'];
     
    $maquina = new artsemiterminado();
    
    $maquinas =$maquina->AsignarMaquinaporTipoSemniterminado($idsemiterminado,$tipsemi );

    require_once 'view/vistahtml/mostrarmaquina2-form.php';
}




function _ajaxregistrarmaqsemiterminadoAction() { //producción 2019


    $response = array();

    $usuario = $_SESSION['idusuario'];

    $maq_id = $_POST['maq_id'];
    $velocInicial= $_POST['velocInicial'];
    $id_semit= $_POST['id_semit'];
     $puestapunto= $_POST['puestapunto'];
      $asig_maq_semi = $_POST['asig_maq_semi'];
      

    $accion= $_POST['accion'];



    if ($accion == "agregar") {
        $estado = 0;
        $registrar_maq_semiterminado = new artsemiterminado();
        $status = $registrar_maq_semiterminado->registrar_maq_semiterminadoTela
                ($estado,$estado,$id_semit,$maq_id,$usuario,$estado,$velocInicial,$puestapunto);

       
    } else {
        $estado = 1;
        $updatemetadet = new artsemiterminado();
        $status = $updatemetadet->update_maq_semiterminadoTela($asig_maq_semi);
        
    }

    $response["status"] = $status;

    header('Content-Type: application/json');



    echo json_encode($response);
}

function _listarParchAction() { //producción 2019
	
	$tipsem_id = '8';
    $artsemiter = new articulocaractecnicas();
    
    $artsemiterminado_lista = $artsemiter->consultar($tipsem_id);


    require 'view/articulocaractecnicasparch-registro.php';
}


function _ArtCintFormAction() {//producción 2021  
   $tipo='RelacionArtCintForm';
    require_once 'view/reportartcinform-form.php';
}
function _ArtCintFormImpAction() {//producción 2021  
  $filter = new InputFilter();


    $tipocinta = $filter->process($_POST["tipo"]); 
      $artsemiter = new articulocaractecnicas();
    if($tipocinta=='trama'){
        
    
    $trama = $artsemiter->listaArtCintTrama();

    }elseif($tipocinta=='urdimbre'){
           $urdimbre = $artsemiter->listaArtCintUrdimbre(); 
    }elseif($tipocinta=='Todos'){
            $todos = $artsemiter->listaArtCintTramaUrdimbre();
    }
    
    require_once 'view/reportes/reporte-artcinform.php';
}
?>
