<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;


if (count($maquinas)):
    ?>
    <?php foreach ($maquinas as $maquina): ?>
        <tr>
            <td>  <?php echo $maquina ['maq_id']; ?></td>
            <td>  <?php echo $maquina ['maq_nombre']; ?></td>



        <td> 
          


               
                    <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                     src="view/img/loading.gif" class="loading-<?php echo  $maquina ['maq_id']; ?>" >
                    <input name="switch-field-1" class="ace ace-switch ace-switch-6" type="checkbox" 
                           <?php if ($maquina ['artsemimaq_id'] > '0'): ?> checked="checked" <?php else: ?> <?php endif; ?>
                           id="maqsemit" data-maqsemi="<?php echo  $maquina ['maq_id']; ?>"
                           
                           />
                    <span class="lbl"></span>

             
      
            <input type="hidden" name="semi-<?php echo $maquina ['maq_id']; ?>" id="semi-<?php  echo $maquina ['maq_id']; ?>" value="<?php echo $idfinal; ?>" />
             <input type="hidden" name="asig_maq_semi-<?php echo $maquina ['maq_id']; ?>" id="asig_maq_semi-<?php  echo $maquina ['maq_id']; ?>" value="<?php echo $maquina ['artsemimaq_id']; ?>" />
            <input type="hidden"  name ="numcintas-<?php echo $maquina ['maq_id']; ?>" id = "numcintas-<?php echo $maquina ['maq_id']; ?>"    value="<?php echo $maquina ['artsemimaq_numbob']; ?>" />
            
            
            
            
            

        </td>
        <!--aqui hoy ********************************************************************************-->

        </tr>


    <?php endforeach; ?>

<?php endif; ?>
 

