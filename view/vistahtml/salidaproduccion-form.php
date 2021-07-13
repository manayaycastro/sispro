<!-- <tr>
    <td colspan="8"> 
        <center><?php // echo $codbarra_mostrar;?></center>
        </td>
 </tr>-->
<?php  if($movim == 'salida'):?>


<?php

$a = 0;


if (count($listar)):
    ?>
    <?php foreach ($listar as $lista): ?>
       
        <tr>



            <td>  <?php echo $lista ['artlot_cajfinal']; ?></td>
            <td>  <?php echo $lista ['artlot_bobfinal']; ?></td>
            <td>  <?php echo $lista ['artlot_cantfinal']; ?> </td>
            
            <td>  <?php echo ( $lista ['artlot_cantfinal'])+($lista ['artlot_cajfinal']*$lista ['pesoenvase']) + ($lista ['artlot_bobfinal']*$lista ['pesotubo']); ?> </td>
            
            
            
            <td> 

                <center>
                    <div class="control-group " >

                        <div class="controls">
                            <input type="text" required="required" style="width: 140px; height:32px" <?php //  echo $permiso;  ?> 
                                   name ="numcajamov-<?php echo $lista['artlot_id']; ?>" id = "numcajamov-<?php echo $lista['artlot_id']; ?>"  
                                   value="<?php echo $lista ['artlot_cajfinal']; ?>" autocomplete="off" autofocus>
                        </div>
                    </div>
                </center>
            </td>



        <td>  
        <center>
            <div class="control-group " >

                <div class="controls">
                    <input type="text" required="required" style="width: 140px; height:32px" <?php //  echo $permiso;  ?> 
                           name ="numbobmov-<?php echo $lista['artlot_id']; ?>" id = "numbobmov-<?php echo $lista['artlot_id']; ?>"  
                           value="<?php echo $lista ['artlot_bobfinal']; ?>" autocomplete="off" autofocus>
                </div>
            </div>
        </center>
        </td>


        <td>  
        <center>
            <div class="control-group " >

                <div class="controls">
                    <input type="text" required="required" style="width: 140px; height:32px" <?php //  echo $permiso;  ?> 
                           name ="pesomov-<?php echo $lista['artlot_id']; ?>" id = "pesomov-<?php echo $lista['artlot_id']; ?>"  
                           value="<?php echo ( $lista ['artlot_cantfinal'])+($lista ['artlot_cajfinal']*$lista ['pesoenvase']) + ($lista ['artlot_bobfinal']*$lista ['pesotubo']); ?>" autocomplete="off" autofocus>
                </div>
            </div>
        </center>
        </td>


        <td> 
            <input type='hidden' id='input-url' size='50' value='http://localhost:84/proyecto_produccion/data.txt'></input>

            <input type='hidden' id='art-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo $lista['artsemi_id']; ?>'></input>
            <input type='hidden' id='tipdoc_id' size='50' value='5'></input>
            <input type='hidden' id='are_id' size='50' value='5'></input>
            <input type='hidden' id='fecdoc' size='50' value='<?php echo date("Y-m-d"); ?>'></input>


            <input type='hidden' id='numcaja-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo $lista ['artlot_cajfinal']; ?>'></input>
            <input type='hidden' id='numbob-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo $lista ['artlot_bobfinal']; ?>'></input>
            <input type='hidden' id='peso-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo $lista ['artlot_cantfinal']; ?>'></input>
            
            
            <input type='hidden' id='pesounitcaja-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo $lista ['pesoenvase']; ?>'></input>
            <input type='hidden' id='pesounittub-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo $lista ['pesotubo']; ?>'></input>
            <!--<input type='hidden' id='pesounitcarr-<?php // echo $lista['artlot_id']; ?>' size='50' value='<?php // echo $lista ['pesocarro']; ?>'></input>-->


            <a  class="btn btn-minier btn-yellow" enabled id="mostrar" data-estado = "<?php echo $lista['artlot_id']; ?>"     <?php if ($lista ['artlot_cantfinal'] <= '0.00'): ?>  disabled <?php endif; ?>>Capturar</a>

        </td>
        
        <td> 

                <center>
                    <div class="control-group " >

                        <div class="controls">
                          
                            <select name="carro" id="carro" required="required">
                                <option value="-1"></option>
                                  <?php if($listacarro): ?>
                             <?php foreach ($listacarro as $list):?>
                                <option value=" <?php echo $list['pespro_peso'];?> ">
                                    <!--validar, mostrare el peso del carro para no rrecorrerlo con un foreach en el controlador pespro_id-->
                                     <?php echo $list['pespro_descripcion'];?>
                                </option>
                                <?php endforeach; ?> 
                             <?php endif; ?>
                            </select>
                             
                        </div>
                    </div>
                </center>
            </td>
            
            
            
            <td> 

                <center>
                    <div class="control-group " >

                        <div class="controls">
                            <input type="text"  style="width: 140px; height:32px" <?php //  echo $permiso;  ?> 
                                   name ="kanban-<?php echo $lista['artlot_id']; ?>" id = "kanban-<?php echo $lista['artlot_id']; ?>"  
                                   value="" autocomplete="off" autofocus>
                        </div>
                    </div>
                </center>
            </td>
        
        <td> 

            <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                 src="view/img/loading.gif" class="loading-<?php echo $lista ['artlot_id']; ?>" >
            <input name="switch-field-1" class="ace ace-switch ace-switch-6" type="checkbox" 
                   <?php if ($lista ['artlot_cantfinal'] <= '0.00'): ?>  disabled <?php endif; ?>
                   id="insertsalida" data-insertsalida="<?php echo $lista ['artlot_id']; ?>"

                   />
            <span class="lbl"></span>

        </td>



        </tr>
         <tr>
             <td> Producto:
                 </td> 
                 <td colspan="10"> 
                     <?php echo $lista['artsemi_descripcion']."(".$lista['artsemi_id'].")";?>
                 </td> 
          </tr>


    <?php endforeach; ?>

<?php endif; ?>
 
<?php  elseif ($movim == 'reingreso'):?>
        
    
        
        
<?php

$a = 0;


if (count($listar)):
    ?>
    <?php foreach ($listar as $lista): ?>
        <tr>



            <td>  <?php echo ($lista ['artlot_cajinicial'] -$lista ['artlot_cajfinal'] ); ?></td>
            <td>  <?php echo ($lista ['artlot_bobinicial']-   $lista ['artlot_bobfinal'] ); ?></td>
            <td>  <?php echo ( $lista ['artlot_cantinicial']-$lista ['artlot_cantfinal'] ); ?> </td>
            
             <td>  <?php echo ( ( $lista ['artlot_cantinicial']-$lista ['artlot_cantfinal'] ))+
                                (($lista ['artlot_cajinicial'] -$lista ['artlot_cajfinal'] )*$lista ['pesoenvase']) + 
                                (($lista ['artlot_bobinicial']-   $lista ['artlot_bobfinal'] )*$lista ['pesotubo']); ?> </td>
            
            <td> 

                <center>
                    <div class="control-group " >

                        <div class="controls">
                            <input type="text" required="required" style="width: 140px; height:32px" <?php //  echo $permiso;  ?> 
                                   name ="numcajamov-<?php echo $lista['artlot_id']; ?>" id = "numcajamov-<?php echo $lista['artlot_id']; ?>"  
                                   value="<?php echo ( $lista ['artlot_cajinicial']-$lista ['artlot_cajfinal']  ); ?>" autocomplete="off" autofocus>
                        </div>
                    </div>
                </center>
            </td>



        <td>  
        <center>
            <div class="control-group " >

                <div class="controls">
                    <input type="text" required="required" style="width: 140px; height:32px" <?php //  echo $permiso;  ?> 
                           name ="numbobmov-<?php echo $lista['artlot_id']; ?>" id = "numbobmov-<?php echo $lista['artlot_id']; ?>"  
                           value="<?php echo ($lista ['artlot_bobinicial']-$lista ['artlot_bobfinal'] ); ?>" autocomplete="off" autofocus>
                </div>
            </div>
        </center>
        </td>


        <td>  
        <center>
            <div class="control-group " >

                <div class="controls">
                    <input type="text" required="required" style="width: 140px; height:32px" <?php //  echo $permiso;  ?> 
                           name ="pesomov-<?php echo $lista['artlot_id']; ?>" id = "pesomov-<?php echo $lista['artlot_id']; ?>"  
                           value="<?php echo ( ( $lista ['artlot_cantinicial']-$lista ['artlot_cantfinal'] ))+
                                (($lista ['artlot_cajinicial'] -$lista ['artlot_cajfinal'] )*$lista ['pesoenvase']) + 
                                (($lista ['artlot_bobinicial']-   $lista ['artlot_bobfinal'] )*$lista ['pesotubo']); ?>" autocomplete="off" autofocus>
                </div>
            </div>
        </center>
        </td>


        <td> 
            <input type='hidden' id='input-url' size='50' value='http://localhost:84/proyecto_produccion/data.txt'></input>

            <input type='hidden' id='art-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo $lista['artsemi_id']; ?>'></input>
            <input type='hidden' id='tipdoc_id' size='50' value='3'></input>
            <input type='hidden' id='are_id' size='50' value='5'></input>
          
            <input type='hidden' id='fecdoc' size='50' value='<?php echo date("Y-m-d"); ?>'></input>


            <input type='hidden' id='numcaja-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo ( $lista ['artlot_cajfinal']); ?>'></input>
            <input type='hidden' id='numbob-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo ($lista ['artlot_bobfinal']); ?>'></input>
            <input type='hidden' id='peso-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo ($lista ['artlot_cantfinal']); ?>'></input>

             <input type='hidden' id='pesounitcaja-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo $lista ['pesoenvase']; ?>'></input>
            <input type='hidden' id='pesounittub-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo $lista ['pesotubo']; ?>'></input>
             <input type='hidden' id='barra-<?php echo $lista['artlot_id']; ?>' size='50' value='<?php echo $lista ['artlot_numerolot']; ?>'></input>
            <a  class="btn btn-minier btn-yellow" enabled id="mostrar" data-estado = "<?php echo $lista['artlot_id']; ?>"     <?php if (( $lista ['artlot_cantinicial'] -$lista ['artlot_cantfinal'] ) <= '0.00'): ?>  disabled <?php endif; ?>>Capturar</a>

        </td>
        
        
        <td> 

                <center>
                    <div class="control-group " >

                        <div class="controls">
                          
                            <select name="carro" id="carro" required="required">
                                <option value="-1"></option>
                                  <?php if($listacarro): ?>
                             <?php foreach ($listacarro as $list):?>
                                <option value=" <?php echo $list['pespro_peso'];?> ">
                                    <!--validar, mostrare el peso del carro para no rrecorrerlo con un foreach en el controlador pespro_id-->
                                     <?php echo $list['pespro_descripcion'];?>
                                </option>
                                <?php endforeach; ?> 
                             <?php endif; ?>
                            </select>
                             
                        </div>
                    </div>
                </center>
            </td>
            
            
            
            <td> 

                <center>
                    <div class="control-group " >

                        <div class="controls">
                            <input type="text"  readonly="readonly" style="width: 140px; height:32px" <?php //  echo $permiso;  ?> 
                                   name ="kanban-<?php echo $lista['artlot_id']; ?>" id = "kanban-<?php echo $lista['artlot_id']; ?>"  
                                   value="0" autocomplete="off" autofocus>
                        </div>
                    </div>
                </center>
            </td>
        <td> 

            <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                 src="view/img/loading.gif" class="loading-<?php echo $lista ['artlot_id']; ?>" >
            <input name="switch-field-1" class="ace ace-switch ace-switch-6" type="checkbox" 
                   <?php if (( $lista ['artlot_cantinicial']-$lista ['artlot_cantfinal'] ) <= '0.00'): ?>  disabled <?php endif; ?>
                   id="insertreingreso" data-insertsalida="<?php echo $lista ['artlot_id']; ?>"

                   />
            <span class="lbl"></span>

        </td>
        
        <td>
             <center>
            <a class='blue' onclick='false' target='_blank' href="index.php?page=extordentrabajo&accion=reporteext&idpro=<?php echo $lista ['artlot_numerolot']; ?>"><i class='ace-icon fa fa-print bigger-130'></i></a>
             </center>
        </td>



        </tr>


    <?php endforeach; ?>

<?php endif; ?>
 
        
        
        
        
<?php endif; ?>

