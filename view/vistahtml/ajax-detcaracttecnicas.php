   <?php
   require_once '../../model/articulocaractecnicas.php';  
   //require_once '../../model/artsemiterminado.php.php';  
  session_start();
  $art='';
    if(isset($_REQUEST['articulos'])) {
      $art=$_REQUEST['articulos'];        
    }    



//$area = new opedido();
//$areas = $area->consultar2($ini,$fin);

$artcaractecnicas = new articulocaractecnicas();
    $clasif =$artcaractecnicas->listaClasificacion();
    $clasif1 =$artcaractecnicas->listaClasificacion();
    //$items = $artcaractecnicas->listaItems();
    $items = $artcaractecnicas->consultaritemXtipoFinal($art);
 // $semiterm = new semiterminado();  
   // $registros = count($items);
   
   
   
   
   $a= 0;$b=0;$c=0; ?>     
<!--<form class="form-horizontal">-->
    <div class="tabbable">
        <ul class="nav nav-tabs padding-16">
        <?php if($clasif):?>
        
        <?php foreach ($clasif as $clasi):?>
            <?php $a= $a+1;?>     
            <li  <?php if($a==1):?>   class="active"<?php endif;?> >    
                <a data-toggle="tab" href="#edit-<?php echo $clasi['clasem_id'];?>">
                    <?php echo substr($clasi['clasem_titulo'],16);?>
                </a>
            </li>
        
        
        <?php endforeach;?>
        
        <?php endif;?>
            
            </ul>
        <!-- ----------------------------aqui comienza a listar los submenus  --------------------------------- -->
        <div class="tab-content profile-edit-tab-content">
  <?php  if($clasif1):?>
        
        <?php foreach ($clasif1 as $clas):?>
       <?php  $b= $b+1;?>
            <div id="edit-<?php echo $clas['clasem_id'];?>" class="tab-pane <?php if($b==1):?> in active  <?php endif;?>">
               
                   
                 
                    <h4 class="header blue bolder smaller"><?php echo $clas['clasem_titulo'];?></h4>
  
             
                <?php if($items): ?>
                <?php foreach ($items as $item): ?>
                   
                    <?php if($item['clasem_id'] == $clas['clasem_id']): ?>
             <?php $c = $c+1 ?>
                
                        <!--<div class="space-20"></div>-->
 
                        <!--<br>-->
                            
                        
                       
                           
                           
                           <?php  ?>
                  
                                 <?php if($c %2 != 0): ?>
                                 <div class="space-20"></div>
                                
                    <div class="col-sm-6">
                        
                        <div class="form-group">
                            <label class="col-sm-5 control-label no-padding-right" for="form-field-1-1">  <?php  echo $item["itemcaracsemi_descripcion"];?>  </label>
                            <div class="col-sm-7">
                                 <?php   if ($item['itemcaracsemi_tipodato'] == '_caja'):   ?>
                                <input  type="text" name="<?php echo $item["itemcaracsemi_id"];?>"  value="<?php  echo $item["valitemcarac_valor"]; ?>"  placeholder="Ingrese un valor" class="form-control" />
                               
                                <?php elseif($item['itemcaracsemi_tipodato'] == '_combo'): ?>
                              <?php      $listar = $artcaractecnicas->listacombo($item['itemcaracsemi_tabla'],  $art);?> 
                                
                                <select name=' <?php echo $item["itemcaracsemi_id"]; ?>' class='chosen-select form-control'  id=' <?php  echo  $item["itemcaracsemi_id"] ;?>' data-placeholder='Choose a State...'> 
                                             <option value='-1'>    Seleccione una opción  </option>;
                                                  <?php   if (count($listar)):?>
                                                     <?php    foreach ($listar as $lista):?>
                                                           <option value=" <?php echo $lista [$item['itemcaracsemi_tabla_id']];?> "
                                                                  <?php   if (!empty($item["valitemcarac_valor"])):?>
                                                                      <?php  if ( $lista [$item['itemcaracsemi_tabla_id']] == $item["valitemcarac_valor"]): ?> 
                                                                            selected  
                                                                      <?php   endif;?>
                                                                   <?php  endif;?>
                                                                           >
                                                                           
                                                                        <?php echo $lista[$item['itemcaracsemi_tabla_descripcion']];?>  
                                                           </option>

                                                    <?php    endforeach; ?>
                                           
                                                  <?php   endif;?>
                                                   </select>
                                
                             
                                 <?php endif; ?>
                                 
                                
                            </div>
                            
                        </div>
                        
                        
                         </div>
                        
                        
   
                              <?php else: ?> 
                              
                               <div class="col-sm-6">
                                   
                                     <div class="form-group">
                            <label class="col-sm-5 control-label no-padding-right" for="form-field-1-1">  <?php  echo $item["itemcaracsemi_descripcion"];?>  </label>
                            <div class="col-sm-7">
                                 <?php   if ($item['itemcaracsemi_tipodato'] == '_caja'):   ?>
                                <input  type="text" name="<?php echo $item["itemcaracsemi_id"];?>"  value="<?php  echo $item["valitemcarac_valor"]; ?>"  placeholder="Ingrese un valor" class="form-control" />
                               
                                <?php elseif($item['itemcaracsemi_tipodato'] == '_combo'): ?>
                              <?php      $listar = $artcaractecnicas->listacombo($item['itemcaracsemi_tabla'],  $art);?> 
                                
                                <select name=' <?php echo $item["itemcaracsemi_id"]; ?>' class='chosen-select form-control'  id=' <?php  echo  $item["itemcaracsemi_id"] ;?>' data-placeholder='Choose a State...'> 
                                             <option value='-1'>    Seleccione una opción  </option>;
                                                  <?php   if (count($listar)):?>
                                                     <?php    foreach ($listar as $lista):?>
                                                           <option value=" <?php echo $lista [$item['itemcaracsemi_tabla_id']];?> "
                                                                  <?php   if (!empty($item["valitemcarac_valor"])):?>
                                                                      <?php  if ( $lista [$item['itemcaracsemi_tabla_id']] == $item["valitemcarac_valor"]): ?> 
                                                                            selected  
                                                                      <?php   endif;?>
                                                                   <?php  endif;?>
                                                                           >
                                                                           
                                                                        <?php echo $lista[$item['itemcaracsemi_tabla_descripcion']];?>  
                                                           </option>

                                                    <?php    endforeach; ?>
                                           
                                                  <?php   endif;?>
                                                   </select>
                                
                             
                                 <?php endif; ?>
                                 
                                
                            </div>
                            
                        </div>
                        
                              </div>      

                    <div class="space-8"></div>
                         <?php endif; ?>        
               
                                 <div class="space-8"></div>
       


                     <?php endif; ?>
                       
                <?php endforeach; ?>
                <?php endif; ?>
                          
                           
           
            </div>

        <?php endforeach;?>
        
        <?php endif;?>
     </div>

    </div>

<!--    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button">
                <i class="ace-icon fa fa-check bigger-110"></i>
                Save
            </button>

            &nbsp; &nbsp;
            <button class="btn" type="reset">
                <i class="ace-icon fa fa-undo bigger-110"></i>
                Reset
            </button>
        </div>
    </div>
</form>-->