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
            <td>  <?php echo $lista ['conmenproare_id']; ?></td>
            <td>  <?php echo $lista ['are_titulo']; ?></td>

            <td>  

        <center>
            <div class="control-group " >

                <div class="controls">
                    <input type="text" required="required" style="width: 140px; height:32px"
                           class=" valor"  onkeyup="sumar();" id = "valorporcentaje-<?php echo $lista ['conmenproare_id']; ?>"  
                           value="<?php echo round($lista ['conmenproare_valor'], 2); ?>" autocomplete="off" autofocus>
                </div>
            </div>
        </center>

        </td>
        <td> 
        <center>
            <label>
                <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                     src="view/img/loading.gif" class="loading-<?php echo $lista ['conmenproare_id']; ?>" >
                <input type='checkbox'  <?php if ($lista ['estado'] == '1'): ?>  checked="checked"  <?php else: ?> <?php endif; ?>
                       class="ace" id="prorratearmaquinas" data-estado="<?php echo $lista ['conmenproare_id']; ?>" ><span class="lbl"></span>
                <!--ACTUALIZAR VALOR DE PRORRATEO A CADA AREA-->
            </label>

        </center>
        </td>
        <td> 
        <center>
            
            <a class="orange" 
               onclick=" false" href="#" data-estado ="<?php echo $lista ['conmenproare_id']; ?>" id="conenermensual_maquinas" 
              
               >
                 <!--LISTAR MAQUINAS CORRSPONDIENTES A UNA AREA-->
                <i class="ace-icon fa fa-plus bigger-130"></i>
            </a>
            <input type="hidden" id="id_<?php echo $lista ['conmenproare_id']; ?>" name="id_<?php echo $lista ['conmenproare_id']; ?>" value="<?php echo $lista ['are_id']; ?>" /> 
                                                            

        </center>
        </td>


        <!--aqui hoy ********************************************************************************-->

        </tr>


    <?php endforeach; ?>

<?php endif; ?>
        <tr >
            <td colspan ="2">
                Total
            </td>
            <td>
        <center>
                <div class="control-group " >
                <div class="controls">
                    <!--<span>El resultado es: </span> <span id="spTotal"></span>-->
                    
                     <input type="text" required="required" style="width: 140px; height:32px"
                            id = "suma"  
                           autocomplete="off" autofocus>
                </div>
                    </div>
            </center>
            </td>
             <td colspan ="2">
            </td>
        </tr>

