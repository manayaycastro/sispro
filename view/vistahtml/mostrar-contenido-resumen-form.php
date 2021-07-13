<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;


if (count($resumen)):
    ?>
    <?php foreach ($resumen as $lista): ?>
        <tr>
            <td>  <?php echo $lista['prefila_tipo']; ?></td>
             <td>  <?php echo $lista['total_sacos']; ?></td>
              <td>  <?php echo $lista['pendiente_enfardar']; ?></td>
        




        <!--aqui hoy ********************************************************************************-->

        </tr>


    <?php endforeach; ?>

<?php endif; ?>


?>
