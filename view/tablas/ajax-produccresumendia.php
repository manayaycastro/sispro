


<?php


if(!isset($opedidos)){
  require_once '../../model/prensa.php';  
  session_start();
  $rango='';
    if(isset($_REQUEST['rango'])) {
      $rango=$_REQUEST['rango'];        
    }    

$fecinicio = substr($rango, 0, 10);  
$fecfinal = substr($rango, 13, 21);  
    
 $fecini = date_create($fecinicio)  ; 
 $ini= date_format($fecini, 'Y-m-d');
 
 $fecfin= date_create($fecfinal)  ; 
 $fin=  date_format($fecfin, 'Y-m-d');


$produccion = new prensa();
    $lista_resumen =$produccion->ConsultarProduccResumenDia($ini,$fin);
$a= 0;
}





?> 

<link rel="stylesheet" href="view/css/personalizado.css" />

<div class="widget-body">
                                        <div class="widget-main">

<div class="row">
                <div class="col-xs-12">
                     <h3 class="header smaller lighter blue">Lista según siguiente filtro: <?php echo $ini.' - '.$fin;?> </h3>
<div class="clearfix">
    <div class="pull-right tableTools-container"></div>
</div>
<div class="table-header">
    Results for "Latest Registered Domains"
</div>
                     <input id ="ini" type="hidden" value="<?php echo $ini; ?>">
                       <input id ="fin" type="hidden" value="<?php echo $fin; ?>">
                     
                        
                       <div id="actualizartabla">
     <table id="dynamic-table" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="center">
                    <label class="pos-rel">
                        <input type="checkbox" class="ace" />
                        <span class="lbl"></span>
                    </label>
                </th>
                  <th>Items</th>
                
                   <th>Fecha</th>

                <th class="marcado">OP</th>

                <th class="hidden-480" >Codigo</th>


         <th>Descripción</th>
                  <th class="hidden-480">Peso</th>
                   <th>Cant. Pedida</th>
                    <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Cant. Atendida
                                                        </th>
                                                        
                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Cantidad
                                                        </th>
                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Peso
                                                        </th>
                 
                    <th>Tipo</th>
              

            </tr>
        </thead>

        <tbody>

            <?php if (count($lista_resumen)): ?>
                <?php foreach ($lista_resumen as $lista): ?>
            <?php     $a++; ?>
                    <tr>
                        <td class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </td>
                            <td><?php echo $a; ?></td>
                         <td><?php echo $lista ['fechaproduccion']; ?></td>
                        <td class="marcado"> <?php echo $lista ['numop']; ?></td>
                        <td class="marcado"><?php echo $lista ['codart'] ; ?></td>
                        <td><?php echo $lista ['desart']; ?></td>

                        <td><?php echo $lista ['peso_producto']; ?></td>

                        <td><?php echo $lista ['cantped']; ?></td>
                              <td><?php echo $lista ['sumcantidad']; ?></td>

                        <td class="marcado"><?php echo $lista ['sumcantidad_par']; ?></td>

                        <td class="marcado"><?php echo $lista ['sumpeso_par']; ?></td>

                       


                        <td>
                <center>  
                <?php echo $lista ['tipo_par']; ?>
                </center> 
              

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
								</div>


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
                                                <div class="widget-main padding-8"  >
                                                    <!--<ul id="tree1"></ul>  con javascrip--> 

                                                  
                                                    <div id = "ver_diseno">
                                                        
                                            
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


                    </div>
                </div>
            </div>
            <!-- Fin del modal DISENO -->
            
            
       
                          <!-- /.Inicio del modal modal ver disponibilidad -->
            <div id="modal-verdisponibilidad" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
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
                                                <h4 class="widget-title lighter smaller">Lista de Máquinas <span id="datosActualTXTtelares"></span></h4>
                                            </div>

                                            <div class="widget-body" >
                                                <div  class="centro" id="centro">
                                                  
                                                    <div id = "ver_listamaqprocesos">
                                                        
                                            
                                                         </div>
                                                    
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                  


                                </div>

                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->

    </div>                        
           
</div>

 <div class="space-18"></div>

       <div class="modal-footer">
       
          <input id ="ini" name="ini" type="hidden" value="<?php echo $ini; ?>">
          <input id ="fin" name="fin" type="hidden" value="<?php echo $fin; ?>">
   
                                                            
<!--        <button type="button" class="btn btn-sm" data-dismiss="modal">
            <i class="ace-icon fa fa-times"></i>
            Cancelar
        </button> -->

          <button type="button" class="btn btn-sm btn-primary"  id="ActualizarListProceso">
            <i class="ace-icon fa fa-check"></i>
            Salir (update)
        </button>
    </div>

                    </div>
                </div>
            </div>
            <!-- Fin del modal modal ver disponibilidad -->
            
   <script src="assets/js/bootbox.js"></script>
   
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
                        null, null, null, null, null,null,null, null,null,null,
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



        //And for the first simple table, which doesn't have TableTools or dataTables
        //select/deselect all rows according to table header checkbox
//        var active_class = 'active';
//        $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function () {
//            var th_checked = this.checked;//checkbox inside "TH" table header
//
//            $(this).closest('table').find('tbody > tr').each(function () {
//                var row = this;
//                if (th_checked)
//                    $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
//                else
//                    $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
//            });
//        });

        //select/deselect a row when the checkbox is checked/unchecked
//        $('#simple-table').on('click', 'td input[type=checkbox]', function () {
//            var $row = $(this).closest('tr');
//            if ($row.is('.detail-row '))
//                return;
//            if (this.checked)
//                $row.addClass(active_class);
//            else
//                $row.removeClass(active_class);
//        });



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
        /***************/





        /**
         //add horizontal scrollbars to a simple table
         $('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
         {
         horizontal: true,
         styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
         size: 2000,
         mouseWheelLock: true
         }
         ).css('padding-top', '12px');
         */


    })
</script>

