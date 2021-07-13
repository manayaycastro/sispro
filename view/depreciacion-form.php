<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



if (count($maquinas)):
    ?>

    <?php foreach ($maquinas as $lista): ?>
        <tr>
            <td>  <?php echo $lista['maq_nombre']; ?></td>
            <td>  <?php echo round($lista['depresiacion_acumulada'],2); ?></td>
            <td>  <?php echo round($lista['depresiacion_residual'],2); ?></td>
            <td>  <?php echo round($lista['depresiacion_anual'],2); ?></td>
            <td>  <?php echo round($lista['depresiacion_mensual'],2); ?></td>

           



        <!--aqui hoy ********************************************************************************-->

        </tr>


    <?php endforeach; ?>

<?php endif; ?>


?>
