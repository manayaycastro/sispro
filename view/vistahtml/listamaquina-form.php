<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;


if (count($semiterminado_maquina)):
    ?>
    <?php foreach ($semiterminado_maquina as $maquina): ?>
        <tr>
            <td>  <?php echo $maquina ['maq_id']; ?></td>
            <td>  <?php echo $maquina ['maq_nombre']; ?></td>

<!--            <td>  

        <center>
            <div class="control-group " >

                <div class="controls">
                    <input type="text" required="required" style="width: 140px; height:32px" <?php //  echo $permiso; ?> 
                          name ="numcintas-<?php // echo $maquina ['maq_id']; ?>" id = "numcintas-<?php // echo $maquina ['maq_id']; ?>"  
                           value="<?php // echo $id; ?>" autocomplete="off" autofocus>
                </div>
            </div>
        </center>

        </td>-->


        <!--aqui hoy ********************************************************************************-->

        </tr>


    <?php endforeach; ?>

<?php endif; ?>
 

