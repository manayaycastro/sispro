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

        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->

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
                                    <h4 class="widget-title lighter">Regisgtro de Cintas</h4>


                                </div>

                                <form  class="form-horizontal" role="form" id="form-semiterminado" name="form-semiterminado"
                                       action="index.php?page=artsemiterminado&accion=insertar<?php if (!empty($_GET["id"])) : ?>&id=<?php
                                           echo $_GET["id"];
                                       endif;
                                       ?>" method="POST" >



                                    <div class="row">

                                        <div class="col-sm-6">


                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nombre  </label>

                                                        <div class="col-sm-9">
                                                            <input type="text" id="form-field-1-1" required="required" placeholder="Nombre" class="form-control"
                                                                   name="artsemi_descripcion"
                                                                   <?php if (!empty($_GET["id"])) : ?> value="<?php echo $artsemiter->getArtsemi_descripcion(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                                                   />
                                                            <input type="hidden" id ="idsemiterminado" name ="idsemiterminado" <?php if (!empty($_GET["id"])) : ?> value="<?php echo $_GET["id"]; ?>" <?php else: ?> value="0"<?php endif; ?> 
                                                                   >
                                                            <input type="hidden" id="permiso" name="permiso" value="<?php echo $permiso; ?>"/>  
                                                        </div>
                                                    </div>











                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tipo Semit.. </label>

                                                        <div class="col-sm-9">

                                                            <select name="tipsem_id" id="tipsem_id" class="chosen-select form-control" <?php if (!empty($_GET["id"])): ?>  <?php endif; ?>

                                                                    <?php // echo $permiso; ?> onchange="cargarcaracteristicas();" >
                                                                <option value="-1">    Seleccione una opción  </option>
                                                                <?php if (count($semiterminados)): ?>
                                                                    <?php foreach ($semiterminados as $semit): ?>

                                                                        <option value="<?php echo $semit ['tipsem_id'] ?>" <?php if (!empty($_GET["id"])):if ($semit ['tipsem_id'] == $artsemiter->getTipsem_id()): ?> selected 
                                                                            
                                                                            
                                                                               <?php else: ?> 
                                                                                disabled="disabled"
                                                                            <?php endif; ?>
                                                                                
                                                                                  
                                                                                
                                                                                
                                                                                  <?php endif; ?>
                                                                            <?php       ?>
                                                                               
                                                                        >
                                                                                <?php echo $semit['tipsem_titulo']; ?> 

                                                                        </option>

                                                                    <?php endforeach; ?>
                                                                <?php else : ?>

                                                                    <?php foreach ($semiterminados as $semit): ?>
                                                                        <option value="<?php echo $semit ['tipsem_id'] ?>" >
                                                                            <?php echo $semit ['tipsem_titulo']; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>



                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Estado  </label>

                                                        <div class="col-sm-9">
                                                            <div class="radio">
                                                                <label>
                                                                    <input name="optionsRadios" type="radio"  <?php echo $permiso; ?>  value="0"  class="ace" checked />
                                                                    <span class="lbl"> Activo</span>
                                                                </label>
                                                            </div>

                                                            <div class="radio">
                                                                <label>
                                                                    <input name="optionsRadios" type="radio"  <?php echo $permiso; ?>  value="1"  class="ace"  <?php if (!empty($_GET["id"])) : if ($artsemiter->getArtsemi_estado() == 1): ?> checked <?php
                                                                        endif;
                                                                    endif;
                                                                    ?>/>
                                                                    <span class="lbl"> Inactivo</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div id="cmbcaracteristicas"> 



                                            </div>


                                        </div>

                                    </div>







                                    <div class="space-18"></div>

                                    <div class="modal-footer">
                                        <a href="index.php?page=artsemiterminado&accion=listar" class="btn btn-sm" data-dismiss="modal">
                                            <i class="ace-icon fa fa-times"></i>
                                            Cancelar
                                        </a>

                                        <button class="btn btn-sm btn-primary" id="btn_buscar_maquinas" type="submit"<?php echo $permiso; ?>>
                                            <i class="ace-icon fa fa-check"></i>
                                            Guardar
                                        </button>
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
            </div><!-- /.main-container -->
  </div>
            <!-- basic scripts -->

            <!--[if !IE]> -->
            <script src="assets/js/jquery-2.1.4.min.js"></script>

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
<!--            <script src="view/js/produccion.js"></script>-->
            <script src="view/js/artsemiterminado.js"></script>
            <script src="view/js/adicionales.js"></script>


            <script src="view/js/caracterissemit.js"></script>

            <script src="assets/js/jquery.dataTables.min.js"></script>
            <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
            <script src="assets/js/dataTables.buttons.min.js"></script>
            <script src="assets/js/buttons.flash.min.js"></script>
            <script src="assets/js/buttons.html5.min.js"></script>
            <script src="assets/js/buttons.print.min.js"></script>
            <script src="assets/js/buttons.colVis.min.js"></script>
            <script src="assets/js/dataTables.select.min.js"></script>
            <script src="assets/js/bootbox.js"></script>




    </body>
</html>

