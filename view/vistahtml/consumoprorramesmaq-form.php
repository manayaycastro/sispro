<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;


if (count($listar)):
    ?>
    <?php foreach ($listar as $lista): ?>
        <tr>
            <td>  <?php echo $lista ['conmenpromaq_id']; ?></td>
            <td>  <?php echo $lista ['maq_nombre']; ?></td>

            <td>  

        <center>
            <div class="control-group " >

                <div class="controls">
                    <input type="text" required="required" style="width: 140px; height:32px"
                           class=" valormaq"  onkeyup="sumarmaq();" id = "valorporcentaje-<?php echo $lista ['conmenpromaq_id']; ?>"  
                           value="<?php echo round($lista ['conmenpromaq_valor'], 2); ?>" autocomplete="off" autofocus>
                </div>
            </div>
        </center>

        </td>
        <td> 
        <center>
            <label>
                <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                     src="view/img/loading.gif" class="loading-<?php echo $lista ['conmenpromaq_id']; ?>" >
                <input type='checkbox'  <?php if ($lista ['estado'] == '1'): ?>  checked="checked"  <?php else: ?> <?php endif; ?>
                       class="ace" id="updateporcmaq" data-estado="<?php echo $lista ['conmenpromaq_id']; ?>" ><span class="lbl"></span>

            </label>

        </center>
        </td>
       


        <!--aqui hoy ********************************************************************************-->

        </tr>


    <?php endforeach; ?>

<?php endif; ?>
        <tr >
            <td colspan ="2">
                ---------> Sumatoria Total
            </td>
            <td>
        <center>
                <div class="control-group " >
                <div class="controls">
                    <!--<span>El resultado es: </span> <span id="spTotal"></span>-->
                    
                     <input type="text" required="required" style="width: 140px; height:32px"
                            id = "sumamaq"  
                           autocomplete="off" autofocus>
                </div>
                    </div>
            </center>
            </td>
             <td colspan ="2">
            </td>
        </tr>

