<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;
?>


<?php ?>

<form  class="form-horizontal" role="form" name="formulariometa"
       action="index.php?page=maquinas&accion=insertarmeta<?php if (!empty($_POST["id"])) : ?>&id=<?php echo $_POST["id"];
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
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Máquina </label>

                                <div class="col-sm-9">

                                    <select name="maq_id" class="chosen-select form-control" <?php echo $permiso; ?> id="form-field-select-3" data-placeholder="Choose a State...">
                                        <?php if (count($maquinas)): ?>
                                                    <?php foreach ($maquinas as $item): ?>
                                                <option value="<?php echo $item ['maq_id'] ?>" <?php if (!empty($_POST["id"])):if ($item ['maq_id'] == $maquinameta->getMaq_id()): ?> selected <?php endif;
                                                                                                                             endif;
                                                        ?>>
                                                <?php echo $item['maq_nombre']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else : ?>

                                                <?php foreach ($maquinas as $item): ?>
                                                    <option value="<?php echo $item ['maq_id'] ?>" >
                                                    <?php echo $item ['maq_nombre']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                             <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> U. Med. </label>

                                <div class="col-sm-9">

                                    <select name="maqmet_unidadmed" class="form-control" <?php echo $permiso; ?> >
                                         <option value=-1 <?php if (!empty($_POST["id"])):if (-1 == $maquinameta->getMaqmet_unidadmed()): ?> selected <?php endif;
                                                                    endif;
                                                                    ?>>Seleccione und. medida</option>
                                                                    <option value='und' <?php if (!empty($_POST["id"])):if ('und' == $maquinameta->getMaqmet_unidadmed()): ?> selected <?php endif;
                                                                    endif;
                                                                    ?>>Unidades</option>
                                                                    <option value='kg' <?php if (!empty($_POST["id"])):if ('kg' == $maquinameta->getMaqmet_unidadmed()): ?> selected <?php endif;
                                                                    endif;
                                                                    ?>>Kilos</option>
                                                                    <option value='mtr' <?php if (!empty($_POST["id"])):if ('mtr' == $maquinameta->getMaqmet_unidadmed()): ?> selected <?php endif;
                                                                    endif;
                                                                ?>>Metros</option>
                                                                 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Año  </label>

                                <div class="col-sm-9">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="año" class="form-control"
                                           name="maqmet_anio"
                                           <?php if (!empty($_POST["id"])) : ?>
                                           value="<?php echo $maquinameta->getMaqmet_anio(); ?>"
                                           <?php else: ?>
                                           value="<?php echo date("Y"); ?>" readonly=""
                                               <?php endif; ?> <?php echo $permiso; ?>
                                           />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Meta  </label>

                                <div class="col-sm-9">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="valor meta mes" class="form-control"  <?php echo $permiso; ?>
                                           name="maqmet_valor"
                                           <?php if (!empty($_POST["id"])) : ?> value="<?php echo $maquinameta->getMaqmet_valor(); ?>"
                                           <?php else: ?>
                                           value=""
                                             <?php endif; ?>  
                                           />
                                </div>
                            </div>




                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Estado  </label>

                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input name="optionsRadios" type="radio"  <?php echo $permiso; ?>  value="0"  class="ace" checked />
                                            <span class="lbl"> Activo</span>
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input name="optionsRadios" type="radio"  <?php echo $permiso; ?>  value="1"  class="ace"  <?php if (!empty($_POST["id"])) : if ($maquinameta->getEstado() == 1): ?> checked <?php endif;
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

        <button class="btn btn-sm btn-primary" id="bootbox-confirm-meta"  <?php echo $permiso; ?>>
            <i class="ace-icon fa fa-check"></i>
            Guardar
        </button>
    </div>


</form>


