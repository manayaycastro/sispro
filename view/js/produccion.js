

$(document).on('ready', function () {
    
    
    	var gettiptubo = function(maquina){

		var options = {
			type: 'POST',
			url:'index.php?page=produccion&accion=ajaxGetTipTubo',
			data: {
				'maquina': maquina
			},
			dataType: 'html',
			success: function(response){

				$('#tip_tubo').removeAttr('disabled');
				$('#tip_tubo').html(response);
				
			}
		};
		$.ajax(options);

	};

	$('#maq_id').on('change', function(e){
		e.preventDefault();

		var maquina = $(this).val();

		if(maquina != -1){
			gettiptubo(maquina);			
		}else{
			$('#tip_tubo').attr('disabled', 'disabled');
			$('#tip_tubo').val('-1');
		}
	});
    
    
    
    $('body').on('click', '#extotpro', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');

        var extotpro = $(this).data('extotpro');
        var numcaja = $('#numcaja-' + extotpro).val();
        var barcode = $('#barcode-' + extotpro).val();
        
        
        var numbob = $('#numbob-' + extotpro).val();
         var peso = $('#pesomov-' + extotpro).val();
         
          var art = $('#art-' + extotpro).val();
          var tipdoc_id = $('#tipdoc_id').val();
          var are_id = $('#are_id').val();
          var extot_fecdoc = $('#extot_fecdoc').val();


       var carrito = $('#carrito-' + extotpro).val();
           var envase = $('#envase-' + extotpro).val(); 
           var tubo = $('#tip_tubo').val();
           
           
        if ((numcaja >= 0 && numbob>=0 && peso>=0)) {

            var loading = $(".loading-" + extotpro);
             checkboxClickeado.hide();
            loading.show();

            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";

            }

            var _options = {
                type: 'POST',
                url: 'index.php?page=produccion&accion=ajaxregistrarproduccion',
                data: {
                    'extotpro': extotpro,
                    'numcaja': numcaja,
                    'numbob': numbob,
                    'peso':peso,
                    'art':art,
                    'accion': accion,
                    'barcode':barcode,
                    'tipdoc_id' : tipdoc_id,
                    'are_id' : are_id,
                    'extot_fecdoc' : extot_fecdoc,
                     'carrito' : carrito,
                      'envase' : envase,
                       'tubo' : tubo
                },
                dataType: 'json',
                success: function (response) {




                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options);

        } else {

            alert("Debe Ingresar un valores  validos.") ? "" : location.reload();
        }


    });

 $('body').on('click', '#mostrar', function (e) {
     
      var id = $(this).data('estado');
        var mostrar = $('#mostrar-' + id).val();
        
     //   alert (id);
     

   var TXT_URL = $("#input-url").val();
   
   
    $.ajax (
    	{
        	url : TXT_URL,
			dataType: "text",
			success : function (data) 
			{
       
                 var inputNombre = document.getElementById("pesomov-"+id);
               
    inputNombre.value = data;
			}
		}
	);
   });


	var mostrarreg = $('#mostrarreg');
    var ajax_mostrar_pend_produc = $('#ajax_mostrar_pend_produc');
    $('#formlote').on('submit', function (e) { 
        e.preventDefault();
        
        var  codbarrainic = '0'+$('#codbarra').val();
        var codbarra = codbarrainic.substr(0,12);
        var movim = $('#movim').val();
        
        var codbarra_mostrar = $('#codbarra').val();
    
   // alert (codbarra);00000000010  000000001038  000000001038  000000001038

        mostrarreg.slideUp("slow", function () {


            var options = {
                type: 'POST',
                url: 'index.php?page=produccion&accion=ajaxGetMostrarsalidadet',
                data: {
                    'codbarra': codbarra,
                    'movim':movim,
                    'codbarra_mostrar':codbarra_mostrar
           
                },
                dataType: 'html',
                success: function (response) {
                    ajax_mostrar_pend_produc.html('');
            

                    ajax_mostrar_pend_produc.html(response);
                    mostrarreg.slideDown("slow");
                }
            };

            $.ajax(options);
        });

    });


   $('body').on('click', '#insertsalida', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');

        var insertsalida = $(this).data('insertsalida');
        
        
        var  codbarrainic = '0'+$('#codbarra').val();
        var barcode = codbarrainic.substr(0,12);
        
        
        
       // var barcode = $('#codbarra').val();
        var movim = $('#movim').val();
        
        var numcaja = $('#numcaja-' + insertsalida).val();
        var numbob = $('#numbob-' + insertsalida).val();
         var peso = $('#peso-' + insertsalida).val();
         
          var numcajamov = $('#numcajamov-' + insertsalida).val();
        var numbobmov = $('#numbobmov-' + insertsalida).val();
         var pesomov = $('#pesomov-' + insertsalida).val();
         
         
          var art = $('#art-' + insertsalida).val();
          var tipdoc_id = $('#tipdoc_id').val();
          var are_id = $('#are_id').val();
          var fecdoc = $('#fecdoc').val();


        var pesounitcaja = $('#pesounitcaja-' + insertsalida).val();
        var pesounittub = $('#pesounittub-' + insertsalida).val();
         var kanban = $('#kanban-' + insertsalida).val();
        var carro = $('#carro').val();

   
        if (( (numcaja-numcajamov )>= 0 && (numbob-numbobmov)>=0 && (pesomov)>=0 && carro != -1)) {

            var loading = $(".loading-" + insertsalida);
             checkboxClickeado.hide();
            loading.show();

            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";

            }

            var _options = {
                type: 'POST',
                url: 'index.php?page=produccion&accion=ajaxregistrarSalidProduc',
                data: {
                    'insertsalida': insertsalida,
                    'numcaja': numcaja,
                    'numbob': numbob,
                    'peso':peso,
                    
                    'numcajamov': numcajamov,
                    'numbobmov': numbobmov,
                    'pesomov':pesomov,
                    
                    'art':art,
                    'accion': accion,
                    'barcode':barcode,
                    'tipdoc_id' : tipdoc_id,
                    'are_id' : are_id,
                    'fecdoc' : fecdoc,
                    'movim':movim
                    
                    ,'pesounitcaja':pesounitcaja
                    ,'pesounittub':pesounittub
                    ,'carro':carro
                    ,'kanban':kanban
                },
                dataType: 'json',
                success: function (response) {




                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options);

        } else {

            alert("Los valores de movimiento deben ser menores o iguales al disponible") ? "" : location.reload();
        }


    });

    
      $('body').on('click', '#insertreingreso', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');

        var insertsalida = $(this).data('insertsalida');
        
        
//          var  codbarrainic = '0'+$('#codbarra').val();
//        var barcode = codbarrainic.substr(0,12);
        
//        var barcode = $('#codbarra').val();
        var movim = $('#movim').val();
        
        var numcaja = $('#numcaja-' + insertsalida).val();
        var numbob = $('#numbob-' + insertsalida).val();
         var peso = $('#peso-' + insertsalida).val();
         
          var numcajamov = $('#numcajamov-' + insertsalida).val();
        var numbobmov = $('#numbobmov-' + insertsalida).val();
         var pesomov = $('#pesomov-' + insertsalida).val();
         
         
          var art = $('#art-' + insertsalida).val();
           var barcode = $('#barra-' + insertsalida).val();
          
          
          var tipdoc_id = $('#tipdoc_id').val();
          var are_id = $('#are_id').val();
          var fecdoc = $('#fecdoc').val();
          
      

           var pesounitcaja = $('#pesounitcaja-' + insertsalida).val();
        var pesounittub = $('#pesounittub-' + insertsalida).val();
         var kanban = $('#kanban-' + insertsalida).val();
        var carro = $('#carro').val();
   
        if (( (numcajamov )>= 0 && (numbobmov)>=0 && (pesomov)>=0 && carro != -1)) {

            var loading = $(".loading-" + insertsalida);
             checkboxClickeado.hide();
            loading.show();

            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";

            }

            var _options = {
                type: 'POST',
                url: 'index.php?page=produccion&accion=ajaxregistrarReingProduc',
                data: {
                    'insertsalida': insertsalida,
                    'numcaja': numcaja,
                    'numbob': numbob,
                    'peso':peso,
                    
                    'numcajamov': numcajamov,
                    'numbobmov': numbobmov,
                    'pesomov':pesomov,
                    
                    'art':art,
                    'accion': accion,
                    'barcode':barcode,
                    'tipdoc_id' : tipdoc_id,
                    'are_id' : are_id,
                    'fecdoc' : fecdoc,
                    'movim':movim
                    ,'pesounitcaja':pesounitcaja
                    ,'pesounittub':pesounittub
                    ,'carro':carro
                    ,'kanban':kanban
                },
                dataType: 'json',
                success: function (response) {




                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options);

        } else {

            alert("Los valores de movimiento deben ser menores o iguales al disponible") ? "" : location.reload();
        }


    });

    

    var estructura_tabla_paradas = $('#estructura_tabla_paradas');
     var ajax_paradas = $('#ajax_paradas');
        
   $('#listar-paradas').on('submit', function(e){
		e.preventDefault();

		var desde = $('#desde').val(); var hasta = $('#hasta').val(); var area = $('#area').val();
		var area_text = $("#area option:selected").text();
            if(area != ''){

			estructura_tabla_paradas.slideUp("slow", function(){
var options = {
					type: 'POST',
					url:'index.php?page=produccion&accion=ajaxGetParadas',
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
