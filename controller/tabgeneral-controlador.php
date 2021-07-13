<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/tabgeneral.php';
require_once 'model/usuarios.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';



function _listarAction() {   
    $tabgen = new tabgeneral();
    $tabgeneral = $tabgen->consultar();
    
   

    $usuario = new Usuario();

    require 'view/tabgeneral-registro.php';
}




function _ajaxverdetalletabgenAction() {
    
     $tabgen = new tabgeneral();
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
       
    } else {
        $id = 0;
       
    }
   
    $tabgen->obtenerxId($id);
    
    $permiso = $_POST['permiso'];

    require_once 'view/tabgeneral-form.php';
}

function _insertarAction() {
   

    $filter = new InputFilter();

    $tabgen_nombre = $filter->process($_POST["tabgen_nombre"]);
    $tabgen_identificador = $filter->process($_POST["tabgen_identificador"]);
    $estado = $filter->process($_POST["optionsRadios"]);
   
    $usr = $filter->process($_SESSION["idusuario"]);

    

    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            $area = new tabgeneral($id, $tabgen_nombre, $usr, $estado, null,$tabgen_identificador);
            $area->modificar();

           
        } else {
            $area = new tabgeneral(null, $tabgen_nombre, $usr, $estado, null,$tabgen_identificador);
            $area->insertar();

           
        }

        header("location: index.php?page=tabgeneral&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
    
  
}



function _eliminarAction() {
 
    $filter = new InputFilter();
    $usr = $filter->process($_SESSION["idusuario"]);
    try {
        $id = $filter->process($_GET['id']);
        $tabgen = new tabgeneral();
        $tabgen->eliminar($id);

   


        header("location: index.php?page=tabgeneral&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}


function _ajaxFormRegisTabGenDetAction() {
    
     $filter = new InputFilter();
   
  $tabgen_id = $filter->process($_POST["tabgen_id"]);

     
 $tabgen = new tabgeneral();

  
          $tabgenid = $tabgen->consultarActivosXid( $tabgen_id);
	  $lista = $tabgen->consultarActivosXtabGen($tabgen_id);
 
  require_once 'view/vistahtml/mostrarregistrotabgen-form.php';
}
function _insertarDetAction() { //producción 2019
    $response = array();

    $filter = new InputFilter();

    $tabgen_id = $filter->process($_POST['tabgen_id']);
    $tabgendet_nombre = $filter->process($_POST['tabgendet_nombre']);
   
    

    $usuario_nickname = $filter->process($_SESSION['idusuario']);

    $tabgen = new tabgeneral();
  
    if ($tabgendet_nombre != "" ) {
	
        
        $status=$tabgen->insertardet($tabgen_id,$tabgendet_nombre,$usuario_nickname);
       
        
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('Ingresar valores validos', function(){}); 
                </script>";
    }



  $tabgenid = $tabgen->consultarActivosXid( $tabgen_id);
$lista = $tabgen->consultarActivosXtabGen($tabgen_id);


  
    require_once 'view/vistahtml/mostrarregistrotabgen-form.php';
}
function _cargarlistaAction() {//producción 2019

    $tabgen_id = $_GET["cod"];
    
    

    $lista = new tabgeneral();
    $listadet = $lista->consultarActivosXtabGen($tabgen_id);
    
     
    

    $html = " ";

          

       
     $html .= "<div class='widget-box transparent'>";
            $html .= "<div class='widget-header widget-header-flat'>";
                $html .= "<h4 class='widget-title lighter'>";
                    $html .= "<i class='ace-icon fa fa-star orange'></i>";
                        $html .= "Detalle";
                $html .= "</h4>";

                        $html .= "<div class='widget-toolbar'>";
                            $html .= "<a href='#' data-action='collapse'> <i class='ace-icon fa fa-chevron-up'></i> </a>";
                        $html .= "</div>";
            $html .= "</div>";

            $html .="<div class='widget-body'>";
                $html .= "<div class='widget-main no-padding'>";
                    $html .= "<table class='table table-bordered table-striped'>";
                        
                        $html .= "<thead class='thin-border-bottom'>";
                        
                            $html .= "<tr>";
                                $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Còdigo</th>";
                                
                                $html .="<th><i class='ace-icon fa fa-caret-right blue'></i>ID Tab.Gen. </th>";
                                
                                   $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Nombre</th>";
                                
                                 
                                 $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Fec. Creación</th>";
                            $html .= "</tr>";
                        $html .= "</thead>";

                        $html .= "<tbody>";

                    if ($listadet) {
                        foreach ($listadet as $lis){
                            
                       
                            $html .="<tr>";
                                $html .="<td>".$lis['tabgendet_id'];
                                       
                                $html .= "</td>";

                                $html .= "<td><b class='blue'>".$lis['tabgen_id'];
                                
                                $html .= "</b></td>";
                                
                               
                                
                                $html .="<td>".$lis['tabgendet_nombre'];
                                       
                                $html .= "</td>";

                         
                                
                                
                                  $date_fecped = date_create($lis['fecha_creacion']);

                                
                                $html .="<td>".$lis['fecha_creacion'];
                                       
                                $html .= "</td>";
                                
                                   $html .= "<input type='hidden' id = 'tabgen_id' value='". $lis ['tabgen_id']. "'>";
                            $html .= "</tr>";
                         }
                     } else {
                         $html .="<tr>";
                                $html .="<td colspan = '5'>";
                                       $html .= "no se encontraron registros!!";
                                $html .= "</td>";
                         $html .= "</tr>";
    }        

                        $html .="</tbody>";
                    $html .= "</table>";
                $html .="</div>";
            $html .= "</div>";
	$html .= "</div>";
        
        $html .= "<input type='hidden' id = 'idactual' value='". $tabgen_id. "'>";
      





   




    echo $html;
}


?>
