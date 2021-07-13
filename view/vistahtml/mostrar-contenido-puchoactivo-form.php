<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;


if (count($pucho)):
    ?>
    <?php foreach ($pucho as $lista): ?>
        <tr>
            <td>  <?php echo $lista['prefila_tipo']; ?></td>
             <td>  <?php echo $lista['prefila_cantidad_ini']; ?></td>
              <td>  <?php echo $lista['prefila_cantidad_fin']; ?></td>
        




        <!--aqui hoy ********************************************************************************-->

        </tr>


    <?php endforeach; ?>

<?php endif; ?>


?>
