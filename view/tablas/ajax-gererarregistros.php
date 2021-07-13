


<?php


if(!isset($listaprocesos)){// revisar
  require_once '../../model/kanban.php';
  require_once '../../controller/class.inputfilter.php';
  session_start();
  $filter = new InputFilter();
//  $rango='';
//    if(isset($_REQUEST['rango'])) {
      $rango=$filter->process($_REQUEST['rango']);  
       $estado=$filter->process($_REQUEST['estado']); 
        $procesos=$filter->process($_REQUEST['procesos']); 
//    }    

$fecinicio = substr($rango, 0, 10);  
$fecfinal = substr($rango, 13, 21);  
    
 $fecini = date_create($fecinicio)  ; 
 $ini= date_format($fecini, 'Y-m-d');
 
 $fecfin= date_create($fecfinal)  ; 
 $fin=  date_format($fecfin, 'Y-m-d');
 
 // SE REGISTRARA UNA MAQUINA EN -1 PARA QUE SE LISTEN TODAS, PUES SE EVITA MOSTRARA LA MAQUINA EN EL PRESENTE FORMULARIO
 $maquina= '-1';



$progprocesos = new kanban();
    $listaprocesos =$progprocesos->consultarAvanceProduccRollo($ini,$fin,$procesos,$estado,$maquina);

}






?> 
<link rel="stylesheet" href="view/css/personalizado.css" />

<div class="widget-body">
                                        <div class="widget-main">

<div class="row">
                <div class="col-xs-12">
                     <h3 class="header smaller lighter blue">Lista según siguiente filtro: <?php ini_set('date.timezone','America/Lima'); 
echo $ini.' - '.$fin.' '.date("Y-m-d"). ' '.date("H:i:s");?> </h3>
<div class="clearfix">
    <div class="pull-right tableTools-container"></div>
</div>
<div class="table-header">
    Results for "Latest Registered Domains"
</div>
                  <input id ="ini" type="hidden" value="<?php echo $ini; ?>">
                       <input id ="fin" type="hidden" value="<?php echo $fin; ?>">
                        <input id ="procesos" type="hidden" value="<?php echo $procesos; ?>">
                        <input id ="estado" type="hidden" value="<?php echo $estado; ?>">
<!--                         <input id="tipdoc" type="hidden" value="PEDIDO" >
                          <input id="vb" type="hidden" value="ventas" >-->
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

                <th>Kanban (OP)</th>


                
                
                 <?php if($procesos=='171' or $procesos=='172'): ?>  
                     <th class="hidden-480">Total Sacos (Proces. Anterior)</th>
                 
                      <?php else : ?>  
                     <th class="hidden-480">Metros por rollo</th>
               
                      <?php endif;?>  

         <th>Cod. Art.</th>
                
                  <th> Inicio (Fech./Hor.)</th>
                     <th>Termino (Fech./Hor.)</th>
                     
                       <?php if($procesos=='170' or $procesos=='171'): ?>  
                     <th class="hidden-480">Total Sacos</th>
                   <th>Toatal Sacos B</th>
                      <?php else : ?>  
                     <th class="hidden-480">Metros Total</th>
                   <th>Peso Total</th>
                      <?php endif;?>  
                     
                     
                   
                       <th>+ ver mas!</th>
                     <th>Estado</th>
                     
                     <th>Generar Filas</th>
                   
                     <th>Acción <?php echo floor(890%1000); ?></th>

            </tr>
        </thead>

        <tbody>

            <?php if (count($listaprocesos)): ?>
                <?php foreach ($listaprocesos as $lista): ?>
                    <tr>
                        <td class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td><?php echo $lista ['prokandet_id'] ."  (".$lista ['prokandet_nroped'].")"; ?></td>

                        
                         <?php if($procesos=='171' or $procesos=='172'): ?>  
                      <td><?php echo $lista ['prosacodet_total']. " ( Clase A) ---> ".$lista ['prosacodet_totalb']." (Clase B)";  ?></td>
                 
                      <?php else : ?>  
                       <td><?php echo round ($lista ['prokandet_mtrs'],2); ?></td>
               
                      <?php endif;?>  
                        
                     



                               <td><?php echo $lista ['codart']; ?></td>

                             

                                
                               
                                   <td><?php echo $lista ['progprodet_fecha_ini']. " ---> ".$lista ['progprodet_hora_ini']; ?></td>
                                    <td><?php echo $lista ['progprodet_fecha_fin']. " ---> ".$lista ['progprodet_hora_fin']; ?></td>
                                  
                                    
                                      <td><?php echo round ($lista ['proroll_mtrs_total'],0).'    [ '.round ($lista ['parciala'],0).' ]'; ?></td>
                                  <td><?php echo round ($lista ['proroll_peso_total'],0).'    [ '.round ($lista ['parcialb'],0).' ]'; ?></td>
                                
                                    
                                    <td>
                                         <?php if ($lista ['proroll_atendido'] == '0'): ?> 
                                              <span class="label label-warning">Proceso</span>
                                        
                                        <?php else: ?>
                                             <span class="label label-success arrowed-in arrowed-in-right">Culminado</span>
                                        <?php endif; ?>
                                    </td>   
                                     
                          
                     <td> 
                                <div class="inline dropdown-hover">
                                        <a class="btn btn-minier btn-primary">
                                                Kanban Det.
                                                <i class="ace-icon fa fa-angle-down icon-on-right bigger-110"></i>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-right dropdown-125 dropdown-lighter dropdown-close dropdown-caret">
                                                <li class="active">

                                                        <a  class="blue">
                                                                <i class="ace-icon fa fa-caret-right bigger-110">&nbsp;</i>
                                                        <?php echo $lista ['desart']; ?> (Nombre)
                                                        </a>
                                                </li>

                                                <li>
                                                        <a >
                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                                                <?php echo $lista ['razonsocial']; ?> (Cliente)
                                                        </a>
                                                </li>

                                                <li>
                                                        <a >
                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                                <?php echo $lista ['prokandet_items']." / ".$lista ['prokan_cantkanban']; ?> (Identificación)
                                                        </a>
                                                </li>

                                                <li>
                                                        <a >
                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                                                 <?php echo $lista ['fecha_creacion2']; ?> (Fec. Creación Prog. Proceso)
                                                        </a>
                                                </li>

                                               <li>
                                                        <a >
                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                                                <?php echo $lista ['progpro_fecprogramacion']; ?> (Fec. Programación Proceso)
                                                        </a>
                                                </li>
                        <!--                         <li>
                                                        <a >
                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                                                <?php //echo $lista ['codalt']; ?> (Cod. Alterno)
                                                        </a>
                                                </li>
                                                
                                                <li>
                                                        <a >
                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                                                <?php //echo $lista ['razonsocial']; ?> (Cliente)
                                                        </a>
                                                </li>-->
                                                
                                                <?php // if ($lista ['prokan_id'] != null): ?>
<!--                                                <li>
                                                        <a >
                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                                                <?php //echo $lista ['prokan_mtrs_totales']; ?> (Cant. Metros - Totales)
                                                        </a>
                                                </li>
                                                <li>
                                                        <a >
                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                                                <?php //echo $lista ['prokan_cantkanban']; ?> (Cant. Kanban)
                                                        </a>
                                                </li>-->
                                                <?php // endif;?>
                                        </ul>
                                 </div>
                                </td>
                                
                                
                                <td>

                                    <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                                    src="view/img/loadingV02.gif" class="loading-<?php echo  $lista ['prosacodet_id']; ?>" >
                                    <input name="switch-field-1" class="ace ace-switch ace-switch-6" type="checkbox" 
                                    <?php if ($lista ['regparcialesproduc'] == '2'  ): ?> checked="checked" disabled="disabled"<?php else: ?> <?php endif; ?>
                                    id="genfilas" data-genfilas="<?php echo  $lista ['prosacodet_id']; ?>"

                                    />
                                    <span class="lbl"></span>
                                      <input id ="progprodet_id-<?php echo  $lista ['prosacodet_id']; ?>" type="hidden" value="<?php echo $lista ['progprodet_id']; ?>">
                                       <input id ="kandet_id-<?php echo  $lista ['prosacodet_id']; ?>" type="hidden" value="<?php echo $lista ['prokandet_id']; ?>">
                                        <input id ="claseb_ant-<?php echo  $lista ['prosacodet_id']; ?>" type="hidden" value="<?php echo $lista ['parcialb']; ?>">
                                        
                                        <input id ="totala-<?php echo  $lista ['prosacodet_id']; ?>" type="hidden" value="<?php echo $lista ['parciala']; ?>">
                                        <input id ="totalb-<?php echo  $lista ['prosacodet_id']; ?>" type="hidden" value="<?php echo $lista ['parcialb']; ?>">
                                         <input id ="nroped-<?php echo  $lista ['prosacodet_id']; ?>" type="hidden" value="<?php echo $lista ['prokandet_nroped']; ?>">
                                          <input id ="cantenfardado-<?php echo  $lista ['prosacodet_id']; ?>" type="hidden" value="<?php echo $lista ['enfardelado']; ?>">
                               </td>
                               

                        <td >
                            <div class="hidden-sm hidden-xs action-buttons">
                                  
                                     
                           
                                     
                                  <?php if($procesos=='170'): ?>  
                                <!--conversion-->
                                <a class="blue"
                                     onclick=" false" href="#" data-ingresaravancesacos ="<?php echo $lista ['prosacodet_id']; ?>" 
                                    <?php if ($lista ['proroll_atendido'] == '0'): ?>   id="ingresaravancesacos" <?php endif; ?>
                                   >
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>
                                
                                
                                 <?php elseif($procesos=='171'): ?> 
                                <!--bastillado-->
                                <a class="blue"
                                     onclick=" false" href="#" data-ingresaravancesacosbas ="<?php echo $lista ['prosacodet_id']; ?>" 
                                    <?php if ($lista ['proroll_atendido'] == '0'): ?>   id="ingresaravancesacosbas" <?php endif; ?>
                                   >
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>
                                
                                 <?php elseif($procesos=='172'): ?> 
                                <!--prensa-->
                                <a class="blue"
                                     onclick=" false" href="#" data-detallefilas ="<?php echo $lista ['prosacodet_id']; ?>" 
                                      id="detallefilas" 
                                   >
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>
                                
                                
                                   <?php else: ?> 
                                <!--telares, laminado, impresion-->
                                <a class="blue"
                                     onclick=" false" href="#" data-ingresaravance ="<?php echo $lista ['prosacodet_id']; ?>" 
                                    <?php if ($lista ['proroll_atendido'] == '0'): ?>   id="ingresaravance" <?php endif; ?>
                                   >
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>
                                 <?php endif; ?> 
                                 

                             



                            </div>

                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                        <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                        <li>
                                            <a  class="tooltip-info" data-rel="tooltip" title="Ver detalle" 
                                               
                                                onclick=" false" href="#" data-ingresaravance ="<?php echo $lista ['prosacodet_id']; ?>" 
                                                <?php if ($lista ['proroll_atendido'] == '0'): ?>   id="ingresaravance" <?php endif; ?>

                                                >

                                                <span class="blue">
                                                    <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                </span>
                                            </a>
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
								</div>



  <!-- /.Inicio del modal ORDEN DE PEDIDO -->
            <div id="modal-asignaravance" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
                 
                <div class="modal-dialog" id="mdialTamanio">
                    <!--class="modal-dialog modal-lg"-->
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
                                                <h4 class="widget-title lighter smaller">Agregar Nueva Producción <span id="datosActualTXT"></span></h4>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main padding-8"  style="height: 590px;">
                                                    <!--<ul id="tree1"></ul>  con javascrip--> 

                                                  
                                                    
                                                    <div id="guardaravanceproducc" >
                                                        
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
            <!-- Fin del modal acceso -->

            
    <!-- /.Inicio del modal registro de sacos conversion -->
            <div id="modal-asignaravancesacos" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
                 
                <div class="modal-dialog" id="mdialTamanio">
                    <!--class="modal-dialog modal-lg"-->
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
                                                <h4 class="widget-title lighter smaller">Agregar  Producción  sacos<span id="datosActualTXTsacos"></span></h4>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main padding-8"  style="height: 590px;">
                                                    <!--<ul id="tree1"></ul>  con javascrip--> 

                                                  
                                                    
                                                    <div id="guardaravanceproduccsacos" >
                                                        
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
            <!-- fin del modal registro de sacos conversion -->

   <!-- /.Inicio del modal registro de sacos Bastillado -->
            <div id="modal-asignaravancesacosbas" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
                 
                <div class="modal-dialog" id="mdialTamanio">
                    <!--class="modal-dialog modal-lg"-->
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
                                                <h4 class="widget-title lighter smaller">Agregar  Producción  sacos Bastillado<span id="datosActualTXTsacos"></span></h4>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main padding-8"  style="height: 590px;">
                                                    <!--<ul id="tree1"></ul>  con javascrip--> 

                                                  
                                                    
                                                    <div id="guardaravanceproduccsacosbas" >
                                                        
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
            <!-- fin del modal registro de sacos Bastillados -->
<!-- /.Inicio del modal ORDEN DE PEDIDO -->
            <div id="modal-filasgeneradas" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
                 
                <div class="modal-dialog" id="mdialTamanio">
                    <!--class="modal-dialog modal-lg"-->
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
                                                <h4 class="widget-title lighter smaller">Filas Geneadas <span id="datosActualTXTidrollo"></span></h4>
                                            </div>

                                            <div class="widget-body">
                                                <div  class="centro" id="centro">
                                                <div class="widget-main padding-8">
                                                    <!--<ul id="tree1"></ul>  con javascrip--> 

                                                  
                                                    
                                                    <div id="mostrarfilas" >
                                                        
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

<!--          <button type="button" class="btn btn-sm btn-primary" >
            <i class="ace-icon fa fa-check"></i>
            Salir
        </button>-->
    </div>
                    </div>
                </div>
            
            </div>
            <!-- Fin del modal acceso -->
            
      <script src="view/js/kanban.js"></script>      
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
                        null, null, null, null, null,null,null,null,null,null,
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

   $('#timepicker1').timepicker({
                                    minuteStep: 1,
                                    showSeconds: true,
                                    showMeridian: false,
                                    disableFocus: true,
                                    icons: {
                                        up: 'fa fa-chevron-up',
                                        down: 'fa fa-chevron-down'
                                    }
                                }).on('focus', function () {
                                    $('#timepicker1').timepicker('showWidget');
                                }).next().on(ace.click_event, function () {
                                    $(this).prev().focus();
                                });




                                if (!ace.vars['old_ie'])
                                    $('#date-timepicker1').datetimepicker({
                                        //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
                                        icons: {
                                            time: 'fa fa-clock-o',
                                            date: 'fa fa-calendar',
                                            up: 'fa fa-chevron-up',
                                            down: 'fa fa-chevron-down',
                                            previous: 'fa fa-chevron-left',
                                            next: 'fa fa-chevron-right',
                                            today: 'fa fa-arrows ',
                                            clear: 'fa fa-trash',
                                            close: 'fa fa-times'
                                        }
                                    }).next().on(ace.click_event, function () {
                                        $(this).prev().focus();
                                    });

    })
</script>



