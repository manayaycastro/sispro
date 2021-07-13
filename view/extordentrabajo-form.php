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
                                <a href="#">Extrusión</a>
                            </li>
                            <li class="active">Orden de Trabajo</li>
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
                                    <h4 class="widget-title lighter">Regisgtro de Orden de Trabajo</h4>


                                </div>

                                <form  class="form-horizontal" role="form" id="form-semiterminado" name="form-semiterminado"
                                       action="index.php?page=extordentrabajo&accion=insertar<?php if (!empty($_GET["id"])) : ?>&id=<?php
                                           echo $_GET["id"];
                                       endif;
                                       ?>" method="POST" >

                                    <div class="row">
                                        <div class="col-sm-12">


                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <h3 class="header blue lighter smaller">
                                                        <i class="ace-icon fa fa-glyphicon-th smaller-90"></i>
                                                        Cabecera
                                                    </h3>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">



                                        <div class="col-sm-4">


                                            <div class="widget-body">
                                                <div class="widget-main">

                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1"> Tip. Documento </label>

                                                        <div class="col-sm-8">

                                                            <select name="tipdoc_id" id="tipdoc_id" class="form-control" <?php if (!empty($_GET["id"])): ?>  <?php endif; ?>

                                                                    >
                                                                <option value="-1">    Seleccione una opción  </option>
                                                                <?php if (count($tipdocumentos)): ?>
                                                                    <?php foreach ($tipdocumentos as $tipdoc): ?>

                                                                        <option value="<?php echo $tipdoc ['tipdoc_id'] ?>" <?php if (!empty($_GET["id"])):if ($tipdoc ['tipdoc_id'] == $extordentrabajo->getTipdoc_id()): ?> selected 


                                                                                    <?php else: ?> 
                                                                                        disabled="disabled"
                                                                                    <?php endif; ?>




                                                                                <?php endif; ?>
                                                                                <?php ?>

                                                                                >
                                                                                    <?php echo $tipdoc['tipdoc_titulo']; ?> 

                                                                        </option>

                                                                    <?php endforeach; ?>
                                                                <?php else : ?>

                                                                    <?php foreach ($tipdocumentos as $tipdoc): ?>
                                                                        <option value="<?php echo $tipdoc ['tipdoc_id'] ?>" >
                                                                            <?php echo $tipdoc ['tipdoc_titulo']; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1"> Colaborador </label>

                                                        <div class="col-sm-8">
                                                            <input type="text"  id="<?php echo $_SESSION['codempl']; ?>" required="required" readonly="readonly" class="form-control" 
                                                                   name="datos"
                                                                   <?php if (!empty($_GET["id"])) : ?> 
                                                                       value="<?php echo $_SESSION['nombres']; ?>"
                                                                   <?php else: ?> 

                                                                       value="<?php echo $_SESSION['nombres']; ?>"
                                                                   <?php endif; ?> 
                                                                   <?php echo $permiso; ?>

                                                                   />
                                                            <input name="codempl" type="hidden" value="<?php echo $_SESSION['codempl']; ?>">
                                                            <input name="ot" id="ot"type="hidden" value="<?php echo $id; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1"> Mixto  </label>

                                                        <div class="col-sm-8">
                                                            <div class="radio">
                                                                <label>
                                                                    <input name="optionsRadios" id="optionsRadios" type="radio"  <?php echo $permiso; ?>  value="0"  class="ace" checked />
                                                                    <span class="lbl"> NO</span>
                                                                </label>
                                                               
                                                            </div>
                                                            <div class="radio">
                                                                 <label>
                                                                    <input name="optionsRadios" id="optionsRadios2" type="radio"  <?php echo $permiso; ?>  value="1"  class="ace"  <?php if (!empty($_GET["id"])) : if ($extordentrabajo->getExtot_peine() == 1): ?> checked <?php
                                                                        endif;
                                                                    endif;
                                                                    ?>/>
                                                                    <span class="lbl"> Si</span>
                                                                </label>
                                                            </div> 


                                                        </div>
                                                    </div>



                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">
                                                            Almacen

                                                        </label>


                                                        <div class="col-sm-8">

                                                            <select name="are_id" id="are_id" class="form-control" <?php if (!empty($_GET["id"])): ?>  <?php endif; ?>

                                                                    >
                                                                <option value="-1">    Seleccione una opción  </option>
                                                                <?php if (count($areas)): ?>
                                                                    <?php foreach ($areas as $area): ?>

                                                                        <option value="<?php echo $area ['are_referencia'] ?>" 
                                                                        <?php  if (!empty($_GET["id"])):
                                                                            if ($area ['are_referencia'] == $extordentrabajo->getAre_id()):
                                                                                ?> selected 


                                                                                    <?php else: ?> 
                                                                                        disabled="disabled"
                                                                                        <?php endif; ?>


                                                                                <?php else: ?> 
                                                                            <?php if ($area ['are_referencia'] == $_SESSION['are_id']): ?> selected 


                                                                                    <?php else: ?> 
                                                                                        disabled="disabled"
                                                                             <?php endif; ?>


                                                                                <?php endif; ?>


                                                                                >
                                                                        <?php echo $area['are_titulo']; ?> 

                                                                        </option>

                                                                    <?php endforeach; ?>
                                                                <?php else : ?>

                                                                        <?php foreach ($areas as $area): ?>
                                                                        <option value="<?php echo $area ['are_referencia'] ?>" >
                                                                        <?php echo $area ['are_titulo']; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
<?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">
                                                            Turno

                                                        </label>


                                                        <div class="col-sm-8">

                                                            <select name="tur_id" id="tur_id" class="form-control" required="required"<?php if (!empty($_GET["id"])): ?>  <?php endif; ?>

                                                                    >
                                                                <option value="-1">    Seleccione una opción  </option>
                                                                <?php if (count($turnos)): ?>
    <?php foreach ($turnos as $tur): ?>

                                                                        <option value="<?php echo $tur ['tur_id'] ?>" <?php if (!empty($_GET["id"])):if ($tur ['tur_id'] == $extordentrabajo->getTur_id()): ?> selected 


                                                                                    <?php else: ?> 
                                                                                        disabled="disabled"
            <?php endif; ?>




                                                                                <?php endif; ?>
        <?php ?>

                                                                                >
        <?php echo $tur['tur_titulo']; ?> 

                                                                        </option>

                                                                    <?php endforeach; ?>
                                                                <?php else : ?>

                                                                        <?php foreach ($turnos as $tur): ?>
                                                                        <option value="<?php echo $tur ['tur_id'] ?>" >
                                                                        <?php echo $tur ['tur_titulo']; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
<?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1"> Máquina </label>

                                                        <div class="col-sm-8">

                                                            <select name="maq_id" id="maq_id" class="chosen-select form-control"     >
                                                                <option value="-1">    Seleccione una opción  </option>
                                                                <?php if (count($maquinas)): ?>
    <?php foreach ($maquinas as $maq): ?>

                                                                        <option value="<?php echo $maq ['maq_id'] ?>" <?php if (!empty($_GET["id"])):if ($maq ['maq_id'] == $extordentrabajo->getMaq_id()): ?> selected 


                                                                                    <?php else: ?> 
                                                                                        disabled="disabled"
            <?php endif; ?>




                                                                                <?php endif; ?>
        <?php ?>

                                                                                >
        <?php echo $maq['maq_nombre']; ?> 

                                                                        </option>

                                                                    <?php endforeach; ?>
                                                                <?php else : ?>

                                                                        <?php foreach ($maquinas as $maq): ?>
                                                                        <option value="<?php echo $maq ['maq_id'] ?>" >
                                                                        <?php echo $maq ['maq_nombre']; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
<?php endif; ?>
                                                            </select>
                                                        </div>

                                                    </div>





                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-4">

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">
                                                            Fec. Documento

                                                        </label>

                                                        <div class="col-sm-8">
                                                            <input type="date" id="form-field-1-1" required="required" placeholder="Fecha de puesta en marcha" class="form-control"
                                                                   name="extot_fecdoc"
<?php if (!empty($_GET["id"])) : ?> value="<?php echo $extordentrabajo->getExtot_fecdoc(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                                                   />

                                                        </div>
                                                    </div>



                                                
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1"> Num. Bajadas </label>

                                                        <?php if (empty($_GET["id"])) :  ?>
                                                        
                                                        <div class="col-sm-4">
                                                        
                                                                <input id="spinner" name="value" type="text"  readonly="readonly"
                                                               <?php       if (empty($_GET["id"])) :  ?>
                                                                       value="<?php echo $extordentrabajo->getExtot_num_baj(); ?>"
                                                                    
                                                                        <?php else:?>
                                                                    
                                                                         <?php endif;?>
                                                                   />
                                                             <input type="hidden" value="1">
                                                            
                                                        </div>
                                                        
                                                        <?php else:  ?>
                                                         <div class="col-sm-4">
                                                        <input type="hidden" value="2">
                                                                <input id="spinner" name="value" type="text"  readonly="readonly"
                                                               <?php       if (!empty($_GET["id"])) :  ?>
                                                                       value="<?php echo $extordentrabajo->getExtot_num_baj(); ?>"
                                                                        
                                                                        <?php else:?>
                                                                    
                                                                         <?php endif;?>
                                                                   />
                                                           
                                                            
                                                        </div>
                                                        
                                                        <?php endif;?>
                                                    </div>

                                                    
                                                    
                                                    
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">
                                                            Tipo Tubo

                                                        </label>


                                                        <div class="col-sm-8">

                                                            <select name="tip_tubo" id="tip_tubo" class="form-control"  required 
                                                            <?php  if (empty($_GET["id"])) : ?>        onchange="cargardetalle()"
                                                            <?php endif;?>
                                                                    >
                                                                <option value="-1">    Seleccione una opción  </option>
                                                                
                                                         <?php       if (!empty($_GET["id"])) :  ?>
      
                                                            <?php foreach ($lista as $list): ?>
                                                            <option value="<?php echo $list['pespro_id'] ?>"
                                                                   <?php  if (!empty($_GET["id"])): ?>
                                                                        <?php   if ($list ['pespro_id'] == $extordentrabajo->getTip_tubo()): ?>
                                                                    selected
                                                                <?PHP else: ?>
                          
                           <?PHP  endif; ?>
                    <?PHP  endif; ?>
                    
                    >
            <?php echo $list['pespro_descripcion']; ?>
            </option>
        <?php endforeach; ?> 
    <?php else : ?>
        <?php  echo '<option value=-1> No existen registros </option>'; ?>
    <?php endif; ?>

                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>


                                    </div>

                                    <div class="row">

                                        <div class="col-sm-12">
                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <div class="form-group">
                                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1"> Observacion </label>

                                                        <div class="col-sm-11">
                                                            <textarea id="observacion" name="observacion" class="autosize-transition form-control"
                                                                   <?php echo $permiso; ?>    
                                                                ><?php if (!empty($_GET["id"])) : ?><?php echo $extordentrabajo->getObservacion(); ?><?php endif; ?>    
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div> 


                                    </div>



                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <h3 class="header blue lighter smaller">
                                                        <i class="ace-icon fa fa-retweet smaller-90"></i>
                                                        Detalle
                                                    </h3>
                                                    
                                                    <div class="row">
									<div class="col-xs-12">
										<table id="simple-table" class="table  table-bordered table-hover">
                                                                                            <thead>
                                                                                                    <th class="detail-col">Ítems</th>
													<th>Lado</th>
													<th>Cinta</th>
													
                                                                                                        <th class="hidden-480">Tr / Ur</th>
                                                                                                        <th class="hidden-480">Bajada</th>
                                                                                            </thead>
                                                                                            <tbody id="detalle">
                                                                                                
                                                                                                
                                                                                            </tbody>
                                                                                </table>
									</div><!-- /.span -->
						    </div><!-- /.row -->
                                                    
                                                   
                                               


                                                </div>
                                            </div>
                                        </div>



                                    </div>









                                    <div class="space-18"></div>

                                    <div class="modal-footer">
                                        <a href="index.php?page=extordentrabajo&accion=listarot" class="btn btn-sm" data-dismiss="modal">
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

            <script src="assets/js/ace-elements.min.js"></script>
            <script src="assets/js/ace.min.js"></script>
            <script src="view/js/produccion.js"></script>
            <script src="view/js/extcargarot.js"></script>

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

            <script src="assets/js/jquery-ui.min.js"></script>
            <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
            <script src="assets/js/autosize.min.js"></script>


            <script type="text/javascript">
                                                                        jQuery(function ($) {

                                                                            //spinner
                                                                            var spinner = $("#spinner").spinner({
                                                                                create: function (event, ui) {
                                                                                    //add custom classes and icons
                                                                                    $(this)
                                                                                            .next().addClass('btn btn-success').html('<i class="ace-icon fa fa-plus"></i>')
                                                                                            .next().addClass('btn btn-danger').html('<i class="ace-icon fa fa-minus"></i>')

                                                                                    //larger buttons on touch devices
                                                                                    if ('touchstart' in document.documentElement)
                                                                                        $(this).closest('.ui-spinner').addClass('ui-spinner-touch');
                                                                                }
                                                                            });

                                                                            //slider example
                                                                            $("#slider").slider({
                                                                                range: true,
                                                                                min: 0,
                                                                                max: 500,
                                                                                values: [75, 300]
                                                                            });

                                                                            autosize($('textarea[class*=autosize]'));

                                                                        });
            </script>



    </body>
</html>

