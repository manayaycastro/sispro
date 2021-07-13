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

        <link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="view/css/personalizado.css" />
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
                                <a href="#">Ajustes</a>
                            </li>

                            <li>
                                <a href="#">Planificación</a>
                            </li>
                            <li class="active">Cambio de Máquina</li>
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
                                    <h4 class="widget-title lighter">Lista de cambios de máquina.</h4>


                                </div>


                                <div class="widget-body">
                                    <div class="widget-main">

                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="col-xs-12"> 
                                                    <div class="col-xs-9">
                                                        <h4 class="header smaller lighter blue">Cantidad de registros <span class="badge"><?php echo count($lista_cambiomaq); ?></span></h4>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <a class="btn btn-primary" data-toggle="modal" data-target="#modal-cambiomaq">
                                                            <i class="ace-icon fa fa-plus align-top bigger-125"></i>
                                                            Nuevo
                                                        </a>

                                                    </div>
                                                </div>





                                                <div class="clearfix">
                                                    <div class="pull-right tableTools-container"></div>
                                                </div>
                                                <div class="table-header">
                                                    Resultados para la busqueda 
                                                </div>


                                                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">
                                                                <label class="pos-rel">
                                                                    <input type="checkbox" class="ace" />
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </th>

                                                               <th>OP ---> Kanban</th>

                                                            <th class="hidden-480">Maq. Origen </th>
                                                            <th class="hidden-480">Maq. fin </th>

                                                            <th>Motivo</th>

                                                            <th>Proceso</th>
                                                            <th>Fecha Creación</th>

                                                            <th>Usuario</th>


                                                            <th>Acción</th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                        <?php if (count($lista_cambiomaq)): ?>
                                                            <?php foreach ($lista_cambiomaq as $lista): ?>
                                                                <tr>
                                                                    <td class="center">
                                                                        <label class="pos-rel">
                                                                            <input type="checkbox" class="ace" />
                                                                            <span class="lbl"></span>
                                                                        </label>
                                                                    </td>
                                                                    <td><?php echo $lista ['prokandet_nroped'] ." --> " .$lista ['cammaq_kanban'] ; ?></td>
                                                                    <td><?php echo $lista ['origen']; ?></td>
                                                                    <td><?php echo $lista ['fin']; ?></td>

                                                                    <td><?php echo $lista ['cammaq_motivo']; ?></td>
                                                                    <td><?php echo $lista ['cammaq_proceso']; ?></td>

                                                                    <td><?php echo $lista ['fecha_modif']; ?></td>
                                                                    <td><?php echo $lista ['cammaq_usr']; ?></td>





                                                                    <td>
                                                                        <div class="hidden-sm hidden-xs action-buttons">




                                                                        </div>

                                                                        <div class="hidden-md hidden-lg">
                                                                            <div class="inline pos-rel">
                                                                                <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                                                    <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                                                </button>

                                                                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                                                    <li>

                                                                                    </li>


                                                                                </ul>
                                                                            </div>
                                                                        </div>
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
                                </div>




                            </div><!-- /.page-content -->




                        </div>  
                        <br>   <br>  <br>  <br>  <br>  <br>   <br>  <br>  <br>  <br>
                    </div><!-- /.main-content -->

                    <!-- /.Inicio del modal insertar kanban manual -->


                    <div id="modal-cambiomaq" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
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
                                                            <h4 class="widget-title lighter smaller"> Ingreso una nueva transferencia</h4>
                                                        </div>

                                                        <div class="widget-body" >




                                                            <div class="modal-body">
                                                                <div class="widget-box">
                                                                    <div class="widget-header widget-header-small">
                                                                        <h5 class="widget-title lighter">Ingresar Datos</h5>
                                                                    </div>

                                                                    <div class="widget-body">
                                                                        <div class="widget-main">

                                                                            <div class="row">

                                                                                <div class="col-xs-12 col-sm-6">


                                                                                    <div class="form-group">

                                                                                        <div class="col-sm-12">
                                                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> OP. Origen  </label>
                                                                                            <div class="col-sm-9">
                                                                                                <select name="ops_abierta" class="chosen-select form-control" id="ops_abierta" data-placeholder="Choose a State...">

                                                                                                    <?php if (count($ops)): ?>
                                                                                                        <?php foreach ($ops as $lista): ?>
                                                                                                            <option value="<?php echo $lista ['prodped_op'] ?>" 

                                                                                                                    >
                                                                                                                        <?php echo $lista ['prodped_op']; ?>
                                                                                                            </option>
                                                                                                        <?php endforeach; ?>

                                                                                                    <?php endif; ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="hr hr32 hr-dotted" style="margin-top: 15px; margin-bottom: 7px;"></div>
                                                                                </div>

                                                                                <div class="col-xs-12 col-sm-6">


                                                                                    <div class="form-group">

                                                                                        <div class="col-sm-12">
                                                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> OP. Destino  </label>

                                                                                            <div class="col-sm-9">
                                                                                                <select name="procesos" class="chosen-select form-control" id="procesos" data-placeholder="Choose a State...">

                                                                                                    <?php if (count($listaprocesos)): ?>
                                                                                                        <?php foreach ($listaprocesos as $lista): ?>
                                                                                                            <option value="<?php echo $lista ['tabgendet_id'] ?>" 

                                                                                                                    >
                                                                                                                        <?php echo $lista ['tabgendet_nombre']; ?>
                                                                                                            </option>
                                                                                                        <?php endforeach; ?>

                                                                                                    <?php endif; ?>
                                                                                                </select>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>


                                                                                </div>



                                                                            </div>
                                                                            <div class="hr hr32 hr-dotted" style="margin-top: 15px; margin-bottom: 7px;"></div>
                                                                            <div class="row">
                                                                                <div class="col-xs-12 col-sm-12">

                                                                                    <div class="row-fluid">
                                                                                        <div id="cargarKanban"></div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                            <div class="space-18"></div>

                                                            <div class="modal-footer">
                                                                <button class="btn btn-sm" data-dismiss="modal">
                                                                    <i class="ace-icon fa fa-times"></i>
                                                                    Cancelar
                                                                </button>

                                                                <button class="btn btn-sm btn-primary" enabled="">
                                                                    <i class="ace-icon fa fa-check"></i>
                                                                    Guardar
                                                                </button>
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
                    </div>
                    <!-- Fin del del modal insertar kanban manual -->


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


                <script src="assets/js/jquery.dataTables.min.js"></script>
                <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
                <script src="assets/js/dataTables.buttons.min.js"></script>
                <script src="assets/js/buttons.flash.min.js"></script>
                <script src="assets/js/buttons.html5.min.js"></script>
                <script src="assets/js/buttons.print.min.js"></script>
                <script src="assets/js/buttons.colVis.min.js"></script>
                <script src="assets/js/dataTables.select.min.js"></script>
                <script src="assets/js/bootbox.js"></script>



                <script src="view/js/adicionales.js"></script>
                    <script src="view/js/opedido.js"></script>
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
                                    null, null, null, null, null, null, null,
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



                    // comentado nestor manayay para que no se haga check cuando se selecciona una fila

                    //        myTable.on('select', function (e, dt, type, index) {
                    //            if (type === 'row') {
                    //                $(myTable.row(index).node()).find('input:checkbox').prop('checked', true);
                    //            }
                    //        });
                    //        myTable.on('deselect', function (e, dt, type, index) {
                    //            if (type === 'row') {
                    //                $(myTable.row(index).node()).find('input:checkbox').prop('checked', false);
                    //            }
                    //        });




                    /////////////////////////////////
                    //table checkboxes
                    //        $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
                    //
                    //        //select/deselect all rows according to table header checkbox
                    //        $('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function () {
                    //            var th_checked = this.checked;//checkbox inside "TH" table header
                    //
                    //            $('#dynamic-table').find('tbody > tr').each(function () {
                    //                var row = this;
                    //                if (th_checked)
                    //                    myTable.row(row).select();
                    //                else
                    //                    myTable.row(row).deselect();
                    //            });
                    //        });

                    //select/deselect a row when the checkbox is checked/unchecked
                    //        $('#dynamic-table').on('click', 'td input[type=checkbox]', function () {
                    //            var row = $(this).closest('tr').get(0);
                    //            if (this.checked)
                    //                myTable.row(row).deselect();
                    //            else
                    //                myTable.row(row).select();
                    //        });



                    $(document).on('click', '#dynamic-table .dropdown-toggle', function (e) {
                        e.stopImmediatePropagation();
                        e.stopPropagation();
                        e.preventDefault();
                    });


                    $('#modal-cambiomaq').on('shown.bs.modal', function () {
                        if (!ace.vars['touch']) {
                            $(this).find('.chosen-container').each(function () {
                                $(this).find('a:first-child').css('width', '350px');
                                $(this).find('.chosen-drop').css('width', '350px');
                                $(this).find('.chosen-search input').css('width', '340px');
                            });
                        }
                    })



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

                <script type="text/javascript">
                    $(document).ready(function () {
                        $("#procesos").change(function () {
                            $("#procesos").each(function () {
                                $('#cargarKanban').html('<center><img src="view/img/loadingV02.gif"/></center>');
                                $.post("view/tablas/ajax-cambiomaq.php", {ops_abierta: $("#ops_abierta").val(), procesos: $("#procesos").val()}, function (data) {
                                    $("#cargarKanban").html(data);

                                });
                            });
                        });
                    });
                </script>


                <script type="text/javascript">
                    $(document).ready(function () {
                        $("#ops_abierta").change(function () {
                            $("#ops_abierta").each(function () {
                                $('#cargarKanban').html('<center><img src="view/img/loadingV02.gif"/></center>');
                                $.post("view/tablas/ajax-cambiomaq.php", {ops_abierta: $("#ops_abierta").val(), procesos: $("#procesos").val()}, function (data) {
                                    $("#cargarKanban").html(data);

                                });
                            });
                        });
                    });
                </script>
                </body>
                </html>

