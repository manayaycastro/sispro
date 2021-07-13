

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Tables - Ace Admin</title>

        <meta name="description" content="Static &amp; Dynamic Tables" />
        <meta name="description" content="Common Buttons &amp; Icons" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

        <link rel="stylesheet" href="assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
        <link rel="stylesheet" href="assets/css/selecticons.css">

        <script src="assets/js/ace-extra.min.js"></script>

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
                                <a href="#">Tables</a>
                            </li>
                            <li class="active">Simple &amp; Dynamic</li>
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




                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->

                                
<form  class="form-horizontal" role="form" 
       action="index.php?page=menu&accion=insertar<?php if(!empty($_GET["id"])) :?>&id=<?php echo $_GET["id"]; endif; ?>" method="POST">

    <div class="modal-body">
        <div class="widget-box">
            <div class="widget-header widget-header-small">
                <h5 class="widget-title lighter">Ingresar Datos</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <div class="row">
                
                        <div class="col-xs-12 col-sm-8">
                        
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Menu </label>

                                <div class="col-sm-9">
                                    <input type="text" required="required" placeholder="Nombre del Menu" class="form-control" 
                                           name="menu"
                                           <?php if(!empty($_GET["id"])) :?> value="<?php echo $menu_id->gettitulo(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                           
                                           />
                                </div>
                            </div>
                            
                      
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Enlace  </label>

                                <div class="col-sm-9">
                                    <input type="text"  required="required" placeholder="Enlace" class="form-control"
                                            name="enlace"
                                           <?php if(!empty($_GET["id"])) :?> value="<?php echo $menu_id->getenlace(); ?>"<?php endif; ?>  <?php echo $permiso; ?>
                                           />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Posición </label>

                                <div class="col-sm-9">
                                    <input type="text"  required="required" placeholder="Posición" class="form-control" 
                                           name="posicion"
                                           <?php if(!empty($_GET["id"])) :?> value="<?php echo $menu_id->getposicion(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                           />
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Icons </label>

                                <div class="col-sm-9">
                                        <select <?php echo $permiso; ?> style="width: 595px; height:25px;" name= 'icon' title="Select your spell" class="selectpicker">
<!--  <option>Select...</option>
  <option data-icon="ace-icon fa fa-adjust" data-subtext="petrification">Eye of Medusa</option>
  <option data-icon="glyphicon glyphicon-fire" data-subtext="area damage">Rain of Fire</option>-->
  
  <?php if (count($icons)): ?>
    <?php foreach ($icons as $icon): ?>
<option data-icon="ace-icon fa <?php  echo $icon['ico_descripcion'];?>"  data-subtext="<?php  echo $icon['ico_descripcion'];?>"
  value="<?php echo $icon ['ico_id'] ?>" <?php if(!empty($_GET["id"])):if($icon ['ico_id'] == $menu_id->getIcon()): ?> selected <?php endif; endif; ?>>
            <?php echo $icon['ico_descripcion']; ?>
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
        </div>


    </div>

    <div class="space-18"></div>

    <div class="modal-footer">
        <a class="btn btn-sm" href="index.php?page=menu&accion=listar">
            <i class="ace-icon fa fa-times"></i>
            Cancelar
        </a>

        <button class="btn btn-sm btn-primary" <?php echo $permiso; ?>>
            <i class="ace-icon fa fa-check"></i>
            Guardar
        </button>
    </div>


</form>




                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->


      
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

        <script src="view/js/menu.js"></script>


        <script type="text/javascript">
             if ('ontouchstart' in document.documentElement)
          document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
<!--        <script type="text/javascript">
               if ('ontouchstart' in document.documentElement)
           document.write("<script src='assets/js/selecticons.js'>" + "<" + "/script>");
        </script>-->
        <script src="assets/js/bootstrap.min.js"></script>

        <!-- page specific plugin scripts -->
        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
        <script src="assets/js/dataTables.buttons.min.js"></script>
        <script src="assets/js/buttons.flash.min.js"></script>
        <script src="assets/js/buttons.html5.min.js"></script>
        <script src="assets/js/buttons.print.min.js"></script>
        <script src="assets/js/buttons.colVis.min.js"></script>
        <script src="assets/js/dataTables.select.min.js"></script>

        <script src="assets/js/bootbox.js"></script>

        <!-- ace scripts -->
        <script src="assets/js/ace-elements.min.js"></script>
        <script src="assets/js/ace.min.js"></script>
        
         <script src="assets/js/ace.min.js"></script>


       <script async  src="assets/js/selecticons.js" ></script>
       
  
    
    </body>
</html>

