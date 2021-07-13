    <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
     <script src="assets/js/bootbox.js"></script>
<div class="col-sm-12" id="actualizarlistakanban">
                <div class="widget-box">
                        <div class="widget-header">
                                <h4 class="widget-title lighter smaller">
                                        <i class="ace-icon fa fa-comment blue"></i>
                                        Lista Kanban
                                </h4>
                         
                            <div class="widget-toolbar hidden-480">
                           Click para  Imprimir toda la orden <?php echo $op; ?>
                           <a class="btn btn-app btn-light btn-xs" target='_blank' 
                           href="index.php?page=kanban&accion=mostrarkanbanXop&opedido=<?php echo  $op; ?>&semi_id=<?php echo $artsemi; ?>">
                           
                               <i class="ace-icon fa fa-print bigger-160"></i>
                               Print
                           </a>
                           
<!--                           <a href="#"> glyphicon-signal
                                    <i class="ace-icon fa fa-print"></i>
                                </a>-->
                            </div>
                            
                               <div class="widget-toolbar hidden-480">
                          Rotulos de la orden de pedido número: <?php echo $op; ?>
                           <a class="btn btn-app btn-light btn-xs" target='_blank'
                            href="index.php?page=kanban&accion=mostrarRotul&opedido=<?php echo  $op; ?>&semi_id=<?php echo $artsemi; ?>"
                           >
                               <i class="ace-icon fa fa-bar-chart-o bigger-160"></i>
                               Ver
                           </a>
                           
<!--                           <a href="#">
                                    <i class="ace-icon fa fa-print"></i>
                                </a>-->
                            </div>
                        </div>
                    <input type="hidden" name="op" id="op" value="<?php echo $op; ?>">
                      <input type="hidden" name="codart" id="codart" value="<?php echo $codart; ?>">
                       <input id="proceso" type="hidden" name="proceso" value="<?php echo $proceso; ?>" >
                       <input id="estado" type="hidden" name="estado" value="<?php echo $estado; ?>" >
                        <input id="area" type="hidden" name="area" value="<?php echo $area; ?>" >
                   
                        <div class="widget-body">
                                <div class="widget-main no-padding">
                                        <div class="dialogs">
                                               
                                                   <table class="table table-bordered table-striped">
                                        <thead class="thin-border-bottom">
                                                <tr>
                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Items
                                                        </th>
                                                        
                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i> Pedido(Kanban)
                                                        </th>
                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Metros
                                                        </th>

                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Telar
                                                        </th>
                                                        
                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Fec Inicio
                                                        </th>
                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Fec Fin
                                                        </th>
                                                        
                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Asignar Telar
                                                        </th>
                                                   
                                                     
                                                        
<!--                                                        <th class="hidden-480">
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Asignar
                                                        </th>-->
                                                       
                                                        
                                                        <th class="hidden-480">
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Imprimir
                                                        </th>
                                                </tr>
                                        </thead>

                                        <tbody>
                                         
                                                
                                                <?php  if ($listakanban):?>
                                                 <?php foreach ($listakanban as $lista) : ?>
                                                 <tr>
                                                        <td> <?php echo $lista ["prokandet_items"];?></td>
                                                         <td> <?php echo $lista ["prokandet_nroped"]." (". $lista ["prokandet_id"].")";?>
                                                         <?php if ($lista ["prokandet_tipo"] == 'saco'):?>
																  <span class="label label-success arrowed-in arrowed-in-right"><?php echo $lista ["prokandet_tipo"];?></span>
                                                         <?php else:?>
																 <span class="label label-danger arrowed"><?php echo $lista ["prokandet_tipo"];?></span>
                                                         <?php endif;?>
                                                       
                                                         </td>
                                                        <td>
                                                            
                                                                <b class="blue">    <?php echo $lista ["prokandet_mtrs"];?></b>
                                                        </td>
                                                        
                                                        <td>
                                                            <b class="blue"> <input type="text" readonly="readonly" id="telar-<?php echo $lista ['prokandet_id']; ?>" name="telar-<?php echo $lista ['prokandet_id']; ?>" value="<?php echo $lista ["maq_nombre"];?>"></b> 
                                                        </td>
                                                        <td>
                                                               <b class="blue">   <input type="text" readonly="readonly" id="fecinic-<?php echo $lista ['prokandet_id']; ?>" name="fecinic-<?php echo $lista ['prokandet_id']; ?>" value="<?php echo $lista ["movdismaq_fecinicio"];?>"></b> 
                                                        </td>
                                                        <td>
                                                               <b class="blue">   <input type="text" readonly="readonly" id="fecfin-<?php echo $lista ['prokandet_id']; ?>" name="fecfin-<?php echo $lista ['prokandet_id']; ?>" value="<?php echo $lista ["movdismaq_fecfin"];?>"></b> 
                                                        </td>
                                                        
                                                        <td>
                                                               <center>  <a class="btn btn-minier btn-yellow"
                                                                  onclick=" false" href="#" data-listartelares="<?php echo $lista ['prokandet_id']; ?>" id="mostrarlistTelares"           
                                                                            
                                                                            >asignar</a></center> 
                                         <input type="hidden" name="mtrs-<?php echo  $lista ['prokandet_id']; ?>" id="mtrs-<?php echo  $lista ['prokandet_id']; ?>" value="<?php echo $lista ["prokandet_mtrs"]; ?>">
                                         <input type="hidden" name="artsemi-<?php echo  $lista ['prokandet_id']; ?>" id="artsemi-<?php echo  $lista ['prokandet_id']; ?>" value="<?php echo $lista ["artsemi_id"]; ?>">
                                           <input type="hidden" name="items-<?php echo  $lista ['prokandet_id']; ?>" id="items-<?php echo  $lista ['prokandet_id']; ?>" value="<?php echo $lista ["prokandet_items"]; ?>">
                                           <input type="hidden" name="tipo-<?php echo  $lista ['prokandet_id']; ?>" id="tipo-<?php echo  $lista ['prokandet_id']; ?>" value="<?php echo $lista ["prokandet_tipo"]; ?>">
               </td>
                                                       
                                                      

                                                       
                                                        <td>  
                                                           
                      <center>
            <a class='blue' onclick='false' 
            <?php if($lista ["maq_nombre"] != null): ?>
            
            target='_blank' 
            <?php if($lista ["prokandet_tipo"] == 'saco'): ?>
            href="index.php?page=kanban&accion=mostrarkanban&idkanban=<?php echo  $lista['prokandet_id']; ?>&semi_id=<?php echo  $lista['artsemi_id']; ?>"
             <?php else: ?>
              href="index.php?page=kanban&accion=mostrarkanbanparc&idkanban=<?php echo  $lista['prokandet_id']; ?>&semi_id=<?php echo  $lista['artsemi_id']; ?>"
            
             <?php endif; ?>
             >
            <?php endif; ?>
            <i class='ace-icon fa fa-print bigger-130'></i>
            </a>
             </center>                                    
                                                        </td>
                                                </tr>
                                                
                                                 <?php endforeach;?>
                                                 <?php endif; ?>
                                               

                                               
                                        </tbody>
                                </table>
                                        </div>


                                   
                                </div><!-- /.widget-main -->
                        </div><!-- /.widget-body -->
                </div><!-- /.widget-box -->
</div>

