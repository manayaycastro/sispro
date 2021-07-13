
                                                      <?php if (count($areas)): ?>
                                                            <?php foreach ($areas as $area): ?>
                                                                <tr>
                                                                    <td class="center">
                                                                        <label class="pos-rel">
                                                                            <input type="checkbox" class="ace" />
                                                                            <span class="lbl"></span>
                                                                        </label>
                                                                    </td>
                                                                    <td><?php echo $area ['are_id']; ?></td>
                                                                    <td><?php echo $area ['are_titulo']; ?></td>
                                                                    <?php if ($area ['are_estado'] == 0): ?>
                                                                        <td class="hidden-480">
                                                                            <span class="label label-sm label-success">Activo</span>
                                                                        </td>
                                                                    <?php else: ?>
                                                                        <td class="hidden-480">
                                                                            <span class="label label-sm label-warning">Inactivo</span>
                                                                        </td>
                                                                    <?php endif; ?>
                                                                    <td><?php echo $area ['fecha_creacion']; ?></td>
                                                                    <td>
                                                                        <div class="hidden-sm hidden-xs action-buttons">
                                                                            <a class="blue"
                                                                               onclick=" false" href="#" data-estado ="<?php echo $area ['are_id']; ?>" id="mostrar_form_area"
                                                                               >
                                                                                <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                                            </a>

                                                                            <a class="green" 
                                                                               onclick=" false" href="#" data-estado ="<?php echo $area ['are_id']; ?>" id="editar_form_area"
                                                                               >
                                                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                                            </a>

                                                                            <a class="red" 
                                                                               id="bootbox-confirm"
                                                                               onclick=" false" href="index.php?page=areas&accion=eliminar&id=<?php echo $area ['are_id']; ?>"
                                                                               >
                                                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                                            </a>
                                                                        </div>

                                                                        <div class="hidden-md hidden-lg">
                                                                            <div class="inline pos-rel">
                                                                                <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                                                    <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                                                </button>

                                                                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                                                    <li>
                                                                                        <a  class="tooltip-info" data-rel="tooltip" title="Ver detalle"

                                                                                            onclick=" false" href="#" data-estado ="<?php echo $area ['are_id']; ?>" id="mostrar_form_area"

                                                                                            >

                                                                                            <span class="blue">
                                                                                                <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                                            </span>
                                                                                        </a>
                                                                                    </li>

                                                                                    <li>
                                                                                        <a class="tooltip-info" data-rel="tooltip" title="Editar"

                                                                                           onclick=" false" href="#" data-estado ="<?php echo $area ['are_id']; ?>" id="editar_form_area"

                                                                                           >
                                                                                            <span class="green">
                                                                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                                                            </span>
                                                                                        </a>
                                                                                    </li>

                                                                                    <li>
                                                                                        <a class="tooltip-error" id="bootbox-confirm"
                                                                                           href="index.php?page=areas&accion=eliminar&id=<?php echo $area ['are_id']; ?>"  data-rel="tooltip" title="Eliminar">
                                                                                            <span class="red">
                                                                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                                                            </span>
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" id="id_<?php echo $area ['are_id']; ?>" name="id_<?php echo $area ['are_id']; ?>" value="<?php echo $area ['are_id']; ?>" />  
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else : ?>
                                                            <?php echo '<div class="alert alert-warning">No se encontraron registros.</div>'; ?>
                                                        <?php endif; ?>
                                                   