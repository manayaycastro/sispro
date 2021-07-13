<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/perfiles.php';
require_once 'model/usuarios.php';
require_once 'model/diseno.php';
require_once 'controller/class.inputfilter.php';
require_once 'controller/class.upload.php';
include 'controller/validar-sesion.php';



function _listarAction() {//producción 2019
    
    $diseno = new diseno();
    $disenos =$diseno->consultar();
   
   
  
    require_once 'view/diseno-registro.php';
}

function _ajaxverformAction() {//producción 2019
    
     $disenodatos = new diseno();
     // $permiso = $_POST['versionactual'];
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $permiso = 'disabled';
     $permiso2 = 'readonly';
    } else {
        $id = 0;
   $permiso = $_POST['permiso'];
     $permiso2 = $_POST['permiso'];
    }
   
    $disenodatos->obtenerxId($id);
    
    $clientes = $disenodatos->consultarCLI();
    $articulos = $disenodatos->consultarARTdiseno();
    
   

    require_once 'view/diseno-form.php';
}

function _ajaxregistrardisenoAction() {//producción 2019
    
   
  
        $id = $_POST["articulos"];
        $cliente= $_POST['cliente'];
        $nomdiseno = $_POST['nomdiseno'];
        $comentario= $_POST['comentario'];
        $version= $_POST['spinner'];
        
   //$archivo= $_FILES['archivo'];
   $url = '';
    
    $handle = new Upload($_FILES['archivo']);
  if ($handle->uploaded) {
    $handle->Process("view/uploads/");
//      $handle->Process("D:/disenos2020elaguila/");
    if ($handle->processed) {
    	// usamos la funcion insert_img de la libreria db.php
    	$url = "view/uploads/".$handle->file_dst_name;
//        	$url = "D:/disenos2020elaguila/".$handle->file_dst_name;
    } else {
      echo 'Error: ' . $handle->error;
    }
  } else {
    echo 'Error: ' . $handle->error;
  }
   
   
   
   
    //$nombrearch = $_FILES['archivo']['name'];
    
 
        $comentariodet= $_POST['comentariodet'];
    
        $permiso = $_POST['permiso'];
        
        
     $diseno = new diseno();
    $diseno->obtenerxId($id);
    
    if($diseno->getProdi_codart() != null){
        $diseno2 = new diseno();
      $diseno2->obtenerxId($id);
        $prodi_id = $diseno2->getProdi_id();
        $diseno2->insertarDisenoDet($prodi_id, $version, $url,$comentariodet);
        
    }else{
         $diseno3 = new diseno();
          $diseno3->insertarDISENO($id, $nomdiseno, $comentario, $cliente);
          $ids = $diseno3->consultarTop1();
          if($ids){
              foreach ($ids as $lista){
                  $prodi_id = $lista['prodi_id'];
                  $diseno3->insertarDisenoDet($prodi_id, $version, $url,$comentariodet);
              }
          }
    }
    
      $disenodatos = new diseno();
    $disenodatos->obtenerxId($id);
    $clientes = $diseno->consultarCLI();
    $articulos = $diseno->consultarART();
    $permiso2 = 'readonly';
    $permiso = 'disabled';
  
    

    require_once 'view/diseno-form.php';
}



function _ajaxregistrardisenoV01Action() {//producción 2019
    
   
  
        $id = $_POST["articulo"];
        $cliente= $_POST['cliente'];
        $nomdiseno = $_POST['nomdiseno'];
        $comentario= $_POST['comentario'];
        $version= $_POST['version'];
        
   //$archivo= $_FILES['archivo'];
   $url = '';
    
   
   
   
   
   
    //$nombrearch = $_FILES['archivo']['name'];
    
 
        $comentariodet= $_POST['comentariodet'];
    
        $permiso = $_POST['permiso'];
        
        
     $diseno = new diseno();
    $diseno->obtenerxId($id);
    
    if($diseno->getProdi_codart() != null){
        $diseno2 = new diseno();
      $diseno2->obtenerxId($id);
        $prodi_id = $diseno2->getProdi_id();
        $diseno2->insertarDisenoDet($prodi_id, $version, $url,$comentariodet);
        
    }else{
         $diseno3 = new diseno();
          $diseno3->insertarDISENO($id, $nomdiseno, $comentario, $cliente);
          $ids = $diseno3->consultarTop1();
          if($ids){
              foreach ($ids as $lista){
                  $prodi_id = $lista['prodi_id'];
                  $diseno3->insertarDisenoDet($prodi_id, $version, 'rutaimagen',$comentariodet);
              }
          }
    }
    
      $disenodatos = new diseno();
    $disenodatos->obtenerxId($id);
    $clientes = $diseno->consultarCLI();
    $articulos = $diseno->consultarART();
    $permiso2 = 'readonly';
    $permiso = 'disabled';
  
    

    require_once 'view/diseno-form.php';
}

function _cargarlistaAction() {//producción 2019

    $id = $_GET["cod"];
    $permiso = $_GET["permiso"];
    

    $lista = new diseno();
    $disenos = $lista->consultarDetalleDise($id);
    
      $disenodatos2 = new diseno();
        $disenodatos2->obtenerxId($id);
    

    $html = " ";

          

       
     $html .= "<div class='widget-box transparent'>";
            $html .= "<div class='widget-header widget-header-flat'>";
                $html .= "<h4 class='widget-title lighter'>";
                    $html .= "<i class='ace-icon fa fa-star orange'></i>";
                        $html .= "Lista de diseños";
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
                                
                                $html .="<th><i class='ace-icon fa fa-caret-right blue'></i>Versiòn</th>";
                                
                                   $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Fecha</th>";
                                
                                 $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Ver</th>";

                                $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Estado</th>";
                            $html .= "</tr>";
                        $html .= "</thead>";

                        $html .= "<tbody>";

                    if ($disenos) {
                        foreach ($disenos as $lista){
                            
                       
                            $html .="<tr>";
                                $html .="<td>".$lista['prodi_codart'];
                                       
                                $html .= "</td>";

                                $html .= "<td><b class='blue'>".$lista['prodidet_version'];
                                
                                $html .= "</b></td>";
                                
                                 $date_fecped = date_create($lista['fecha_creacion']);

                                
                                $html .="<td>".date_format($date_fecped,'d/m/Y');
                                       
                                $html .= "</td>";
                                
                                $html .="<td>";
                                       $html .="  
                                           
                                            <p>
                                                <a class='blue' id='hide-option' target='_blank' href='".$lista['prodidet_url']."' title='explode on hide'>
                                                        <i class='ace-icon fa fa-hand-o-right'></i>
                                                        Click para ver version..!
                                                </a>
                                        </p>
                                               ";
                                $html .= "</td>";

                                $html .= "<td class='hidden-480'>";
                                
                                  $html .="  <label>
                                    <img width='18px' height='18px' style='margin-top: -7px; display: none;'
                                         src='view/img/loading.gif' class='loading-". $lista ['prodidet_id'];
                                        $html .="' >";
                                        $html .=" <input type='checkbox'";
                                         if ($lista ['prodidet_vigente'] == '1'){
                                           $html .="  checked='checked'";  
                                         }else{
                                             
                                         }
                                         
                                          $html .=" class='ace ace-switch ace-switch-6' id='updateversion' data-iddetallle=". $lista ['prodidet_id'];
                                           $html .= "><span class='lbl'></span>
                                   
                                </label>";
            
                                if($lista['prodidet_vigente']== '1'){
                                     $html .= "<span class='label label-success arrowed-in arrowed-in-right'>Vigente";
                                    $html .= "</span>";
                                }else{
                                     $html .= "<span class='label label-danger arrowed'>No Vigente";
                                    $html .= "</span>";
                                }
                                   
                                    
                                $html .= "</td>";
                                   $html .= "<input type='hidden' id = 'iddiseno' value='". $lista ['prodi_id']. "'>";
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
        
        $html .= "<input type='hidden' id = 'codartactual' value='". $id. "'>";
      





   




    echo $html;
}



function _versionvigAction() { //producción 2019
    $response = array();

    $usuario_id = $_SESSION['idusuario'];
    $usuario_nickname = $_SESSION['usuario'];

     $iddetallle = $_POST['iddetallle'];
    $codartactual= $_POST['codartactual'];
    
        $iddiseno= $_POST['iddiseno'];
    $accion = $_POST['accion'];
    //$fecha = getdate();
    
 
       // $disenodatos->obtenerxId($codartactual);
        
    if ($accion == "agregar") {
        $estado = 1;

             
         $disenodatoslista = new diseno();
        $status = $disenodatoslista->updateversionTODOS('0',$iddiseno);
         $status = $disenodatoslista->updateversion($iddetallle,$estado);
    } else {
         echo "<script type='text/javascript'> 
             
               bootbox.alert('debe establecer al menos una versión de diseño para este artículo, hacer clic en otra version si se desea cambiar', function(){}); 
                </script>";
         
       // $status=  "  <script> bootbox.alert('Para poder agregar una observaciòn, debe escribir un mensaje valido', function(){}); </script>";
    }


     $permiso = 'disabled';
   $permiso2 = 'readonly';

 $disenodatos = new diseno();
        $disenodatos->obtenerxId($codartactual);
         $clientes = $disenodatos->consultarCLI();
    $articulos = $disenodatos->consultarART();
   $id=  $codartactual;
    
    require_once 'view/diseno-form.php';
}




















function _ajaxGetcargarDatosAction() {
     $response = array();
       $articulo = $_POST['articulo'];
       
         $disenodatos2 = new diseno();
        $status =  $disenodatos2->obtenerxId($articulo);
         $response["status"] = $status;

    header('Content-Type: application/json');



    echo json_encode($response);
}
