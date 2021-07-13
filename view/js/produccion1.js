

$(document).on('ready', function () {


    var estructura_tabla_paradas = $('#estructura_tabla_paradas');
     var ajax_paradas = $('#ajax_paradas');
        
   $('#listar-paradas').on('submit', function(e){
		e.preventDefault();

		var desde = $('#desde').val();
		var hasta = $('#hasta').val();
                var area = $('#area').val();
		var area_text = $("#area option:selected").text();



		if(area != ''){

			estructura_tabla_paradas.slideUp("slow", function(){

			var options = {
					type: 'POST',
					url:'index.php?page=produccion&accion=ajaxGetParadas2',
					data: {
						'desde': desde,
                                                'hasta': hasta,
                                                'area': area,
                                                'area_text': area_text
					},
					dataType: 'html',
					success: function(response){
                                            
                                              ajax_paradas.html('');
						
						ajax_paradas.html(response);
						estructura_tabla_paradas.slideDown("slow");
					}
				};			

				$.ajax(options);



			});


		}else{
			alert("Debe seleccionar un área válida.");

		}




	});

});