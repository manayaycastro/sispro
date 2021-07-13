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

        <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
        <![endif]-->
        <link rel="stylesheet" href="assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

        <script src="assets/js/ace-extra.min.js"></script>

        <link rel="stylesheet" href="view/css/personalizado.css" />

        <!--////////////////////////////////////////-->


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
                            <li class="active">Produccón Prensa</li>
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
                                    <h4 class="widget-title lighter">Lista Ordenes de Pedido</h4>


                                </div>
                                <form name="produccion_enfardado" id="produccion_enfardado" role="form"  class="form-horizontal" >

                                    <div class="modal-body">
                                        <div class="widget-body">
                                            <div class="widget-main">

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12">

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label no-padding-right" for="form-field-1-1"> Orden de Pedido </label>

                                                            <div class="col-sm-8">

                                                                <select name="opedido"   id="opedido" class="chosen-select form-control">

                                                                    <option value=-1>Selecione una OP</option>
                                                                    <?php if (count($ops)): ?>
                                                                        <?php foreach ($ops as $lista): ?>
                                                                            <option value="<?php echo $lista ['prokan_nroped'] ?>" >
                                                                                <?php echo $lista ['prokan_nroped']; ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>

                                                            <div class="col-sm-2">
                                                                <button class="btn btn-sm btn-primary" type="submit"  >
                                                                    <i class="ace-icon fa fa-check"></i>
                                                                    Buscar
                                                                </button>
                                                            </div>
                                                        </div>





                                                    </div>

                                                </div>




                                            </div>
                                        </div>


                                    </div>





                                </form>

                                <div class="modal-body">
                                    <!--                                    <h3 class="header smaller lighter green"></h3>  -->
                                    <div class="widget-box">

                                        <div class="widget-header widget-header-small">
                                            <h5 class="widget-title lighter">Ingreso de Producción</h5>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12">

                                                        <!--inicio de tabla datos Generales--> 

                                                        <form name="datos-generales" id="datos-generales" >

                                                            <div class="col-md-12">

                                                                <!--estructura_tabla_articulo-->
                                                                <div id="estructura_tabla_datosgenerales" style="display:none;">
                                                                    <div class="widget-box transparent">
                                                                        <div class="widget-header widget-header-flat">
                                                                            <h4 class="widget-title lighter">
                                                                                <i class="ace-icon fa fa-star orange"></i>
                                                                                Datos generales de la OP.
                                                                            </h4>

                                                                            <div class="widget-toolbar">
                                                                                <a href="#" data-action="collapse">
                                                                                    <i class="ace-icon fa fa-chevron-up"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>

                                                                        <div class="widget-body">
                                                                            <div class="widget-main no-padding">
                                                                                <table class="table table-bordered table-striped">
                                                                                    <thead class="thin-border-bottom">
                                                                                        <tr>
                                                                                            <th>
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>OP
                                                                                            </th>

                                                                                            <th>
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>cod art.
                                                                                            </th>

                                                                                            <th class="hidden-480">
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>Descripcion de articulo
                                                                                            </th>
                                                                                            <th class="hidden-480">
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>Cant. Pedida
                                                                                            </th>
                                                                                            <th class="hidden-480">
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>Cliente
                                                                                            </th>
                                                                                            <th class="hidden-480">
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>Diseño
                                                                                            </th>
                                                                                            </th>
                                                                                            <th class="hidden-480">
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>ClaseB

                                                                                            </th>


                                                                                        </tr>
                                                                                    </thead>

                                                                                    <tbody id="ajax_produccion_articulo"></tbody>

                                                                                </table>
                                                                            </div><!-- /.widget-main -->
                                                                        </div><!-- /.widget-body -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>



                                                    </div>

                                                    <!--fin de tabla datos Generales--> 

                                                    <!--inicio de tabla datos Registrar produccion--> 



                                                    <div class="col-md-12">
                                                        <!--estructura_tabla_enfardado-->
                                                        <div id="estructura_tabla_produccion" style="display:none;">

                                                            <div class="col-md-12">
                                                                <br><br>
                                                                <div class="col-md-3">
                                                                    <div class="widget-box transparent">
                                                                        <div class="widget-header widget-header-flat">
                                                                            <h4 class="widget-title lighter">
                                                                                <i class="ace-icon fa fa-star orange"></i>
                                                                                Detalle de OP
                                                                            </h4>

                                                                            <div class="widget-toolbar">
                                                                                <a href="#" data-action="collapse">
                                                                                    <i class="ace-icon fa fa-chevron-up"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>

                                                                        <div class="widget-body">
                                                                            <div class="widget-main no-padding">
                                                                                <table class="table table-bordered table-striped">
                                                                                    <thead class="thin-border-bottom">
                                                                                        <tr>
                                                                                            <th>
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>Tipo Producto
                                                                                            </th>

                                                                                            <th>
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>Producción
                                                                                            </th>

                                                                                            <th class="hidden-480">
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>Pendiente
                                                                                            </th>



                                                                                        </tr>
                                                                                    </thead>

                                                                                    <tbody id="ajax_produccion_totales"></tbody>
                                                                                </table>
                                                                            </div><!-- /.widget-main -->
                                                                        </div><!-- /.widget-body -->
                                                                    </div>
                                                                    <br><br>
                                                                    <div class="widget-box transparent">
                                                                        <div class="widget-header widget-header-flat">
                                                                            <h4 class="widget-title lighter">
                                                                                <i class="ace-icon fa fa-star orange"></i>
                                                                                Saldos pendientes
                                                                            </h4>

                                                                            <div class="widget-toolbar">
                                                                                <a href="#" data-action="collapse">
                                                                                    <i class="ace-icon fa fa-chevron-up"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>

                                                                        <div class="widget-body">
                                                                            <div class="widget-main no-padding">
                                                                                <table class="table table-bordered table-striped">
                                                                                    <thead class="thin-border-bottom">
                                                                                        <tr>
                                                                                            <th>
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>Tipo Producto
                                                                                            </th>

                                                                                            <th>
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>Producción
                                                                                            </th>

                                                                                            <th class="hidden-480">
                                                                                                <i class="ace-icon fa fa-caret-right blue"></i>Pendiente
                                                                                            </th>



                                                                                        </tr>
                                                                                    </thead>

                                                                                    <tbody id="ajax_produccion_pucho"></tbody>
                                                                                </table>
                                                                            </div><!-- /.widget-main -->
                                                                        </div><!-- /.widget-body -->
                                                                    </div>
                                                                </div>



                                                                <div class="col-md-9">
                                                                    <!--<form name="reg-produccion" id="reg-produccion" >-->
                                                                    <div id="ajax_produccion_enfardado">


                                                                    </div>
                                                                    <!--</form>-->

                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>



                                                    <!--fin de tabla Registrar produccion--> 





                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>






                            </div>

                        </div>

                    </div><!-- /.page-content -->




                </div>  
                <br>   <br>  <br>  <br>  <br>  <br>   <br>  <br>  <br>  <br>
            </div><!-- /.main-content -->


            <!-- /.Inicio del modal agrupacion de fardos -->
            <div id="modal-agruparfardos" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">

                <div class="modal-dialog" id="mdialTamanio">
                    <!--class="modal-dialog modal-lg"-->
                    <form name="regproduccion" id="regproduccion" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->

                            </div>

                            <div class="row">


                                <div class="col-xs-12">
                                    <!-- PAGE CONTENT BEGINS -->

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="widget-box widget-color-blue2">
                                                <div class="widget-header">
                                                    <h4 class="widget-title lighter smaller">Agrupación de fardos para la orden <span id="datosActualTXTop"></span></h4>
                                                </div>



                                                <div class="widget-body">
                                                    <div  class="centro" id="centro">
                                                        <div class="widget-main padding-8">
                                                            <!--<ul id="tree1"></ul>  con javascrip--> 



                                                            <div id="mostrarfardos" >

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>


                                    </div>

                                    <!-- PAGE CONTENT ENDS -->
                                </div><!-- /.col -->


                            </div><!-- /.row -->

                            <div class="space-18"></div>

                            <div class="modal-footer">


                                <button type="button" class="btn btn-sm" data-dismiss="modal">
                                    <i class="ace-icon fa fa-times"></i>
                                    Salir
                                </button>

                                <button type="button" class="btn btn-sm btn-primary" id="guardarpuchosagrupados" >
                                    <i class="ace-icon fa fa-check"></i>
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
            <!-- Fin del modal agrupacion de fardos -->

            <!-- /.Inicio del modal DISENO -->
            <div id="modal-diseno" class="modal" tabindex="-1">
                <div class="modal-dialog" id="mdialTamanio">
                    <!--class="modal-dialog modal-lg"-->
                    <div class="modal-content">
                        <!--                        <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  
                                                </div>-->

                        <div class="row">


                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="widget-box widget-color-blue2">
                                            <div class="widget-header">
                                                <h4 class="widget-title lighter smaller">Diseño vigente para el artículo de códico: <span id="datosdisenoTXT"></span></h4>
                                            </div>

                                            <div class="widget-body">
                                                <div  class="centro" id="centro">


                                                    <div id = "ver_diseno">


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->


                        </div><!-- /.row -->


                    </div>
                </div>
            </div>
            <!-- Fin del modal DISENO -->


            <!-- /.Inicio del modal claseb -->
            <div id="modal-claseb" class="modal" tabindex="-1">
                <div class="modal-dialog" id="mdialTamanio">
                    <!--class="modal-dialog modal-lg"-->
                    <div class="modal-content">
                        <!--                        <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  
                                                </div>-->

                        <div class="row">


                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="widget-box widget-color-blue2">
                                            <div class="widget-header">
                                                <h4 class="widget-title lighter smaller">Clase B relacionado para el articulo: <span id="datosdisenoTXT"></span></h4>
                                            </div>

                                            <div class="widget-body">
                                                <div  class="centro" id="centro">


                                                    <div id = "ver_claseb">


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->


                        </div><!-- /.row -->


                    </div>
                </div>
            </div>
            <!-- Fin del modal claseb -->


            <!-- /.Inicio del modal Etiqueta -->
            <div id="modal-etiqueta" class="modal" tabindex="-1">
                <div class="modal-dialog" id="mdialTamanio">
                    <!--class="modal-dialog modal-lg"-->
                    <div class="modal-content">
                        <!--                        <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  
                                                </div>-->

                        <div class="row">


                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="widget-box widget-color-blue2">
                                            <div class="widget-header">
                                                <h4 class="widget-title lighter smaller">Etiqueta del codigo: <span id="datosetiquetaTXT"></span></h4>
                                            </div>

                                            <div class="widget-body">
                                                <div  class="centro" id="centro">


                                                    <div id = "ver_etiqueta">


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->


                        </div><!-- /.row -->


                    </div>
                </div>
            </div>
            <!-- Fin del modal Etiqueta -->
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
        <!--<script src="view/js/produccion.js"></script>-->
        <script src="view/js/kanban.js"></script>
        <script src="view/js/adicionales.js"></script>
       <!--<script src="view/js/selectarticulo.js"></script>-->

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



        <script src="assets/js/jquery-ui.min.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.min.js"></script>




        <script src="assets/js/bootbox.js"></script>



    </body>
</html>

