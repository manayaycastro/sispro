<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;
?>


<?php ?>

<form  class="form-horizontal" role="form" name="formularioconsumomes"
       action="index.php?page=consumoenergia&accion=insertar<?php if (!empty($_POST["id"])) : ?>&id=<?php echo $_POST["id"];
endif;
?>" method="POST">

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
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1"> Año  </label>

                                <div class="col-sm-8">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="año" class="form-control"
                                           name="conener_anio"
                                           <?php if (!empty($_POST["id"])) : ?>
                                           value="<?php echo $consumomes->getConener_anio() ; ?>"
                                           <?php else: ?>
                                           value="<?php echo date("Y"); ?>" 
                                               <?php endif; ?> readonly
                                           />
                                </div>
                            </div>
                            
                            
                             <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1"> Mes </label>

                                <div class="col-sm-8">

                                    <select name="conener_mes" class="form-control" <?php echo $permiso; ?> required="required">
                                         <option value=-1 <?php if (!empty($_POST["id"])):if (-1 == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled"<?php endif;
                                                                    endif;
                                                                    ?>>Seleccione und. medida</option>
                                                                    <option value='1' <?php if (!empty($_POST["id"])): if ('1' == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled" <?php endif;
                                                                    endif;
                                                                    ?>>Enero</option>
                                                                    <option value='2' <?php if (!empty($_POST["id"])):if ('2' == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled" <?php endif;
                                                                    endif;
                                                                    ?>>Febrero</option>
                                                                    <option value='3' <?php if (!empty($_POST["id"])):if ('3' == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled"<?php endif;
                                                                    endif;
                                                                ?>>Marzo</option>
                                                                     <option value='4' <?php if (!empty($_POST["id"])):if ('4' == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled" <?php endif;
                                                                    endif;
                                                                ?>>Abril</option>
                                                                 
                                                                      <option value='5' <?php if (!empty($_POST["id"])):if ('5' == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled" <?php endif;
                                                                    endif;
                                                                ?>>Mayo</option>
                                                                 
                                                                       <option value='6' <?php if (!empty($_POST["id"])):if ('6' == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled" <?php endif;
                                                                    endif;
                                                                ?>>Junio</option>
                                                                 
                                                                        <option value='7' <?php if (!empty($_POST["id"])):if ('7' == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled" <?php endif;
                                                                    endif;
                                                                ?>>Julio</option>
                                                                 
                                                                         <option value='8' <?php if (!empty($_POST["id"])):if ('8' == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled" <?php endif;
                                                                    endif;
                                                                ?>>Agosto</option>
                                                                 
                                                                          <option value='9' <?php if (!empty($_POST["id"])):if ('9' == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled" <?php endif;
                                                                    endif;
                                                                ?>>Septiembre</option>
                                                                 
                                                                           <option value='10' <?php if (!empty($_POST["id"])):if ('10' == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled" <?php endif;
                                                                    endif;
                                                                ?>>Octubre</option>
                                                                 
                                                                            <option value='11' <?php if (!empty($_POST["id"])):if ('11' == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled" <?php endif;
                                                                    endif;
                                                                ?>>Noviembre</option>
                                                                            
                                                                            <option value='12' <?php if (!empty($_POST["id"])):if ('12' == $consumomes->getConener_mes()): ?> selected 
                                                                               <?php else: ?> 
                                                                                disabled="disabled" <?php endif;
                                                                    endif;
                                                                ?>>Diciembre</option>
                                                                 
                                                                 
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1"> Importe  </label>

                                <div class="col-sm-8">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="valor meta mes" class="form-control"  <?php echo $permiso; ?>
                                           name="conener_valorimp"
                                           <?php if (!empty($_POST["id"])) : ?> value="<?php echo $consumomes->getConener_valorimp() ; ?>"
                                           <?php else: ?>
                                           value=""
                                             <?php endif; ?>  
                                           />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1"> Consumo(Kwhats)  </label>

                                <div class="col-sm-8">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="valor meta mes" class="form-control"  <?php echo $permiso; ?>
                                           name="conener_valorcon"
                                           <?php if (!empty($_POST["id"])) : ?> value="<?php echo $consumomes-> getConener_valorcon(); ?>"
                                           <?php else: ?>
                                           value=""
                                             <?php endif; ?>  
                                           />
                                </div>
                            </div>




                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1"> Estado  </label>

                                <div class="col-sm-8">
                                    <div class="radio">
                                        <label>
                                            <input name="optionsRadios" type="radio"  <?php echo $permiso; ?>  value="0"  class="ace" checked />
                                            <span class="lbl"> Activo</span>
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input name="optionsRadios" type="radio"  <?php echo $permiso; ?>  value="1"  class="ace"  <?php if (!empty($_POST["id"])) : if ($consumomes->getEstado() == 1): ?> checked <?php endif;
endif; ?>/>
                                            <span class="lbl"> Inactivo</span>
                                        </label>
                                    </div>
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
        <a class="btn btn-sm" data-dismiss="modal">
            <i class="ace-icon fa fa-times"></i>
            Cancelar
        </a>

        <button class="btn btn-sm btn-primary" id="bootbox-confirm-insercion"  <?php echo $permiso; ?>>
            <i class="ace-icon fa fa-check"></i>
            Guardar
        </button>
    </div>


</form>


