<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.0.4.js"></script>
<script>
      $(document).ready(function () {
          $("#texto1").keyup(function () {
              var value = $(this).val();
              $("#texto2").val(value);
          });
      });
</script>

</head>
<body>
  <input type="text" id="texto1" value=""/><br>
  <?php $dias_bucle = floor (47.7/24);
  
  $restio =  (47.7 %24);
  
   $tiempo_decimal =  round (floatval( 3 ),2);
   $hora_segunda = gmdate('H:i:s', floor(0.6 * 3600));
  echo "$dias_bucle";  echo "/";  echo "$restio";echo "/";  echo "$tiempo_decimal";echo "/";  echo "$hora_segunda";
  
  echo "/777777777/";
  echo " $dias_bucle$restio";
  ?>
 <input type="text" id="texto2" value=""/>
</body>
</html>