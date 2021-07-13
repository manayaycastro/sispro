<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;


if ($ocupacion):
    ?>
    <?php foreach ($ocupacion as $lista): ?>
        <tr>
            <td>  <?php echo $lista ['movdismaq_numped']." (".$lista ['movdismaq_idkanban'].")"; ?></td>
             <?php  $fecha_inicio = new DateTime($lista ['movdismaq_fecinicio']); ?>
               <?php  $nueva_fecha_inicio =$fecha_inicio->format('Y-m-d H:i'); ?>
               
                 <?php   $fecha_fin = new DateTime($lista ['movdismaq_fecfin']);?>
                   <?php  $nueva_fecha_fin = $fecha_fin->format('Y-m-d H:i'); ?>
            
            <td>  <?php echo$nueva_fecha_inicio; ?></td>
            <td>  <?php  echo $nueva_fecha_fin; ?></td>
            <td>  <?php echo $lista ['movdismaq_tiempo']; ?></td>
            <td>  <?php echo $lista ['movdismaq_mtrs']; ?></td>
            <td>  <?php echo $lista ['movdismaq_atendido']; ?></td>
             <td> 
				 
				   <?php    $cuerpo =[];
				   $kanban = new kanban();
				
					     $datos = $kanban->consultarTramaUrd( $lista ['artsemi_id'], $lista ['prokandet_tipo']);
				  
				   //$datos = $kanban->consultarTramaUrd( $lista ['artsemi_id']);

?> 
                
                 <?php // echo $lista ['movdismaq_id']; ?>
                <div class="inline dropdown-hover">
                                        <a class="btn btn-minier btn-primary">
                                                Kanban Det.
                                                <i class="ace-icon fa fa-angle-down icon-on-right bigger-110"></i>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-right dropdown-125 dropdown-lighter dropdown-close dropdown-caret">
                                            <li>
                                                        <a >
                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                                                <?php echo $lista ['codart']; ?> (Cliente)
                                                        </a>
                                                </li>    
                                            
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
                                                                <?php echo $lista ['movdismaq_tipoocupacion']; ?> (Tipo de Ocupación)
                                                        </a>
                                                </li>
                                                
                                                <li>
                                                        <a >
                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                                                <?php echo $datos ['1']; ?> (Denier trama)
                                                        </a>
                                                </li>
                                                
                                                <li>
                                                        <a >
                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
                                                                <?php echo $datos ['2']; ?> (Denier Urdimbre)
                                                        </a>
                                                </li>

                                                

                                        </ul>
                                 </div>
             
             
             
             </td>


           

        </tr>


    <?php endforeach; ?>
                                 <?php else : ?>
        <tr>
            <td colspan="7">
                                <?php echo '<div class="alert alert-warning">No se encontraron coincidencias.</div>'; ?>

            </td>  
        </tr>
            
<?php endif; ?>
 

