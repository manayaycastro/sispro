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
                                <a href="#">Producción</a>
                            </li>
                            <li class="active">Lista de Máquinas Paradas</li>
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
                                    <h4 class="widget-title lighter">Lista de Máquinas Paradas</h4>


                                </div>
                                <form  class="form-horizontal"  id="listar-paradas">



                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div id="fuelux-wizard-container">
                                                <div>
                                                    <div class="row">

                                                        <div class="col-xs-12 col-sm-3">

                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Desde  </label>

                                                                <div class="col-sm-9">
                                                                    <input type="date" id="desde" required="required" placeholder="Nombre del Área" class="form-control" 
                                                                           name="desde"

                                                                           />
                                                                </div>
                                                            </div>





                                                        </div>


                                                        <div class="col-xs-12 col-sm-3">

                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Hasta </label>

                                                                <div class="col-sm-9">
                                                                    <input type="date" id="hasta" required="required" placeholder="Nombre del Área" class="form-control" 
                                                                           name="hasta"

                                                                           />
                                                                </div>
                                                            </div>




                                                        </div>

                                                        <div class="col-xs-12 col-sm-4">

                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Área </label>

                                                                <div class="col-sm-9">

                                                                    <select name="area" class="chosen-select form-control" id="area" data-placeholder="Choose a State...">

                                                                        <?php if (count($areas)): ?>
                                                                            <option value="">  </option>                                              
                                                                            <?php foreach ($areas as $area): ?>
                                                                                <option value="<?php echo $area ['are_id'] ?>" >
                                                                                    <?php echo $area ['are_titulo']; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>


                                            <div class="wizard-actions">
                                                <a class="btn btn-danger">
                                                    <i class="ace-icon fa fa-plus"></i>
                                                    Nuevo

                                                </a>

                                                <button id="listar-paradas" type="submit" class="btn btn-success btn-next" data-last="Finish" >
                                                    Listar
                                                    <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                                </button>
                                            </div>
                                        </div><!-- /.widget-main -->
                                    </div><!-- /.widget-body -->

                                </form>   


                            </div>

                        </div><!-- /.page-content -->

                           <div class="row-fluid" id="estructura_tabla_paradas"  style="display:none">

  
  <div class="row">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-12" >
                                            <div class="col-xs-12"> 
                                                <div class="col-xs-9">
                                                    <h4 class="header smaller lighter blue">Cantidad de registros <span class="badge"><?php echo '50'; ?></span></h4>
                                                </div>

                                            </div>
                                            <br>
                                            <div class="clearfix">
                                                <div class="pull-right tableTools-container"></div>
                                            </div>
                                            <div class="table-header">
                                                Results for "Latest Registered Domains"
                                            </div>
                                            <div  >
                                                
    <table id="dynamic-table" class="table table-striped table-bordered table-hover"  >
          <div class="span12">
                            <div class="dataTables_filter dataTables_length pull-left">
                                                <label>Periodo:
                                                    <select id="anio" style="font-size: small; padding-top:0px" >
                                                         <option value="2015"<?php if ("2015"== date("Y")): ?> selected
                                                             
                                                         <?php endif ?>>2015</option>
                                                         <option  value="2014"<?php if ("2014"== date("Y")): ?> selected
                                                             
                                                         <?php endif ?>>2014</option>
                                                         <option value="2013"<?php if ("2013"== date("Y")): ?> selected
                                                             
                                                         <?php endif ?>>2013</option>                                    
                                                         <option value="2012"<?php if ("2012"== date("Y")): ?> selected
                                                             
                                                         <?php endif ?>>2012</option>
                                                         <option value="2011"<?php if ("2011"== date("Y")): ?> selected
                                                             
                                                         <?php endif ?>>2011</option>
                                                         <option value="2010"<?php if ("2010"== date("Y")): ?> selected
                                                             
                                                         <?php endif ?>>2010</option>
                                                     </select>
                                                      <select id="mes" style="font-size: small; padding-top:0px" >
                                                        
                                                         <option value="01" <?php if ("01"== date("m")): ?> selected
                                                             
                                                         <?php endif ?> >Enero</option>
                                                         <option  value="02"<?php if ("02"== date("m")): ?> selected
                                                             
                                                         <?php endif ?>>Febrero </option>
                                                         <option value="03"<?php if ("03"== date("m")): ?> selected
                                                             
                                                         <?php endif ?> >Marzo</option>                                    
                                                         <option value="04"<?php if ("04"== date("m")): ?> selected
                                                             
                                                         <?php endif ?>>Abril</option>
                                                         <option value="05"<?php if ("05"== date("m")): ?> selected
                                                             
                                                         <?php endif ?>>Mayo</option>
                                                         <option value="06"<?php if ("06"== date("m")): ?> selected
                                                             
                                                         <?php endif ?>>Junio</option>
                                                         <option value="07"<?php if ("07"== date("m")): ?> selected
                                                             
                                                         <?php endif ?>>Julio</option>
                                                         <option value="08"<?php if ("08"== date("m")): ?> selected
                                                             
                                                         <?php endif ?>>Agosto</option>
                                                         <option value="09"<?php if ("09"== date("m")): ?> selected
                                                             
                                                         <?php endif ?>>Setiembre</option>
                                                         <option value="10"<?php if ("10"== date("m")): ?> selected
                                                             
                                                         <?php endif ?>>Octubre</option>
                                                         <option value="11"<?php if ("11"== date("m")): ?> selected
                                                             
                                                         <?php endif ?>>Noviembre</option>
                                                         <option value="12"<?php if ("12"== date("m")): ?> selected
                                                             
                                                         <?php endif ?>>Diciembre</option>
                                                     </select>
                                                   
                                                      
                                                </label>
                                                
                                                                                           <form>
        Cadena a buscar <input id="searchTerm" type="text" onkeyup="doSearch()" />
    </form>
                                            </div><!-- datatables filter -->
                                           <!--  <input  class="btn btn-mini btn-success" style="" id="buscar" type="button" value="BUSCAR" onclick="return  Buscar()">     -->
                                        </div>
             
                                                    <thead>
                                                        <tr>
                                                            <th class="center">
                                                                <label class="pos-rel">
                                                                    <input type="checkbox" class="ace" />
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </th>
                                                            <th>Id</th>
                                                            <th>Titulo</th>
                                                            <th class="hidden-480">Estado</th>
                                                            <th>
                                                                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                                                Fecha Registro
                                                            </th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody  id="ajax_paradas"  >
                                                        
                                                     
                                                    </tbody>
                                                </table>
       
         
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.col -->

                            </div>
   
                              
                        </div>

                     
                    </div>  
                    <br>   <br>  <br>  <br>  <br>  <br>   <br>  <br>  <br>  <br>
                </div><!-- /.main-content -->


<!-- <div id="ajax_paradas">    
                            </div> -->

                <?php
                include 'footer.php'
                ?>

                <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
                </a>
            </div><!-- /.main-container -->

            <!-- basic scripts -->

            <!--[if !IE]> -->
            <script src="assets/js/jquery-2.1.4.min.js"></script>

            <!-- <![endif]-->

            <!--[if IE]>
    <script src="assets/js/jquery-1.11.3.min.js"></script>
    <![endif]-->
            <script type="text/javascript">
                if ('ontouchstart' in document.documentElement)
                    document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
            </script>
            <script src="assets/js/bootstrap.min.js"></script>
            <script src="assets/js/chosen.jquery.min.js"></script>
            <!-- page specific plugin scripts -->

            <!-- ace scripts -->
            <script src="assets/js/ace-elements.min.js"></script>
            <script src="assets/js/ace.min.js"></script>
            <script src="view/js/produccion.js"></script>
            <script src="view/js/adicionales.js"></script>

            <script src="assets/js/jquery.dataTables.min.js"></script>
            <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
            <script src="assets/js/dataTables.buttons.min.js"></script>
            <script src="assets/js/buttons.flash.min.js"></script>
            <script src="assets/js/buttons.html5.min.js"></script>
            <script src="assets/js/buttons.print.min.js"></script>
            <script src="assets/js/buttons.colVis.min.js"></script>
            <script src="assets/js/dataTables.select.min.js"></script>
            <script src="assets/js/bootbox.js"></script>

            <script type="text/javascript">
             
//                    document.write("<script src='view/js/adicionales.js'>" + "<" + "/script>");
            </script>
              

    </body>
</html>

