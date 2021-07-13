
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
                                                                                    
                                                                                    <div class="widget-toolbar hidden-240">
                                                                                        
                                                                                        <a id="clase" data-clase="<?php echo $op;?>" data-tipo="<?php echo 'Clase B';?>" class="btn btn-link">
														<i class="ace-icon fa fa-plus-circle bigger-120 red"></i>
														Agrupar Clase B
													</a>


                                                                                    </div>
                                                                                    
                                                                                    <div class="widget-toolbar hidden-240">
                                                                                       
                                                                                        <a id="clase" data-clase="<?php echo $op;?>" data-tipo="<?php echo 'Clase A';?>" class="btn btn-link">
														<i class="ace-icon fa fa-plus-circle bigger-120 geen"></i>
														 Agrupar Clase A
                                                                                                                 
													</a>


                                                                                    </div>
                                                                                </div>

                                                                                <div class="widget-body">
                                                                                    <div class="widget-main no-padding">
                                                                                        <table class="table table-bordered table-striped">
                                                                                            <input type="hidden" id="opedido" value="<?php echo $op;?>">
                                                                                            <thead class="thin-border-bottom">
                                                                                                <tr>
                                                                                                    <th>
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Items
                                                                                                    </th>
                                                                                                     <th class="hidden-480">
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Tipo
                                                                                                    </th>
                                                                                                     <th class="hidden-480">
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>OP (Kanban)
                                                                                                    </th>
                                                                                                    <th>
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Cantidad
                                                                                                    </th>

                                                                                                   
                                                                                                    <th class="hidden-480">
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Peso
                                                                                                    </th>
                                                                                                    
                                                                                                    <th class="hidden-480">
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Tipo (Clasif.)
                                                                                                    </th>
                                                                                                   
                                                                                                     <th class="hidden-480">
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Registrar
                                                                                                    </th>
                                                                                                    <th class="hidden-480">
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Imprimir
                                                                                                    </th>


                                                                                                </tr>
                                                                                            </thead>

                                                                                            <tbody>
                                                                                               <?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;


if (count($total)):
    ?>
    <?php foreach ($total as $lista): ?>
 <?php $a++; ?>
        <tr>
             <td>  <?php echo $a.'('.$lista['prefila_id'].')';?></td>
            <td>  <?php echo $lista['prefila_tipo']; ?></td>
             <td>  <?php echo $lista['prefila_op']. " (".$lista['prefila_kanban']. " )"; ?></td>
              <td>  <?php echo $lista['prefila_cantidad_ini']; ?></td>
            
            
               <td>  
                   <?php if($lista['prefila_peso']<= 0):?>
                <input type="text" id="peso-<?php echo $lista['prefila_id']; ?>" name="peso-<?php echo $lista['prefila_id']; ?>" >
                     <?php else:?> 
                <input type="text" disabled="disabled" id="peso-<?php echo $lista['prefila_id']; ?>" name="peso-<?php echo $lista['prefila_id']; ?>" value="<?php echo $lista['prefila_peso']; ?>" >  
                         
                    <?php endif;?>
                </td>  
              
                <td>
                
                <select  style="width: 120; height:32px" name="tipo-<?php echo $lista['prefila_id']; ?>" id="tipo-<?php echo $lista['prefila_id']; ?>">

							<?php if($lista['prefila_tipo']== 'Clase A'):?>
									<option value="1"> Clase A </option>
							<?php else:?>
									
                                  <option value="111"> Clase B </option>
                                   <option value="112"> Picar </option>
								     <option value="113"> Costura </option>
							
							<?php endif;?>
                       
                       
                            
                    </select>
                
                  <input type="hidden" name="codart-<?php echo $lista['prefila_id']; ?>" id="codart-<?php echo $lista['prefila_id']; ?>" value= "<?php echo $lista['codart']; ?>" >
                
                
                </td>
              
               <td> 
                  <label>
                     <img width="18px" height="18px" style="margin-top: -7px; display: none;" 
                    src="view/img/loading.gif" class="loading-<?php echo $lista['prefila_id']; ?>"> <input type="checkbox" 
                      <?php if($lista['prefila_peso']> 0):?>
                       
                    checked="checked"  disabled="disabled"
                       <?php endif;?>
                    class="ace ace-switch ace-switch-6" id="updateenfardado" data-prefila_id="<?php echo $lista['prefila_id']; ?>"><span class="lbl"></span>
                                   
                 </label>
            
               </td>
             
             
               <td>  <?php echo '' ?>
                    <center>
                         <?php if($lista['atendido']== '1'):?>
                        <a class="blue" onclick=" false" href="#" data-reporteetiq="<?php echo $lista['prefila_id']; ?>" id="reporteetiq" >
                                   
                                    <i class="ace-icon glyphicon glyphicon-file bigger-120"></i>
                                </a>
                           <?php else:?> 
                        <a class="red" onclick=" false" href="#" data-reporteetiq="<?php echo $lista['prefila_id']; ?>" id="" >
                                  
                                    <i class="ace-icon glyphicon glyphicon-file bigger-120"></i>
                                </a>
                        <?php endif;?>
                         
                
                    </center>
               </td>

     

        <!--aqui hoy ********************************************************************************-->

        </tr>


    <?php endforeach; ?>

<?php endif; ?>


 
                                                                                                
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div><!-- /.widget-main -->
                                                                                </div><!-- /.widget-body -->
                                                                            </div>



