<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Panel Principal</title>

        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />
        <link rel="stylesheet" href="assets/css/chosen.min.css" />
        <!-- ace styles -->
        <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
        <![endif]-->
        <link rel="stylesheet" href="assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

        <script src="assets/js/ace-extra.min.js"></script>


        <style type="text/css">
            #img_logo{
                max-width: 330px;
                margin-left:  -70px;

            }
        </style>
    </head>

    <body class="no-skin">

        <?php
        include 'barrasesion.php';
        ?>

        <div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                try {
                    ace.settings.loadState('main-container')
                } catch (e) {
                }
            </script>

            <?php
            include 'nav-bar.php'
            ?>

            <div class="main-content">
                <div class="main-content-inner">
                    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                        <ul class="breadcrumb">
                            <li>
                                <i class="ace-icon fa fa-home home-icon"></i>
                                <a href="#">Home</a>
                            </li>

                            <li>
                                <a href="#">Extrusión</a>
                            </li>
                            <li class="active">Salida de Cintas</li>
                        </ul><!-- /.breadcrumb -->

                        <div class="nav-search" id="nav-search">
                            <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                            </form>
                        </div><!-- /.nav-search -->
                    </div>

                    <div class="page-content">

                        <div class="row-fluid">

                            <div class="widget-box">
                                <div class="widget-header widget-header-blue widget-header-flat">
                                    <h4 class="widget-title lighter">Registro de <?PHP echo $tipomov; ?>    de cintas</h4>


                                </div>

                                <form  class="form-horizontal" id="formlote" name="formlote" role="form"  >



                                    <div class="row">



                                        <div class="col-sm-12">


                                            <div class="widget-body">
                                                <div class="widget-main">


                                                    <div class="form-group">  
                                                         
                                                     <?php if($tipomov == 'reingreso'):?>
                                                        
                                                         <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Cinta </label>
                                                          <div class="col-sm-3">
                                                         <select name="codbarra" id="codbarra" class="chosen-select form-control"  required="required"   >
                                                                <option value="-1">    Seleccione una opción  </option>
                                                        <?php if($listasemiterminado):?>
                                                         <?php foreach($listasemiterminado as $list):?> 
                                                        
                                                        <option value="<?php echo $list ['artsemi_id']; ?>">
                                                               <?php echo $list ['artsemi_id']." ". $list ['artsemi_descripcion']; ?> 

                                                                        </option>
                                                        
                                                        
                                                        
                                                        
                                                         <?php  endforeach;?>
                                                         <?php endif;?> 
                                                                          </select>
                                                               <input type="hidden" name="movim" id="movim" value="<?php echo $tipomov; ?>">
                                                           </div>
                                                         <?php elseif($tipomov == 'salida'):?>      
                                                              <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1"> COD. BARRAS </label>

                                                        <div class="col-sm-3">
                                                            <input type="text"  id="codbarra" required="required" autofocus  class="form-control"  name="codbarra" />
                                                            <input type="hidden" name="movim" id="movim" value="<?php echo $tipomov; ?>">

                                                        </div>
                                                         <?php endif;?>
                                                 
                                                          
                                                            <div class="col-sm-3">
                                                            <button class="btn btn-sm btn-primary" id="btn_buscar_lote" type="submit">
                                                                <i class="ace-icon fa fa-check"></i>
                                                                Buscar
                                                            </button>

                                                        </div>
                                                    </div>
                                                    
                                                    

                                                </div>
                                            </div>

                                        </div>



                                    </div>

                                    <div class="row" id="mostrarreg" style="display:none;">

                                        <div class="col-xs-12">
                                            <table id="simple-table" class="table  table-bordered table-hover">
                                                <thead>

                                                    <tr>


                                                        <th colspan="4"><center>Cantidad Disponible   </center></th>
                                            <th colspan="3"><center>Cantidad de Movimiento  </center></th>
                                            <?php if ($tipomov == 'reingreso'):?>
                                                <th colspan="4"><center>Procesos</center></th>
                                             <?php else:?>
                                              <th colspan="4"><center>Procesos</center></th>
                                            <?php endif;?>
                                                </tr>
                                                <tr>


                                                    <th>Num. Caj. </th>
                                                    <th>Num. Bob. </th>
                                                    <th>Kilos Destarados</th>
                                                     <th>Kilos sin destarar</th>
                                                    
                                                    
                                                    
                                                    <th>Num. Caj.</th>
                                                    <th>Num. Bob.</th>
                                                    <th>Kilos (Balanza)</th>
                                                    <th>Capturar</th>
                                                     <th>Num. de carro</th>
                                                      <th>Kanban</th>
                                                    <th>Registrar</th>
                                                    <?php if ($tipomov == 'reingreso'):?>
                                                    <th>Imprimir</th>
                                             
                                                      <?php endif;?>



                                                </tr>
                                                </thead>
                                                
                                                <tbody  id="ajax_mostrar_pend_produc">


                                                </tbody>
                                            </table>
                                        </div><!-- /.span -->


                                    </div>





                                    <div class="space-6"></div>

                                    <div class="modal-footer">
                                           <?php if ($tipomov == 'reingreso'):?>
                                                        <a class="btn btn-sm btn-primary" href="index.php?page=produccion&accion=formreingreso">
    <i class="ace-icon fa fa-check"></i>
    Regresar
</a>
                                             <?php else:?>
                                                                                 <a class="btn btn-sm btn-primary" href="index.php?page=produccion&accion=formsalida">
    <i class="ace-icon fa fa-check"></i>
    Regresar
</a>
                                            <?php endif;?>
                                
                                    </div>


                                </form>







                            </div>

                        </div><!-- /.page-content -->




                    </div>  
                    <br>   <br>  <br>  <br>  <br>  <br>   <br>  <br>  <br>  <br>
                </div><!-- /.main-content -->




                <?php
                include 'footer.php'
                ?>

                <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
                </a>
            </div>
            
            </div>
              <script src="assets/js/jquery-2.1.4.min.js"></script>

                  <script type="text/javascript">
           if ('ontouchstart' in document.documentElement)
      document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
            </script>
            <script src="assets/js/bootstrap.min.js"></script>
            <script src="assets/js/chosen.jquery.min.js"></script>
        
            <script src="assets/js/ace-elements.min.js"></script>
            <script src="assets/js/ace.min.js"></script>
            <script src="view/js/produccion.js"></script>

            <script src="view/js/adicionales.js"></script>


            <script src="assets/js/bootbox.js"></script>

            
         
    </body>
</html>

