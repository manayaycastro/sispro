<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;


if (count($listar)):
    ?>
    <?php foreach ($listar as $lista):  $a++;?>

        <tr>
            
            <td>  <?php echo $a; ?></td>
            <!--<td>  <?php // echo $lista ['are_titulo']; ?></td>-->
             <td>  <?php echo $lista ['maq_nombre']; ?></td>
              
              
                <td> 
                <center>
                    <label>
                <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                     src="view/img/loading.gif" class="loading-<?php echo $lista ['maq_id']; ?>" >
                <input type='checkbox' <?php echo $permiso?>   <?php if( $lista ['estado'] == '1'): ?>  checked="checked"   <?php else: ?> <?php endif;?>
                       class="ace" id="asignarmaqemp" data-estado="<?php echo $lista ['maq_id']; ?>" ><span class="lbl"></span>
                       <input type="hidden" id="id<?php echo $lista ['maq_id']; ?>" name="id<?php echo $lista ['maq_id']; ?>" value="<?php echo $lista ['maqcol_id'];?>" /> 
                    <input type="hidden" id="idmaq<?php echo $lista ['maq_id']; ?>" name="idmaq<?php echo $lista ['maq_id']; ?>" value="<?php echo $lista ['maq_id'];?>" /> 
                     <input type="hidden" id="idemp<?php echo $lista ['maq_id']; ?>" name="idemp<?php echo $lista ['maq_id']; ?>" value="<?php echo $id_emp; ?>" /> 
                     
            </label>
          
           
          

                </center>
                </td>
       




       

        </tr>


    <?php endforeach; ?>

<?php endif; ?>


?>