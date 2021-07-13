<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Tables - Ace Admin</title>

        <meta name="description" content="Static &amp; Dynamic Tables" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
        
   <link rel="stylesheet" href="assets/css/chosen.min.css" />
   
        <!--[if lte IE 9]>
                <link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
        <![endif]-->
        <link rel="stylesheet" href="assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src="assets/js/ace-extra.min.js"></script>
        <link rel="stylesheet" href="assets/css/chosen.min.css" />
        <link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
       
        <link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
        <link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-colorpicker.min.css" />

        <link rel="stylesheet" href="view/css/personalizado.css" />




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
                                <a href="#">Inicio</a>
                            </li>

                            <li>
                                <a href="#">Administración</a>
                            </li>
                            <li class="active">Máquina Proceso</li>
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



                                <div class="row">
                                    <div class="col-xs-12">


                                        <div class="col-xs-12"> 
                                            <div class="col-xs-9">
                                                <h4 class="header smaller lighter blue">Cantidad de registros <span class="badge"><?php echo count ($artsemiterminado_lista); ?></span></h4>
                                            </div>
                                            <div class="col-xs-3">
                                               
                                                    
                                            </div>
                                        </div>
                                        <br>

                                        <div class="clearfix">
                                            <div class="pull-right tableTools-container"></div>
                                        </div>
                                        <div class="table-header">
                                            Results for "Latest Registered Domains"
                                        </div>

                                        <!-- div.table-responsive -->

                                        <!-- div.dataTables_borderWrap -->
                                        <div>
                                            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="center">
                                                            <label class="pos-rel">
                                                                <input type="checkbox" class="ace" />
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </th>
                                                        <th>Id</th>
                                                        <th>Nombre</th>
                                                        
                                                        <th class="hidden-480">Estado</th>
                                                         <!--<th class="hidden-480">Código</th>-->
                                                         <th class="hidden-480"> Tipo Semiter.</th>
                                                       
                                                         
                                                         <th class="hidden-480">
                                                           
                                                            Tel.
                                                        </th>
                                                         <th class="hidden-480">
                                                           
                                                            Lam.
                                                        </th>
                                                         <th class="hidden-480">
                                                           
                                                            Imp.
                                                        </th>
                                                         <th class="hidden-480">
                                                           
                                                            Conv.
                                                        </th>
                                                         <th class="hidden-480">
                                                           
                                                            Bast.
                                                        </th>
                                                         <th class="hidden-480">
                                                           
                                                            Pren.
                                                        </th>
                                                        
                                                        
                                                           
                                                        
                                                       

                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php if (count($artsemiterminado_lista)): ?>
                                                        <?php foreach ($artsemiterminado_lista as $artsemiter): ?>
                                                            <tr>
                                                                <td class="center">
                                                                    <label class="pos-rel">
                                                                        <input type="checkbox" class="ace" />
                                                                        <span class="lbl"></span>
                                                                    </label>
                                                                </td>
                                                                <td><?php echo $artsemiter ['artsemi_id']; ?></td>
                                                                <td><?php echo $artsemiter ['artsemi_descripcion']; ?></td>
                                                                
                                                              
                                                                <?php if ($artsemiter ['artsemi_estado'] == 0): ?>
                                                                    <td class="hidden-480">
                                                                        <span class="label label-sm label-success">Activo</span>
                                                                    </td>
                                                                <?php else: ?>
                                                                    <td class="hidden-480">
                                                                        <span class="label label-sm label-warning">Inactivo</span>
                                                                    </td>
                                                                <?php endif; ?>
                                                                
                                                                
                                                                 <!--<td><?php // echo $artsemiter ['col_titulo']; ?></td>-->
                                                                <td><?php echo $artsemiter ['tipsem_titulo']; ?></td>
                                                                
                                                                <?php $ruta = new artsemiterminado();
                                                                $rutaproceso = $ruta->Lista_ProcesoXartic($artsemiter ['artsemi_id']);
                                                                ?>
                                                             <?php if($rutaproceso):?>
                                                                <?php foreach ($rutaproceso as $lis):?>
                                                                <?php if($lis['valitemcarac_valor']=='-1'):?>
                                                                <td><?php echo ''; ?></td>
                                                                 <?php else:?>
                                                                  <td>
                                                <center>
                                                                      <?php echo $lis['etiqueta']; ?>
                                                                    </center>
                                                
                                                                  </td>
                                                                <?php endif; ?>
                                                                <?php endforeach;?>
                                                                <?php endif; ?>
                                                                  
                                                                
                                                           
                                                            

                                                               
                                                                <td>
                                                                   
                                                                    <input type="hidden" id="id_<?php echo $artsemiter ['artsemi_id']; ?>" name="id_<?php echo $artsemiter ['artsemi_id']; ?>" value="<?php echo $artsemiter ['artsemi_id']; ?>" />  
                                                                     <!--<input type="hidden" id="tipsemi-<?php // echo $artsemiter ['artsemi_id']; ?>" name="tipsemi-<?php // echo $artsemiter ['artsemi_id']; ?>" value="<?php // echo $artsemiter ['tipsem_id']; ?>" />-->  
                                                               
                                                                
                                                                </td>








                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <?php echo '<div class="alert alert-warning">No se encontraron registros.</div>'; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>



                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->




            
                          <!-- /.Inicio del modal asignar maquina -->
            <div id="modal-asignarmaq" class="modal" tabindex="-1" >
                <div class="modal-dialog" id="mdialTamanio">
                    <!--class="modal-dialog modal-lg"-->
                    <div class="modal-content">
<!--                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          
                        </div>-->
<div class="modal-body">
    
    

                        <div class="row">


                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="widget-box widget-color-blue2">
                                            <div class="widget-header">
                                                <h4 class="widget-title lighter smaller"> OP numero <span id="datosActualTXTarticulo"></span></h4>
                                            </div>

                                            <div class="widget-body" >
                                                <div  class="centro" id="centro">
                                                  
                                                    <div id = "ver_listatelares">
                                                        
                                            
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

 <div class="space-18"></div>

       <div class="modal-footer">
       
                                                 
        <button type="button" class="btn btn-sm" data-dismiss="modal">
            <i class="ace-icon fa fa-times"></i>
            Cancelar
        </button>

          <button type="button" class="btn btn-sm btn-primary"  >
            <i class="ace-icon fa fa-check"></i>
            Salir (update)
        </button>
    </div>

                    </div>
                </div>
            </div>
            <!-- Fin del modal asignar maquina -->
   
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
        <script src="assets/js/jquery-ui.custom.min.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.min.js"></script>

      
        <script src="assets/js/bootstrap-tag.min.js"></script>
       
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



          <script src="view/js/articulocaractecnicas.js"></script>
         

<script src="assets/js/jquery-typeahead.js"></script>
   <script src="assets/js/autosize.min.js"></script>
     <script src="assets/js/chosen.jquery.min.js"></script>


            <!--<script src="view/js/caracterissemit_sacos.js"></script>-->





        <!-- inline scripts related to this page -->
        <script type="text/javascript">
            jQuery(function ($) {
                //initiate dataTables plugin
                var myTable =
                        $('#dynamic-table')
                        //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
                        .DataTable({
                            bAutoWidth: false,
                            "aoColumns": [
                                {"bSortable": false},
                                null, null, null, null, null,null, null, null, null, null,  
                                {"bSortable": false}
                            ],
                            "aaSorting": [],
                            select: {
                                style: 'multi'
                            }
                        });



                $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

                new $.fn.dataTable.Buttons(myTable, {
                    buttons: [
                        {
                            "extend": "colvis",
                            "text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
                            "className": "btn btn-white btn-primary btn-bold",
                            columns: ':not(:first):not(:last)'
                        },
                        {
                            "extend": "copy",
                            "text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
                            "className": "btn btn-white btn-primary btn-bold"
                        },
                        {
                            "extend": "csv",
                            "text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
                            "className": "btn btn-white btn-primary btn-bold"
                        },
                        {
                            "extend": "excel",
                            "text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
                            "className": "btn btn-white btn-primary btn-bold"
                        },
                        {
                            "extend": "pdf",
                            "text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
                            "className": "btn btn-white btn-primary btn-bold"
                        },
                        {
                            "extend": "print",
                            "text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
                            "className": "btn btn-white btn-primary btn-bold",
                            autoPrint: false,
                            message: 'This print was produced using the Print button for DataTables'
                        }
                    ]
                });
                myTable.buttons().container().appendTo($('.tableTools-container'));

                //style the message box
                var defaultCopyAction = myTable.button(1).action();
                myTable.button(1).action(function (e, dt, button, config) {
                    defaultCopyAction(e, dt, button, config);
                    $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
                });


                var defaultColvisAction = myTable.button(0).action();
                myTable.button(0).action(function (e, dt, button, config) {

                    defaultColvisAction(e, dt, button, config);


                    if ($('.dt-button-collection > .dropdown-menu').length == 0) {
                        $('.dt-button-collection')
                                .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
                                .find('a').attr('href', '#').wrap("<li />")
                    }
                    $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
                });

                ////

                setTimeout(function () {
                    $($('.tableTools-container')).find('a.dt-button').each(function () {
                        var div = $(this).find(' > div').first();
                        if (div.length == 1)
                            div.tooltip({container: 'body', title: div.parent().text()});
                        else
                            $(this).tooltip({container: 'body', title: $(this).text()});
                    });
                }, 500);





                myTable.on('select', function (e, dt, type, index) {
                    if (type === 'row') {
                        $(myTable.row(index).node()).find('input:checkbox').prop('checked', true);
                    }
                });
                myTable.on('deselect', function (e, dt, type, index) {
                    if (type === 'row') {
                        $(myTable.row(index).node()).find('input:checkbox').prop('checked', false);
                    }
                });




                /////////////////////////////////
                //table checkboxes
                $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

                //select/deselect all rows according to table header checkbox
                $('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function () {
                    var th_checked = this.checked;//checkbox inside "TH" table header

                    $('#dynamic-table').find('tbody > tr').each(function () {
                        var row = this;
                        if (th_checked)
                            myTable.row(row).select();
                        else
                            myTable.row(row).deselect();
                    });
                });

                //select/deselect a row when the checkbox is checked/unchecked
                $('#dynamic-table').on('click', 'td input[type=checkbox]', function () {
                    var row = $(this).closest('tr').get(0);
                    if (this.checked)
                        myTable.row(row).deselect();
                    else
                        myTable.row(row).select();
                });



                $(document).on('click', '#dynamic-table .dropdown-toggle', function (e) {
                    e.stopImmediatePropagation();
                    e.stopPropagation();
                    e.preventDefault();
                });



                //And for the first simple table, which doesn't have TableTools or dataTables
                //select/deselect all rows according to table header checkbox
                var active_class = 'active';
                $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function () {
                    var th_checked = this.checked;//checkbox inside "TH" table header

                    $(this).closest('table').find('tbody > tr').each(function () {
                        var row = this;
                        if (th_checked)
                            $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                        else
                            $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
                    });
                });

                //select/deselect a row when the checkbox is checked/unchecked
                $('#simple-table').on('click', 'td input[type=checkbox]', function () {
                    var $row = $(this).closest('tr');
                    if ($row.is('.detail-row '))
                        return;
                    if (this.checked)
                        $row.addClass(active_class);
                    else
                        $row.removeClass(active_class);
                });



                /********************************/
                //add tooltip for small view action buttons in dropdown menu
                $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

                //tooltip placement on right or left
                function tooltip_placement(context, source) {
                    var $source = $(source);
                    var $parent = $source.closest('table')
                    var off1 = $parent.offset();
                    var w1 = $parent.width();

                    var off2 = $source.offset();
                    //var w2 = $source.width();

                    if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                        return 'right';
                    return 'left';
                }




                /***************/
                $('.show-details-btn').on('click', function (e) {
                    e.preventDefault();
                    $(this).closest('tr').next().toggleClass('open');
                    $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
                });







            })
        </script>



        
        
    </body>
</html>
