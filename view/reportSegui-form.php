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
        <!--<link rel="stylesheet" href="assets/css/personalizado.css" />-->
        <link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
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
                                <a href="#">Planificaci??n</a>
                            </li>
                            <li class="active">Programa de Procesos</li>
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
                                    <h4 class="widget-title lighter">Resumen de producci??n</h4>


                                </div>
                                <form  class="form-horizontal" method="post" action="index.php?page=planificacion&accion=programaprocReportSeg" target="_blank">



                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div id="fuelux-wizard-container">
                                                <div>
                                                    <div class="row">
                                                        
                                                          <div class="col-xs-12">

                                                            <label for="id-date-range-picker-1">Proceso</label>

                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                  
                                                                      <select name="tipo" id="tipo" class="chosen-select form-control"     >
                                        
                                                                                <option value="seguimiento" >
                                                                                          Seguimiento
                                                                                </option>
                                                                                <option value="Cambio" >
                                                                                          Cambio Tejido
                                                                                </option>

                                                                          
                                                                    </select>
                                                                
                                                                    </div>
                                                            </div>





                                                        </div>
                                                        

                                                
                                                           <div class="col-xs-12">

                                                            <label for="id-date-range-picker-1">Proceso</label>

                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                  
                                                                      <select name="procesos" id="procesos" class="chosen-select form-control"     >
                                                                   
                                                                        <?php if (count($listaprocesos)): ?>
                                                                            <?php foreach ($listaprocesos as $list): ?>

                                                                                <option value="<?php echo $list ['tabgendet_id'] ?>" 
                                                                                          <?php if($list ['tabgendet_id']<=167 ): ?>
                                                                                       enabled ='enabled'
                                                                                       
                                                                                        <?php else: ?>
                                                                                          disabled="disabled"
                                                                                          <?php endif; ?>
                                                                                        
                                                                                        
                                                                                        >
                                                                                            <?php echo $list['tabgendet_nombre']; ?> 

                                                                                </option>

                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    </select>
                                                                
                                                                    </div>
                                                            </div>





                                                        </div>
                                                        

                                                   
                                                    </div>
                                                        
                                                  </div>   
                                                <br>
                                                     <div>  
                                                    <div class="row">

                                                        <div class="col-xs-12">

                                                          

                                                            <div class="row">
                                                                <div class="col-sm-12" id="default-buttons">
                                                                  
                                                                        <p>
											<button class="btn btn-success btn-block">Mostrar</button>
										</p>

                                                                   
                                                                </div>

                                                            </div>


                                                        </div>


                                                   
                                                    </div>

                                                    
                                                    </div>  
                                               



                                            </div><!-- /.widget-main -->


                                        </div><!-- /.widget-body -->

                              


                            </div>
  </form>   
                        </div><!-- /.page-content -->




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


            <script src="assets/js/bootstrap.min.js"></script>
            <script src="assets/js/chosen.jquery.min.js"></script>
            <!-- page specific plugin scripts -->

            <!-- ace scripts -->
            <script src="assets/js/ace-elements.min.js"></script>
            <script src="assets/js/ace.min.js"></script>


            <script src="assets/js/jquery.dataTables.min.js"></script>
            <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
            <script src="assets/js/dataTables.buttons.min.js"></script>
            <script src="assets/js/buttons.flash.min.js"></script>
            <script src="assets/js/buttons.html5.min.js"></script>
            <script src="assets/js/buttons.print.min.js"></script>
            <script src="assets/js/buttons.colVis.min.js"></script>
            <script src="assets/js/dataTables.select.min.js"></script>
            <script src="assets/js/bootbox.js"></script>

            <script src="assets/js/bootstrap-datepicker.min.js"></script>
            <script src="assets/js/bootstrap-timepicker.min.js"></script>
            <script src="assets/js/moment.min.js"></script>
            <script src="assets/js/daterangepicker.min.js"></script>
            <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
            <script src="assets/js/bootstrap-colorpicker.min.js"></script>


<script src="view/js/adicionales.js"></script>



            <script type="text/javascript">

                jQuery(function ($) {
                    $('#rango').daterangepicker({
                        "locale": {
                            "format": "DD-MM-YYYY",
                            "separator": " - ",
                            "applyLabel": "Guardar",
                            "cancelLabel": "Cancelar",
                            "fromLabel": "Desde",
                            "toLabel": "Hasta",
                            "customRangeLabel": "Personalizar",
                            "daysOfWeek": [
                                "Do",
                                "Lu",
                                "Ma",
                                "Mi",
                                "Ju",
                                "Vi",
                                "Sa"
                            ],
                            "monthNames": [
                                "Enero",
                                "Febrero",
                                "Marzo",
                                "Abril",
                                "Mayo",
                                "Junio",
                                "Julio",
                                "Agosto",
                                "Setiembre",
                                "Octubre",
                                "Noviembre",
                                "Diciembre"
                            ],
                            "firstDay": 1
                        },
                        "opens": "center",
                        'autoApply': true
                    });


                });
            </script>

    </body>
</html>

