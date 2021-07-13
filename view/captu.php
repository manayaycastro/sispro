<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<script   src="js/capturatext.js"></script>

<script>
    
 
    
    
$(function() {
$("#button").click( function()
{

   var TXT_URL = $("#input-url").val();

    $.ajax (
    	{
        	url : TXT_URL,
			dataType: "text",
			success : function (data) 
			{
           //	$(".text").html("<pre>"+data+"</pre>");
                 var inputNombre = document.getElementById("prueba02");
    inputNombre.value = data;
			}
		}
	);
   });
});


$(function() {
    $('body').on('click', '#mostrar', function (e) {

   var TXT_URL = $("#input-url").val();

    $.ajax (
    	{
        	url : TXT_URL,
			dataType: "text",
			success : function (data) 
			{
           //	$(".text").html("<pre>"+data+"</pre>");
                 var inputNombre = document.getElementById("prueba03");
    inputNombre.value = data;
			}
		}
	);
   });
   
   
   
});



</script>
Ingrese una url válida:<input type="hidden" id="input-url" size="50" value="http://localhost:84/proyecto_produccion/data.txt"></input>

<input type="button" id="button" value="Ver .txt"></input>
<div class="text">
  <hr />
  <h2>Texto:</h2>
</div>
<br>

<input  id="prueba02" name="prueba02" value="">
<br>
<a href = '#' id="mostrar" name="mostrar" >Capturar</a>
<input  id="prueba03" name="prueba03" value="">

<input type= "text" id="prueba03" name="prueba03" value=" <?php echo 808%500 ?>">
