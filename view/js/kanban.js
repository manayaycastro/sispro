/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).on('ready', function () {

    
    
$('body').on('click', '#prograkanban', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var idop = $(this).data('prograkanban');
     var idmetrosxrollo = $('#idmetrosxrollo-'+idop).val(); 
     var idlargocorte = $('#idlargocorte-'+idop).val(); 
     var idclaseb = $('#idclaseb-'+idop).val(); 
     var idcantped = $('#idcantped-'+idop).val();  
     
     var artsemi = $('#artsemi-'+idop).val(); //artsemi
    var ini = $('#ini').val();
       var fin = $('#fin').val();
       
        var idlargoparche = $('#idlargoparche-'+idop).val(); 

   if (  idmetrosxrollo > 0 && idlargocorte >0 ) {
            var loading = $(".loading-" + idop);
            checkboxClickeado.hide();
            loading.show();
$('#cargarplanif').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=kanban&accion=progkanban',
                data: {
                    'idop': idop,
                    'ini': ini,
                    'fin': fin,
                    'idmetrosxrollo':idmetrosxrollo,
                    'idlargocorte':idlargocorte,
                    'idclaseb':idclaseb,
                    'idcantped':idcantped,
                    'accion': accion,
                    'idlargoparche':idlargoparche,
                    'artsemi':artsemi
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
            
            
            .done(function (res) {
            $('#cargarplanif').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
            }else{
                // alert("") ? "" : location.reload(); 
                   bootbox.alert('No se adminten valores "0" (cero) para los metros por rollo y largo de corte, favor de revisar', function(){}); 
                
            }
    });
   
    
$('body').on('click', '#mostrarlistkanban', function (e) {
        e.preventDefault();

        var op = $(this).data('listakanban');


          var codart = $('#codart-'+op).val();
           var artsemi = $('#artsemi-'+op).val();
           
           var area = $('#area').val();
        var ver_listakanban = $('#ver_listakanban');

        var _options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxListarKanban',
            data: {
                'op': op,
                'codart':codart,
                'area':area,
                'artsemi':artsemi
               
            },
            dataType: 'html',
            success: function (response) {
                ver_listakanban.html('');


                $('#datosActualTXTop').val('');
                $('#datosActualTXTop').html(op);


                ver_listakanban.html(response);

                $('#modal-listakanban').modal('show');
            }
        };

        $.ajax(_options);

    });

$('body').on('click', '#idkanban', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var idkanban = $(this).data('idkanban');
         var op = $('#op').val(); 
     var telar = $('#maquina-'+idkanban).val(); 
   
    var ini = $('#ini').val();
       var fin = $('#fin').val();

 
            var loading = $(".loading-" + idkanban);
            checkboxClickeado.hide();
            loading.show();
$('#actualizarlistakanban').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=kanban&accion=InsertTelar',
                data: {
                    'idkanban': idkanban,
                     'op': op,
                    'ini': ini,
                    'fin': fin,
                    'telar':telar,
                    'accion': accion
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
            
            
            .done(function (res) {
            $('#actualizarlistakanban').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
    });
   
    $('body').on('click', '#progprocesos', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var id_kanban_det = $(this).data('progprocesos');

var fecha_programacion = $('#fec-' + id_kanban_det).val();

        var codart = $('#codart-' + id_kanban_det).val();
        
        var artsemi_id = $('#artsemi_id-' + id_kanban_det).val();
           var items = $('#items-' + id_kanban_det).val();
              var opedido = $('#opedido-' + id_kanban_det).val();
        
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();

   
            var loading = $(".loading-" + id_kanban_det);
            checkboxClickeado.hide();
            loading.show();
          
        
        $('#cargarproceso').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=kanban&accion=progprocesosGuardar',
                data: {
                    'id_kanban_det': id_kanban_det,
                    'ini': ini,
                    'fin': fin,
                    'fecha_programacion': fecha_programacion,
                    'procesos': procesos,
                    'estado': estado,
                    'accion': accion,
                    'codart':codart,
                    'artsemi_id':artsemi_id,
                    'items':items,
                    'opedido':opedido
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)



                    .done(function (res) {
                        $('#cargarproceso').html(res);
                    })



                    .fail(function () {
                        console.log("error");
                    })

                    .always(function () {
                        console.log("complete");
                    });
      
    });


$('body').on('click', '#asignarinic', function (e) {
        e.preventDefault();

        var propro_id = $(this).data('asignarinic');

        var guardariniproc = $('#guardariniproc');
        
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
         var area = $('#area').val();
          var maquina = $('#maquina').val();
                var items = $('#items-' + propro_id).val();
              var opedido = $('#opedido-' + propro_id).val();
        

        var _options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxInicProceso',
            data: {
                'propro_id': propro_id,
                'ini': ini,
                'fin': fin,
                'procesos':procesos,
                'estado':estado,
                'area':area,
                'maquina':maquina,
                  'items':items,
                    'opedido':opedido
               
            },
            dataType: 'html',
            success: function (response) {
                guardariniproc.html('');


                $('#datosActualTXTinicioproceso').val('');
                $('#datosActualTXTinicioproceso').html(propro_id);


                guardariniproc.html(response);

                $('#modal-asignarinic').modal('show');
//                    modalasignarinic.modal('show');
            }
        };

        $.ajax(_options);

    });


$('body').on('click', '#btnguardardatos', function(e){
		e.preventDefault();

        var propro_id = $('#propro_id').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
         var fecha_inicio = $('#id-date-picker-1').val();
        var hora_inicio = $('#timepicker1').val();
		 var area = $('#area').val();
		  var maquina = $('#maquina').val();
		  
		    var items = $('#items').val();
              var opedido = $('#opedido').val();
		//var observacion = $('#observacion').val().trim();

	$('#guardariniproc').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
          	

			var options = {
				type: 'POST',
				url:'index.php?page=kanban&accion=insertarinicio',
				data: {
					'propro_id': propro_id,
                                        'ini': ini,
                                        'fin': fin,
                                        'procesos':procesos,
                                        'estado':estado,
                                        'fecha_inicio':fecha_inicio,
                                        'hora_inicio':hora_inicio,
                                        'area':area,
                                        'maquina':maquina,
                                        'items':items,
										'opedido':opedido
				},
				dataType: 'html',
				success: function(response){
					
						
					 $('#modal-asignarinic').modal('hide');

					getLista(propro_id,ini,fin,procesos,estado,maquina);
				}
			};

			$.ajax(options)		
			
		.done(function (res) {
            $('#guardariniproc').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });




	});


var getLista = function(propro_id,ini,fin,procesos,estado,maquina){


		var options = {
			type: 'POST',
			url:'index.php?page=kanban&accion=ajaxGetListaInicProceso',
			data: {
				'propro_id': propro_id,
                                        'ini': ini,
                                        'fin': fin,
                                        'procesos':procesos,
                                        'estado':estado,
                                        'maquina':maquina
			},
			dataType: 'html',
			success: function(response){

					$('#cargarinicioproceso').html('');
					$('#cargarinicioproceso').html(response);
					$('#cargarinicioproceso').fadeIn('slow');
				
					
			}
		};

		$.ajax(options);				


	};

        
$('body').on('click', '#ingresaravance', function (e) {
        e.preventDefault();

        var proroll_id = $(this).data('ingresaravance');

        var guardaravanceproducc = $('#guardaravanceproducc');
        
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
         var maquina = $('#maquina').val();
        
         var mtrstotales = $('#mtrstotales-'+proroll_id).val();
         
           var items = $('#items-'+proroll_id).val();
             var opedido = $('#opedido-'+proroll_id).val();
             
                var acceso = $('#acceso-'+proroll_id).val();
        

        var _options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxFormRegisProducc',
            data: {
                'proroll_id': proroll_id,
                'ini': ini,
                'fin': fin,
                'procesos':procesos,
                'estado':estado,
                'mtrstotales':mtrstotales,
                'maquina':maquina,
                'items':items,
                 'opedido':opedido,
                 'acceso':acceso
               
            },
            dataType: 'html',
            success: function (response) {
                guardaravanceproducc.html('');


                $('#datosActualTXTinicioproceso').val('');
                $('#datosActualTXTinicioproceso').html(proroll_id);


                guardaravanceproducc.html(response);

                $('#modal-asignaravance').modal('show');
//                    modalasignarinic.modal('show');
            }
        };

        $.ajax(_options);

    });




$('body').on('click', '#btnguardardatosProdRollos', function(e){
		e.preventDefault();

        var proroll_id = $('#proroll_id').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
        
         var emp = $('#emp').val();
        var mtrslineales = $('#mtrslineales').val();
        var comentario = $('#comentario').val();
        var peso = $('#peso').val();
        
        var items = $('#items').val();
        var opedido = $('#opedido').val();
              var acceso = $('#acceso').val();
        
         var mtrsavance = $('#mtrsavance').val();
         
         if(mtrslineales>0 && emp>0){

  $('#actualizarListRollo').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>"); 

			var options = {
				type: 'POST',
				url:'index.php?page=kanban&accion=insertarProduccRollo',
				data: {
					'proroll_id': proroll_id,
                                        'ini': ini,
                                        'fin': fin,
                                        'procesos':procesos,
                                        'estado':estado,
                                        'emp':emp,
                                        'mtrslineales':mtrslineales,
                                        'comentario':comentario,
                                        'peso':peso,
                                        'mtrsavance':mtrsavance,
                                        'items':items,
										'opedido':opedido,
                                                                                'acceso':acceso
                                                                                
				},
				dataType: 'html',
				success: function(response){
					
						
//					 $('#modal-asignaravance').modal('hide');

//					getLista(proroll_id,ini,fin,procesos,estado);
				}
			};

			$.ajax(options)		
			
		   .done(function (res) {
            $('#actualizarListRollo').html(res);
        })
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });

      }else{
                // alert("") ? "" : location.reload(); 
                 bootbox.alert(' !!REVISAR¡¡  Registre metros lineales positivos, o asigne la producción a un colaborador valido', function(){}); 
                
            }           


	});

    $('body').on('click', '#btnActualizarRegistros', function (e) {
        e.preventDefault();
        var proroll_id = $('#proroll_id').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
         var maquina = $('#maquina').val();

        $('#modal-asignaravance').modal('hide');

        getListaProducion(proroll_id, ini, fin, procesos, estado,maquina);

    });
    
    
    var getListaProducion = function(proroll_id,ini,fin,procesos,estado,maquina){


		var options = {
			type: 'POST',
			url:'index.php?page=kanban&accion=ajaxGetActualizarListRollo',
			data: {
				'proroll_id': proroll_id,
                                        'ini': ini,
                                        'fin': fin,
                                        'procesos':procesos,
                                        'estado':estado,
                                        'proroll_id':proroll_id,
                                        'maquina':maquina
			},
			dataType: 'html',
			success: function(response){

					$('#cargaravanceproduccion').html('');
					$('#cargaravanceproduccion').html(response);
					$('#cargaravanceproduccion').fadeIn('slow');
				
					
			}
		};

		$.ajax(options);				


	};

  

$('body').on('click', '#cerrarprodrollos', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var proroll_id = $(this).data('cerrarprodrollos');
       var progprodet_id = $('#progprodet_id-' + proroll_id).val();
       
       
        var kandet_id = $('#kandet_id-' + proroll_id).val();
    
    var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
         var maquina = $('#maquina').val();
        
        
     var mtrstotales = $('#mtrstotales-' + proroll_id).val();
       var pesototales = $('#pesototales-' + proroll_id).val();
       
          var items = $('#items-'+proroll_id).val();
             var opedido = $('#opedido-'+proroll_id).val();
       
       if(procesos == '173' && mtrstotales > 0){
		     var loading = $(".loading-" + proroll_id);
            checkboxClickeado.hide();
            loading.show();
$('#cargaravanceproduccion').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            
         
            var _options = {
                type: 'POST',
                url: 'index.php?page=kanban&accion=cerrarProduccRollo',
                data: {
                    'proroll_id': proroll_id,
                    'ini': ini,
                    'fin': fin,
                    'procesos':procesos,
                    'estado':estado,
                    'accion': accion,
                    'progprodet_id':progprodet_id,
                    'kandet_id':kandet_id,
                    'maquina':maquina,
                     'items':items,
                    'opedido':opedido
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
            
            
            .done(function (res) {
            $('#cargaravanceproduccion').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
           
	   }else{
                    if(procesos == '170'){


                        if (mtrstotales > 0 ){
                                    var loading = $(".loading-" + proroll_id);
                                    checkboxClickeado.hide();
                                    loading.show();
            $('#cargaravanceproduccion').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
                                    if (agregar) {
                                            var accion = "agregar";

                                    } else {
                                            var accion = "eliminar";
                                    }


                                    var _options = {
                                            type: 'POST',
                                            url: 'index.php?page=kanban&accion=cerrarProduccRollo',
                                            data: {
                                                    'proroll_id': proroll_id,
                                                    'ini': ini,
                                                    'fin': fin,
                                                    'procesos':procesos,
                                                    'estado':estado,
                                                    'accion': accion,
                                                    'progprodet_id':progprodet_id,
                                                    'kandet_id':kandet_id,
                                                    'maquina':maquina,
                                                    'items':items,
                                                    'opedido':opedido
                                            },
                                            dataType: 'html',
                                            success: function (response) {
                                                    checkboxClickeado.show();
                                                    loading.hide();

                                            }
                                    };

                                    $.ajax(_options)



                                    .done(function (res) {
                                    $('#cargaravanceproduccion').html(res);
                            })



                                            .fail(function(){
                                                    console.log("error");
                                            })

                                            .always(function(){
                                                    console.log("complete");
                                            });

                       }else{
                               bootbox.alert("Para cerrar la producción, no se admiten valores ceros en su producción", function(){});
                       }







                    }else if (procesos == '171'){

                                                            if (mtrstotales > 0 ){
                                                                            var loading = $(".loading-" + proroll_id);
                                                                    checkboxClickeado.hide();
                                                                    loading.show();
                                            $('#cargaravanceproduccion').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
                                                                    if (agregar) {
                                                                            var accion = "agregar";

                                                                    } else {
                                                                            var accion = "eliminar";
                                                                    }


                                                                    var _options = {
                                                                            type: 'POST',
                                                                            url: 'index.php?page=kanban&accion=cerrarProduccRollo',
                                                                            data: {
                                                                                    'proroll_id': proroll_id,
                                                                                    'ini': ini,
                                                                                    'fin': fin,
                                                                                    'procesos':procesos,
                                                                                    'estado':estado,
                                                                                    'accion': accion,
                                                                                    'progprodet_id':progprodet_id,
                                                                                    'kandet_id':kandet_id,
                                                                                    'maquina':maquina,
                                                                                    'items':items,
                                                                                    'opedido':opedido
                                                                            },
                                                                            dataType: 'html',
                                                                            success: function (response) {
                                                                                    checkboxClickeado.show();
                                                                                    loading.hide();

                                                                            }
                                                                    };

                                                                    $.ajax(_options)



                                                                    .done(function (res) {
                                                                    $('#cargaravanceproduccion').html(res);
                                                            })



                                                                            .fail(function(){
                                                                                    console.log("error");
                                                                            })

                                                                            .always(function(){
                                                                                    console.log("complete");
                                                                            });



                                                                     }else{

                                                                                       bootbox.alert("Para cerrar la producción, no se admiten valores ceros en su producción", function(){});

                                                                     }

                                            }else{

                                                        if (mtrstotales > 0 && pesototales > 0){
                                                                    var loading = $(".loading-" + proroll_id);
                                                                    checkboxClickeado.hide();
                                                                    loading.show();
                                            $('#cargaravanceproduccion').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
                                                                    if (agregar) {
                                                                            var accion = "agregar";

                                                                    } else {
                                                                            var accion = "eliminar";
                                                                    }


                                                                    var _options = {
                                                                            type: 'POST',
                                                                            url: 'index.php?page=kanban&accion=cerrarProduccRollo',
                                                                            data: {
                                                                                    'proroll_id': proroll_id,
                                                                                    'ini': ini,
                                                                                    'fin': fin,
                                                                                    'procesos':procesos,
                                                                                    'estado':estado,
                                                                                    'accion': accion,
                                                                                    'progprodet_id':progprodet_id,
                                                                                    'kandet_id':kandet_id,
                                                                                    'maquina':maquina,
                                                                                    'items':items,
                                                                                    'opedido':opedido
                                                                            },
                                                                            dataType: 'html',
                                                                            success: function (response) {
                                                                                    checkboxClickeado.show();
                                                                                    loading.hide();

                                                                            }
                                                                    };

                                                                    $.ajax(_options)



                                                                    .done(function (res) {
                                                                    $('#cargaravanceproduccion').html(res);
                                                            })



                                                                            .fail(function(){
                                                                                    console.log("error");
                                                                            })

                                                                            .always(function(){
                                                                                    console.log("complete");
                                                                            });

                                                       }else{
                                                               bootbox.alert("Para cerrar la producción, no se admiten valores ceros, tanto en su produccion de metros y peso", function(){});
                                                       }

                                            }
	   }

    
	   
	   
    });
  
  
  $('body').on('click', '#mostrarlistTelares', function (e) {
        e.preventDefault();

        var idkanban = $(this).data('listartelares');

         var codart = $('#codart').val();
          var proceso = $('#proceso').val();
          var estado = $('#estado').val();
          var op = $('#op').val();
           var area = $('#area').val();
           var mtrs = $('#mtrs-'+idkanban).val();
            var artsemi = $('#artsemi-'+idkanban).val();
          
            var items = $('#items-'+idkanban).val();
        
        var ver_listaTelares = $('#ver_listatelares');

        var _options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxListarTelares',
            data: {
                'idkanban':idkanban,
                'op': op,
                'mtrs': mtrs,
                'codart':codart,
                'proceso': proceso,
                'estado': estado,
                'area':area,
                'artsemi':artsemi,
                'items':items
               
            },
            dataType: 'html',
            success: function (response) {
                ver_listaTelares.html('');


                $('#datosActualTXTop').val('');
                $('#datosActualTXTop').html(op);
                
                $('#datosActualTXTcodart').val('');
                $('#datosActualTXTcodart').html(codart);


                ver_listaTelares.html(response);

                $('#modal-verdisponibilidad').modal('show');
            }
        };

        $.ajax(_options);

    });

	var maquinalista_seleccionada = -1;

	$('body').on('click', '.maquinalista', function(e){
		e.preventDefault();

		$('.maquinalista').each(function(){
			$(this).removeClass('maquina_seleccionada');
		});

		$(this).addClass('maquina_seleccionada');

		var idtelar = $(this).data('idtelar');

		maquinalista_seleccionada = idtelar;


		getOcupacion(maquinalista_seleccionada, $('#ajax_ocupacionmaq'));


	});


	var getOcupacion = function(idmaquina, target){

			var options = {
				type: 'POST',
				url:'index.php?page=kanban&accion=ajaxGetDisponibilidad',
				data: {
					'id_maq_ocupacion': idmaquina
				},
				dataType: 'html',
				success: function(response){
					target.fadeOut('fast', function(){


						target.html('');
						target.html(response);
						target.fadeIn('slow');

					});
				}
			};

			$.ajax(options);


	};
        
        $('body').on('click', '#maq_id', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        
            var maq_id = $(this).data('maq_id');
            var fecdisp = $('#fecdisp-'+maq_id).val(); 
             var maqdisp = $('#maqdisp-'+maq_id).val(); 
            
         var op = $('#op').val(); 
          var mtrs = $('#mtrs').val(); 
          var codart = $('#codart').val(); 
           var idkanban2 = $('#idkanban2').val(); 
              var area = $('#area').val();
                var proceso = $('#proceso').val();
                 var estado = $('#estado').val();
                 var artsemi = $('#artsemi').val();
                 
                  var items = $('#items').val();
 
    var ini = $('#ini').val();
       var fin = $('#fin').val();

 
            var loading = $(".loading-" + maq_id);
            checkboxClickeado.hide();
            loading.show();
  
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=kanban&accion=InsertTelarSeleccionado',
                data: {
                    'maq_id': maq_id,
                     'op': op,
                       'idkanban2': idkanban2,
                    'ini': ini,
                    'maqdisp':maqdisp,
                    'mtrs': mtrs,
                    'fecdisp':fecdisp,
                    'proceso':proceso,
                    'fin': fin,
                    'codart':codart,
                    'area':area,
                    'accion': accion,
                    'artsemi':artsemi,
                    'items':items,
                    'estado':estado
                },
                dataType: 'html',
                success: function (response) {
                    
                    checkboxClickeado.show();
                    loading.hide();
                    getActualizarListaDisponibilidad(idkanban2,op,mtrs,codart,area,proceso,artsemi,items,estado);
                    
                }
            };

            $.ajax(_options)
            

    });


 var getActualizarListaDisponibilidad = function(idkanban,op,mtrs,codart,area,proceso,artsemi,items,estado){


		  var options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxListarTelares',
            data: {
                'idkanban':idkanban,
                'op': op,
                'mtrs': mtrs,
                'codart':codart,
                'area':area,
                'proceso':proceso,
                'artsemi':artsemi,
                'items':items,
                 'estado':estado
               
            },
            dataType: 'html',
            success: function (response) {
              


                $('#datosActualTXTop').val('');
                $('#datosActualTXTop').html(op);
            
                                        $('#actualizarDisponibilidad').html('');
					$('#actualizarDisponibilidad').html(response);
					$('#actualizarDisponibilidad').fadeIn('slow');

            
            }
        };


		$.ajax(options);				




	};

    $('body').on('click', '#ActualizarListaTelares', function (e) {
        e.preventDefault();
        var op = $('#op').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var codart = $('#codart').val();
          var area = $('#area').val();
           var artsemi = $('#artsemi').val();

        $('#modal-verdisponibilidad').modal('hide');

        getActualizarListaTelares(op, codart,ini,fin,area,artsemi);

    });


 var getActualizarListaTelares = function(op, codart,ini,fin,area,artsemi){


		  var options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxListarKanban',
            data: {
              
                'op': op,
                'codart':codart,
                'ini': ini,
                'fin': fin,
                'area':area,
                'artsemi':artsemi
               
            },
            dataType: 'html',
            success: function (response) {
              


                $('#datosActualTXTop').val('');
                $('#datosActualTXTop').html(op);
            
                                        $('#actualizarlistakanban').html('');
					$('#actualizarlistakanban').html(response);
					$('#actualizarlistakanban').fadeIn('slow');

            
            }
        };


		$.ajax(options);				




	};


  $('body').on('click', '#salirListaTelares', function (e) {
        e.preventDefault();
     
       

        $('#modal-listakanban').modal('hide');



    });
    
    
    
 
        
          $('body').on('click', '#mostraravancetelar', function (e) {
        e.preventDefault();

       var idtelar = $(this).data('idtelar');
       maquinalista_seleccionada = idtelar;

    
          
        
        var ajax_ocupacionmaq = $('#ajax_ocupacionmaq');

        var _options = {
            type: 'POST',
         url:'index.php?page=kanban&accion=ajaxGetDisponibilidad',
            data: {
             
                'id_maq_ocupacion': maquinalista_seleccionada
               
               
            },
            dataType: 'html',
            success: function (response) {
                ajax_ocupacionmaq.html('');


                $('#datosActualTXTtelar').val('');
                $('#datosActualTXTtelar').html(idtelar);
                
                
           


                ajax_ocupacionmaq.html(response);

                $('#modal-listaavance').modal('show');
            }
        };

        $.ajax(_options);

    });
    
    
    
      $('body').on('click', '#mostrarmaqprocesos', function (e) {
        e.preventDefault();

        var idkanban = $(this).data('maqprocesos');

         var codart = $('#codart-'+idkanban).val();
          var op = $('#op-'+idkanban).val();
           var mtrs = $('#mtrs-'+idkanban).val();
          var estado = $('#estado').val();
          var proceso = $('#proceso').val();
           var area = $('#area').val();
             var artsemi = $('#artsemi-'+idkanban).val();
          
            var items = $('#items-'+idkanban).val();
        
        var ver_listamaqprocesos = $('#ver_listamaqprocesos');

        var _options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxListarTelares',
            data: {
                'idkanban':idkanban,
                'op': op,
                'mtrs': mtrs,
                'codart':codart,
                'proceso':proceso,
                'area':area,
                'artsemi':artsemi,
                'items':items,
                'estado':estado
               
            },
            dataType: 'html',
            success: function (response) {
                ver_listamaqprocesos.html('');


                $('#datosActualTXTop').val('');
                $('#datosActualTXTop').html(op);
                
                $('#datosActualTXTcodart').val('');
                $('#datosActualTXTcodart').html(codart);


                ver_listamaqprocesos.html(response);

                $('#modal-verdisponibilidad').modal('show');
            }
        };

        $.ajax(_options);

    });

   $('body').on('click', '#ActualizarListProceso', function (e) {
        e.preventDefault();
        var op = $('#op').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var codart = $('#codart').val();
          var area = $('#area').val();
           var proceso = $('#proceso').val();
           var estado = $('#estado').val();

        $('#modal-verdisponibilidad').modal('hide');

        getActualizarListProceso(op, codart,ini,fin,area,proceso,estado);

    });
    
     var getActualizarListProceso = function(op, codart,ini,fin,area,proceso,estado){


		  var options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxListaProcesos',
            data: {
              
                'op': op,
                'codart':codart,
                'ini': ini,
                'fin': fin,
                'area':area,
                'proceso':proceso,
                'estado':estado
               
            },
            dataType: 'html',
            success: function (response) {
              


                $('#datosActualTXTop').val('');
                $('#datosActualTXTop').html(op);
            
                                        $('#cargarprocesoactualsistema').html('');
					$('#cargarprocesoactualsistema').html(response);
					$('#cargarprocesoactualsistema').fadeIn('slow');

            
            }
        };


		$.ajax(options);				




	};
        
        $('body').on('click', '#ingresaravancesacos', function (e) {
        e.preventDefault();

        var proroll_id = $(this).data('ingresaravancesacos');

        var guardaravanceproduccsacos = $('#guardaravanceproduccsacos');
        
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
          var maquina = $('#maquina').val();
          var acceso = $('#acceso-'+proroll_id).val();

        var _options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxFormRegisProduccSacos',
            data: {
                'proroll_id': proroll_id,
                'ini': ini,
                'fin': fin,
                'procesos':procesos,
                'estado':estado,
                'maquina':maquina,
                'acceso':acceso
               
            },
            dataType: 'html',
            success: function (response) {
                guardaravanceproduccsacos.html('');


                $('#datosActualTXTsacos').val('');
                $('#datosActualTXTsacos').html(proroll_id);


                guardaravanceproduccsacos.html(response);

                $('#modal-asignaravancesacos').modal('show');
//                    modalasignarinic.modal('show');
            }
        };

        $.ajax(_options);

    });
    
        $('body').on('click', '#ingresaravancesacosconver', function (e) {
        e.preventDefault();

        var proroll_id = $(this).data('ingresaravancesacos');

        var guardaravanceproduccsacos = $('#guardaravanceproduccsacos');
        
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
          var maquina = $('#maquina').val();
            var acceso = $('#acceso-'+proroll_id).val();

        var _options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxFormRegisProduccSacosConver',
            data: {
                'proroll_id': proroll_id,
                'ini': ini,
                'fin': fin,
                'procesos':procesos,
                'estado':estado,
                'maquina':maquina,
                'acceso':acceso
               
            },
            dataType: 'html',
            success: function (response) {
                guardaravanceproduccsacos.html('');


                $('#datosActualTXTsacos').val('');
                $('#datosActualTXTsacos').html(proroll_id);


                guardaravanceproduccsacos.html(response);

                $('#modal-asignaravancesacos').modal('show');
//                    modalasignarinic.modal('show');
            }
        };

        $.ajax(_options);

    });
    
   
   
$('body').on('click', '#btnguardardatosProdSacosConv', function(e){
		e.preventDefault();

        var proroll_id = $('#proroll_id').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
        
         var obs = $('#obs').val();
          var emp = $('#emp').val();
        var clasea = $('#clasea').val();
        var telares = $('#telares').val();
        var laminado = $('#laminado').val();
        var impresion = $('#impresion').val();
        var conversion = $('#conversion').val();
        
            if(emp>0 && clasea!= '' && telares!= '' && laminado!= '' && impresion!= '' && conversion!= '' ){
				
				
  $('#actualizarListSaco').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>"); 

			var options = {
				type: 'POST',
				url:'index.php?page=kanban&accion=insertarProduccSacoConv',
				data: {
					'proroll_id': proroll_id,
                                        'ini': ini,
                                        'fin': fin,
                                        'procesos':procesos,
                                        'estado':estado,
                                        'emp':emp,
                                        'clasea':clasea,
                                        'telares':telares,
                                        'laminado':laminado,
                                        'impresion':impresion,
                                        'conversion':conversion,
                                        'obs':obs
				},
				dataType: 'html',
				success: function(response){

				}
			};

			$.ajax(options)		
			
		   .done(function (res) {
            $('#actualizarListSaco').html(res);
        })
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });


				
				}else{
			  bootbox.alert("Para registrar la produccion, no se admiten valores nulos, revisar nuevamente ( completar los campos con ceros Ó revisar la asignació del operador )", function(){});
		}



	});


   $('body').on('click', '#btnActualizarRegistrossacos', function (e) {
        e.preventDefault();
        var proroll_id = $('#proroll_id').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
          var maquina = $('#maquina').val();
 
          
        if(procesos == '173'){
			  $('#modal-asignaravanceminirollos').modal('hide');
		}else{
			  $('#modal-asignaravancesacos').modal('hide');
		}

      

        getListaProducion(proroll_id, ini, fin, procesos, estado,maquina);

    });
    
    
    
    
    
        $('body').on('click', '#progprocesossacos', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var id_kanban_det = $(this).data('progprocesossacos');

var fecha_programacion = $('#fec-' + id_kanban_det).val();

        var codart = $('#codart-' + id_kanban_det).val();
        
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
  var artsemi_id = $('#artsemi_id-' + id_kanban_det).val();
   
            var loading = $(".loading-" + id_kanban_det);
            checkboxClickeado.hide();
            loading.show();
          
        
        $('#cargarproceso').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=kanban&accion=progprocesosGuardarSacos',
                data: {
                    'id_kanban_det': id_kanban_det,
                    'ini': ini,
                    'fin': fin,
                    'fecha_programacion': fecha_programacion,
                    'procesos': procesos,
                    'estado': estado,
                    'accion': accion,
                    'codart':codart, 
                    'artsemi_id':artsemi_id
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)



                    .done(function (res) {
                        $('#cargarproceso').html(res);
                    })



                    .fail(function () {
                        console.log("error");
                    })

                    .always(function () {
                        console.log("complete");
                    });
      
    });


     $('body').on('click', '#ingresaravancesacosbas', function (e) {
        e.preventDefault();

        var proroll_id = $(this).data('ingresaravancesacosbas');
        
          var claseb_ant = $('#claseb_ant-'+proroll_id).val();

        var guardaravanceproduccsacosbas = $('#guardaravanceproduccsacosbas');
        
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
        

        var _options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxFormRegisProduccSacosBas',
            data: {
                'proroll_id': proroll_id,
                'ini': ini,
                'fin': fin,
                'procesos':procesos,
                'estado':estado,
                'claseb_ant':claseb_ant
               
            },
            dataType: 'html',
            success: function (response) {
                guardaravanceproduccsacosbas.html('');


                $('#datosActualTXTsacos').val('');
                $('#datosActualTXTsacos').html(proroll_id);


                guardaravanceproduccsacosbas.html(response);

                $('#modal-asignaravancesacosbas').modal('show');
//                    modalasignarinic.modal('show');
            }
        };

        $.ajax(_options);

    });
    
       
   
$('body').on('click', '#btnguardardatosProdSacosBast', function(e){
		e.preventDefault();

        var proroll_id = $('#proroll_id').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
        
         var obs = $('#obs').val();
          var emp = $('#emp').val();
        var clasea = $('#clasea').val();
        
        var maquina = $('#maq').val();
        var claseb_bast = $('#clasebbast').val();
        var claseb_ant = $('#clasebant').val();
   
       if(emp>0 && clasea!= '' && claseb_bast!= ''  ){
				
  $('#actualizarListSaco').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>"); 

			var options = {
				type: 'POST',
				url:'index.php?page=kanban&accion=insertarProduccSacoBast',
				data: {
					'proroll_id': proroll_id,
                                        'ini': ini,
                                        'fin': fin,
                                        'procesos':procesos,
                                        'estado':estado,
                                        'emp':emp,
                                        'clasea':clasea,
                                        'maquina':maquina,
                                        'claseb_bast':claseb_bast,
                                        'claseb_ant':claseb_ant,
                                       
                                        'obs':obs
				},
				dataType: 'html',
				success: function(response){
					
						
//					 $('#modal-asignaravance').modal('hide');

//					getLista(proroll_id,ini,fin,procesos,estado);
				}
			};

			$.ajax(options)		
			
		   .done(function (res) {
            $('#actualizarListSaco').html(res);
        })
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });


				
		   
		   
				}else{
			  bootbox.alert("Para registrar la produccion, no se admiten valores nulos, revisar nuevamente ( completar los campos con ceros Ó revisar la asignació del operador )", function(){});
		}
   



	});

 
   $('body').on('click', '#btnActualizarRegistrossacosBast', function (e) {
        e.preventDefault();
        var proroll_id = $('#proroll_id').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
           var maquina = $('#maquina').val();

        $('#modal-asignaravancesacosbas').modal('hide');

        getListaProducion(proroll_id, ini, fin, procesos, estado,maquina);

    });
    
    
    $('body').on('click', '#genfilas', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var proroll_id = $(this).data('genfilas');// se debe tomar esto como variable de entrada prosacodet_id
       var progprodet_id = $('#progprodet_id-' + proroll_id).val();
       
       
        var kandet_id = $('#kandet_id-' + proroll_id).val();
        
        var totala = $('#totala-' + proroll_id).val();
        var totalb = $('#totalb-' + proroll_id).val();
         var nroped = $('#nroped-' + proroll_id).val();
           var cantenfardado = $('#cantenfardado-' + proroll_id).val();
        
    
    var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
        
        
   if(cantenfardado != '' && cantenfardado >=1){
	    
            var loading = $(".loading-" + proroll_id);
            checkboxClickeado.hide();
            loading.show();
$('#cargaravanceproduccion').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=kanban&accion=cerrarProduccGenFil',
                data: {
                    'proroll_id': proroll_id,
                    'ini': ini,
                    'fin': fin,
                    'procesos':procesos,
                    'estado':estado,
                    'accion': accion,
                    'progprodet_id':progprodet_id,
                    'kandet_id':kandet_id,
                    'totala':totala,
                    'totalb':totalb,
                    'nroped':nroped,
                    'cantenfardado':cantenfardado
                    
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
            
            
            .done(function (res) {
            $('#cargaravanceproduccion').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
	   
	   
   }else{
	   
	     bootbox.alert("Se detecto que el articulo de esta orden no esta configurado el tamaño del fardo, favor de comunicarse con ASC o el administrador del sistema", function(){});
	   // alert("Debe Ingresar valores validos para cada Máquina.") ? "" : location.reload();
   }

 
           
    });
  
  
$('body').on('click', '#detallefilas', function (e) {
        e.preventDefault();

        var proroll_id = $(this).data('detallefilas');

        var mostrarfilas = $('#mostrarfilas');
        
       
        

        var _options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxFormMostrarFilas',
            data: {
                'proroll_id': proroll_id
               
               
            },
            dataType: 'html',
            success: function (response) {
                mostrarfilas.html('');


                $('#datosActualTXTidrollo').val('');
                $('#datosActualTXTidrollo').html(proroll_id);


                mostrarfilas.html(response);

                $('#modal-filasgeneradas').modal('show');
//                    modalasignarinic.modal('show');
            }
        };

        $.ajax(_options);

    });
    
    
    
    
     var estructura_tabla_produccion = $('#estructura_tabla_produccion');
    var ajax_produccion_enfardado = $('#ajax_produccion_enfardado');
    $('#produccion_enfardado').on('submit', function (e) { // on submit se envian datos asosciados al formilario
        e.preventDefault();

        var op = $('#opedido').val();

        estructura_tabla_produccion.slideUp("slow", function () {
  
		GetTotal(op);
          
        });

    });


    var ajax_produccion_totales = $('#ajax_produccion_totales');
    $('#produccion_enfardado').on('submit', function (e) { // on submit se envian datos asosciados al formilario
        e.preventDefault();

        var op = $('#opedido').val();


        estructura_tabla_produccion.slideUp("slow", function () {
          GetResu(op);

        });

    });
    
        var ajax_produccion_pucho = $('#ajax_produccion_pucho');
    $('#produccion_enfardado').on('submit', function (e) { // on submit se envian datos asosciados al formilario
        e.preventDefault();

        var op = $('#opedido').val();


        estructura_tabla_produccion.slideUp("slow", function () {
         
		GetPuchos(op);
        });

    });



    var estructura_tabla_datosgenerales = $('#estructura_tabla_datosgenerales');
    var ajax_produccion_articulo = $('#ajax_produccion_articulo');
    $('#produccion_enfardado').on('submit', function (e) { // on submit se envian datos asosciados al formilario
        e.preventDefault();

        var op = $('#opedido').val();



        estructura_tabla_datosgenerales.slideUp("slow", function () {
            GetDatGen(op);
           

           
        });

    });


$('body').on('click', '#clase', function (e) {
        e.preventDefault();

        var op = $(this).data('clase');
         var tipo = $(this).data('tipo');

        var mostrarfardos = $('#mostrarfardos');
        
       
        

        var _options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxGetAgruparPuchos',
            data: {
                'op': op,
                'tipo':tipo
               
               
            },
            dataType: 'html',
            success: function (response) {
                mostrarfardos.html('');


                $('#datosActualTXTop').val('');
                $('#datosActualTXTop').html(op);


                mostrarfardos.html(response);

                $('#modal-agruparfardos').modal('show');
//                    modalasignarinic.modal('show');
            }
        };

        $.ajax(_options);

    });
   
    
  $('body').on('click', '#guardarpuchosagrupados', function (e) {
        e.preventDefault();
        var kanban = $('#kanban').val();
        var suma = $('#suma').val();
        var op = $('#op').val();
        var tipo = $('#tipo').val();
         var descontar  =document.regproduccion.elements['descontar[]'];
         
         var iddescontar  =document.regproduccion.elements['prefila_id[]'];
         
         var idfila = [];
         var valorfila = [];
         
         
   var id = $("input[name='descontar[]']").map(function(){return $(this).val();}).get();     
  $("input[name='descontar[]']").each(function(indice, elemento) {
	  valorfila[indice] =$(elemento).val();
    //console.log('El elemento con el índice '+indice+' contiene '+$(elemento).val());
});

  var id = $("input[name='descontar[]']").map(function(){return $(this).val();}).get();     
  $("input[name='prefila_id[]']").each(function(indice, elemento) {
	    idfila[indice] =$(elemento).val();
   // console.log('El elemento con el índice2 '+indice+' contiene2 '+$(elemento).val());
});
         
//           valorfila= JSON.stringify(valorfila);
//            idfila= JSON.stringify(idfila);  
         
    //var msgfornormal = '';

//var msgforin = '';
//var array = [1,2,3,4]; //array que deseo enviar
//
//$.ajax({
//          type: "POST",
//          url: ...,
//          data: {'array': JSON.stringify(array)},//capturo array     
//          success: function(data){
//
//        }
//});

//for normal

//for (var i=0; i<valorfila.length; i++) { 
	 //console.log(valorfila[i])
	 //}
      

        $('#modal-agruparfardos').modal('hide');

        getGuardarAgrupados(kanban, suma, op, tipo,valorfila,idfila);

    });
    
    
       var getGuardarAgrupados = function(kanban, suma, op, tipo,valorfila,idfila){


		var options = {
			type: 'POST',
			url:'index.php?page=kanban&accion=ajaxGetActualizarTablasEnfar',
			data: {
				'kanban': kanban,
                                        'suma': suma,
                                        'op': op,
                                        'tipo':tipo,
                                        'valorfila': JSON.stringify(valorfila),
                                        'idfila':JSON.stringify(idfila)
                                      
                                       

			},
			dataType: 'json',
			success: function(response){

//					$('#actualizarregistros').html('');
//					$('#actualizarregistros').html(response);
//					$('#actualizarregistros').fadeIn('slow');
				
					
			}
		};

		
		
		 
         estructura_tabla_datosgenerales.slideUp("slow", function () {
            GetDatGen(op);
           

           
        });
		
		
		 estructura_tabla_produccion.slideUp("slow", function () {
  
		GetTotal(op);
		  GetResu(op);
		GetPuchos(op);
          
        });
       
		
		$.ajax(options);				


	};
	
	
	
	
	
	var GetTotal = function (op){
		  var options = {
                type: 'POST',
                       url: 'index.php?page=kanban&accion=ajaxGetTotal',
                data: {
                    'op': op
                },
                dataType: 'html',
                success: function (response) {
                    ajax_produccion_enfardado.html('');
                    $('#op').val('');
                    $('#op').html(op);

                   

                    ajax_produccion_enfardado.html(response);
                    estructura_tabla_produccion.slideDown("slow");
                }
            };

            $.ajax(options);
	};
	
	
		var GetResu = function (op){
		 
            var options = {
                type: 'POST',
                       url: 'index.php?page=kanban&accion=ajaxGetResu',
                data: {
                    'op': op
                },
                dataType: 'html',
                success: function (response) {
                    ajax_produccion_totales.html('');
                    $('#op').val('');
                    $('#op').html(op);

                  

                    ajax_produccion_totales.html(response);
                    estructura_tabla_produccion.slideDown("slow");
                }
            };

            $.ajax(options); 
	};

		var GetPuchos = function (op){
		 
            var options = {
                type: 'POST',
                       url: 'index.php?page=kanban&accion=ajaxGetPuchos',
                data: {
                    'op': op
                },
                dataType: 'html',
                success: function (response) {
                    ajax_produccion_pucho.html('');
                    $('#op').val('');
                    $('#op').html(op);

                  

                    ajax_produccion_pucho.html(response);
                    estructura_tabla_produccion.slideDown("slow");
                }
            };

            $.ajax(options);
           
	};
	
	
		var GetDatGen = function (op){
		 
            var options = {
                type: 'POST',
                url: 'index.php?page=kanban&accion=ajaxGetDatGen',
                data: {
                    'op': op
                },
                dataType: 'html',
                success: function (response) {
                    ajax_produccion_articulo.html('');
                    $('#op').val('');
                    $('#op').html(op);


                    ajax_produccion_articulo.html(response);
                    estructura_tabla_datosgenerales.slideDown("slow");
                }
            };

            $.ajax(options);
           
	};
	
	   $('body').on('click', '#mostrardiseno', function (e) {
        e.preventDefault();

        var id = $(this).data('diseno');

//        var permiso = 'disabled';

        var ver_diseno = $('#ver_diseno');

        var _options = {
            type: 'POST',
            url: 'index.php?page=opedido&accion=ajaxverdiseno',
            data: {
                'id': id
            },
            dataType: 'html',
            success: function (response) {
                ver_diseno.html('');


                $('#datosdisenoTXT').val('');
                $('#datosdisenoTXT').html(id);


                ver_diseno.html(response);

                $('#modal-diseno').modal('show');
            }
        };

        $.ajax(_options);

    });
    
    
           $('body').on('click', '#updateenfardado', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
       
               var prefila_id = $(this).data('prefila_id');

var peso = $('#peso-' + prefila_id).val();

var tipo = $('#tipo-' + prefila_id).val();

var codart = $('#codart-' + prefila_id).val();

 var op = $('#opedido').val();       

   
            var loading = $(".loading-" + prefila_id);
            checkboxClickeado.hide();
            loading.show();
          
        
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=kanban&accion=ajaxGetActualizarTablasEnfarRegProduc',
                data: {
                    'prefila_id': prefila_id,
                    'peso': peso,
                    'accion':accion,
                    'op':op,
                    'tipo':tipo,
                    'codart':codart
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();
                    GetTotal(op);

                }
            };

            $.ajax(_options);
   
    });

   $('body').on('click', '#reporteetiq', function (e) {
        e.preventDefault();

        var id = $(this).data('reporteetiq');
 var ver_etiqueta = $('#ver_etiqueta');

        var _options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxveretiquetaIFrame',
            data: {
                'id': id
            },
            dataType: 'html',
            success: function (response) {
                ver_etiqueta.html('');


                $('#datosetiquetaTXT').val('');
                $('#datosetiquetaTXT').html(id);


                ver_etiqueta.html(response);

                $('#modal-etiqueta').modal('show');
            }
        };

        $.ajax(_options);

    });
    
    
      var getkanban = function (opedidoorig){
        var options = {
            type: 'POST',
            url : 'index.php?page=kanban&accion=ajaxGetKanban',
            data: { 'opedidoorig' : opedidoorig },
            datatype : 'html',
            success : function (response){
               $('#kanban_id').removeAttr('disabled');
               $('#kanban_id').html(response);      
                       
            }
        };
        $.ajax(options);
    };

   	
	$('#opedidoorig').on('change', function(e){
		e.preventDefault();

		var opedidoorig = $(this).val();

		if(opedidoorig != -1){
                     getkanban(opedidoorig);			
		}else{
			$('#kanban_id').attr('disabled', 'disabled');
			$('#kanban_id').val('-1');
		}
	});
    
    
    
            $('body').on('click', '#ingresaravanceminiroll', function (e) {
        e.preventDefault();

        var proroll_id = $(this).data('ingresaravanceminiroll');

        var guardaravanceproduccminiroll = $('#guardaravanceproduccminiroll');
        
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
        
                  var items = $('#items-'+proroll_id).val();
             var opedido = $('#opedido-'+proroll_id).val();
        

        var _options = {
            type: 'POST',
            url: 'index.php?page=kanban&accion=ajaxFormRegisProduccMiniRoll',
            data: {
                'proroll_id': proroll_id,
                'ini': ini,
                'fin': fin,
                'procesos':procesos,
                'estado':estado,
                'items':items,
                    'opedido':opedido
               
            },
            dataType: 'html',
            success: function (response) {
                guardaravanceproduccminiroll.html('');


                $('#datosActualTXTsacos').val('');
                $('#datosActualTXTsacos').html(proroll_id);


                guardaravanceproduccminiroll.html(response);

                $('#modal-asignaravanceminirollos').modal('show');
//                    modalasignarinic.modal('show');
            }
        };

        $.ajax(_options);

    });
    
    $('body').on('click', '#btnguardardatosProdMiniRoll', function(e){
		e.preventDefault();

        var proroll_id = $('#proroll_id').val();
         var emp = $('#emp').val();
           var mtrscort = $('#mtrscort').val();
        var cantroll_a = $('#cantroll_a').val();
        var cantroll_b = $('#cantroll_b').val();
         var obs = $('#obs').val();
        
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
           
           
      
     

  $('#actualizarListSaco').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>"); 

			var options = {
				type: 'POST',
				url:'index.php?page=kanban&accion=insertarProduccMiniRoll',
				data: {
					'proroll_id': proroll_id,
                                        'ini': ini,
                                        'fin': fin,
                                        'procesos':procesos,
                                        'estado':estado,
                                        'emp':emp,
                                        'mtrscort':mtrscort,
                                        'cantroll_a':cantroll_a,
                                        'cantroll_b':cantroll_b,
                                        'obs':obs
				},
				dataType: 'html',
				success: function(response){
					
						
//					 $('#modal-asignaravance').modal('hide');

//					getLista(proroll_id,ini,fin,procesos,estado);
				}
			};

			$.ajax(options)		
			
		   .done(function (res) {
            $('#actualizarListSaco').html(res);
        })
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });




	});

    

      var getartsemi_id = function (opedido){
        var options = {
            type: 'POST',
            url : 'index.php?page=kanban&accion=ajaxGetArtsemi',
            data: { 'opedido' : opedido },
            datatype : 'html',
            success : function (response){
               $('#artsemi_id').removeAttr('disabled');
               $('#artsemi_id').html(response);      
                       
            }
        };
        $.ajax(options);
    };

   	
	$('#opedido').on('change', function(e){
		e.preventDefault();

		var opedido = $(this).val();

		if(opedido != -1){
                     getartsemi_id(opedido);			
		}else{
			$('#artsemi_id').attr('disabled', 'disabled');
			$('#artsemi_id').val('-1');
		}
	});
	
	
	
	$('#opedidodest').on('change', function(e){
		e.preventDefault();

		var opedido = $(this).val();

		if(opedido != -1){
                     getartsemi_id(opedido);			
		}else{
			$('#artsemi_id').attr('disabled', 'disabled');
			$('#artsemi_id').val('-1');
		}
	});
	
	
	
	
	$('body').on('click', '#updateenviar', function (e) {

 
        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var iddetallle = $(this).data('iddetallle');
        
          var proroll_id = $('#proroll_id').val();
            var prosacodet_id = $('#prosacodet_id-'+iddetallle).val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
        
						
					if ( $('#clasebant').val()=== undefined) {
					   // se ejecutan estas instrucciones
					   var  clasebant = '0';
					}
					else {
					   // estas instrucciones no se ejecutan
					    var clasebant = $('#clasebant').val();
					}
       //   var clasebant = $('#clasebant').val();
        
       // var codartactual = $('#codartactual').val();
        
 //var iddiseno = $('#iddiseno').val();
 
            var loading = $(".loading-" + iddetallle);
            checkboxClickeado.hide();
            loading.show();
   $('#actualizarListSaco').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
               	url:'index.php?page=kanban&accion=enviarprensa',
                data: {
                    'iddetallle': iddetallle,
                   'accion':accion,
                   'proroll_id': proroll_id,
                                        'ini': ini,
                                        'fin': fin,
                                        'procesos':procesos,
                                        'estado':estado,
                                        'prosacodet_id':prosacodet_id,
                                        'clasebant':clasebant
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
          
            
            .done(function (res) {
           
                  $('#actualizarListSaco').html(res);
         
          
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
    });




 $('body').on('click', '#btnActualizarRegistrossacosConv', function (e) {
        e.preventDefault();
        var proroll_id = $('#proroll_id').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
          var maquina = $('#maquina').val();
 
          
        if(procesos == '173'){
			  $('#modal-asignaravanceminirollos').modal('hide');
		}else{
			  $('#modal-asignaravancesacos').modal('hide');
		}

      

        getListaProducionConv(proroll_id, ini, fin, procesos, estado,maquina);

    });
    
  $('body').on('click', '#btnActualizarRegistrossacosConv2', function (e) {
        e.preventDefault();
        var proroll_id = $('#proroll_id').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
          var maquina = $('#maquina').val();
 
          
        if(procesos == '173'){
			  $('#modal-asignaravanceminirollos').modal('hide');
		}else{
			  $('#modal-asignaravancesacos').modal('hide');
		}

      

        getListaProducionConv2(proroll_id, ini, fin, procesos, estado,maquina);

    });
    
      
    
    
    
       var getListaProducionConv = function(proroll_id,ini,fin,procesos,estado,maquina){


		var options = {
			type: 'POST',
			url:'index.php?page=kanban&accion=ajaxGetActualizarListRolloConv',
			data: {
				'proroll_id': proroll_id,
                                        'ini': ini,
                                        'fin': fin,
                                        'procesos':procesos,
                                        'estado':estado,
                                        'proroll_id':proroll_id,
                                        'maquina':maquina
			},
			dataType: 'html',
			success: function(response){

					$('#cargaravanceproduccion').html('');
					$('#cargaravanceproduccion').html(response);
					$('#cargaravanceproduccion').fadeIn('slow');
				
					
			}
		};

		$.ajax(options);				


	};

       var getListaProducionConv2 = function(proroll_id,ini,fin,procesos,estado,maquina){


		var options = {
			type: 'POST',
			url:'index.php?page=kanban&accion=ajaxGetActualizarListRolloConv2',
			data: {
				'proroll_id': proroll_id,
                                        'ini': ini,
                                        'fin': fin,
                                        'procesos':procesos,
                                        'estado':estado,
                                        'proroll_id':proroll_id,
                                        'maquina':maquina
			},
			dataType: 'html',
			success: function(response){

					$('#cargaravanceproduccion').html('');
					$('#cargaravanceproduccion').html(response);
					$('#cargaravanceproduccion').fadeIn('slow');
				
					
			}
		};

		$.ajax(options);				


	};

 
 
 
 
  $('body').on('click', '#cerrarprodrollosconv', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var proroll_id = $(this).data('cerrarprodrollos');
       var progprodet_id = $('#progprodet_id-' + proroll_id).val();
       
       
        var kandet_id = $('#kandet_id-' + proroll_id).val();
    
    var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
         var maquina = $('#maquina').val();
        
        
     var mtrstotales = $('#mtrstotales-' + proroll_id).val();
       var pesototales = $('#pesototales-' + proroll_id).val();
       
          var items = $('#items-'+proroll_id).val();
             var opedido = $('#opedido-'+proroll_id).val();
       
       if(procesos == '173' && mtrstotales > 0){
		     var loading = $(".loading-" + proroll_id);
            checkboxClickeado.hide();
            loading.show();
$('#cargaravanceproduccion').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            
         
            var _options = {
                type: 'POST',
                url: 'index.php?page=kanban&accion=cerrarProduccRollo',
                data: {
                    'proroll_id': proroll_id,
                    'ini': ini,
                    'fin': fin,
                    'procesos':procesos,
                    'estado':estado,
                    'accion': accion,
                    'progprodet_id':progprodet_id,
                    'kandet_id':kandet_id,
                    'maquina':maquina,
                     'items':items,
                    'opedido':opedido
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
            
            
            .done(function (res) {
            $('#cargaravanceproduccion').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
           
	   }else{
		    if (mtrstotales > 0 && pesototales > 0){
            var loading = $(".loading-" + proroll_id);
            checkboxClickeado.hide();
            loading.show();
$('#cargaravanceproduccion').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            
         
            var _options = {
                type: 'POST',
                url: 'index.php?page=kanban&accion=cerrarProduccRolloConv',
                data: {
                    'proroll_id': proroll_id,
                    'ini': ini,
                    'fin': fin,
                    'procesos':procesos,
                    'estado':estado,
                    'accion': accion,
                    'progprodet_id':progprodet_id,
                    'kandet_id':kandet_id,
                    'maquina':maquina,
                    'items':items,
                    'opedido':opedido
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
            
            
            .done(function (res) {
            $('#cargaravanceproduccion').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
           
	   }else{
		   bootbox.alert("Para cerrar la producción, no se admiten valores ceros, tanto en su produccion de metros y peso", function(){});
	   }
		   
	   }

    
	   
	   
    });
  
  $('body').on('click', '#btnguardardatosProdSacosConvfin', function(e){
		e.preventDefault();

        var proroll_id = $('#proroll_id').val();
        var ini = $('#ini').val();
        var fin = $('#fin').val();
        var procesos = $('#procesos').val();
        var estado = $('#estado').val();
        
         var obs = $('#obs').val();
          var emp = $('#emp').val();
        var clasea = $('#clasea').val();
        var telares = $('#telares').val();
        var laminado = $('#laminado').val();
        var impresion = $('#impresion').val();
        var conversion = $('#conversion').val();
        
      
        if(emp>0 && clasea!= '' && telares!= '' && laminado!= '' && impresion!= '' && conversion!= '' ){
			
			
  $('#actualizarListSaco').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>"); 

			var options = {
				type: 'POST',
				url:'index.php?page=kanban&accion=insertarProduccSacoConvfin',
				data: {
					'proroll_id': proroll_id,
                                        'ini': ini,
                                        'fin': fin,
                                        'procesos':procesos,
                                        'estado':estado,
                                        'emp':emp,
                                        'clasea':clasea,
                                        'telares':telares,
                                        'laminado':laminado,
                                        'impresion':impresion,
                                        'conversion':conversion,
                                        'obs':obs
				},
				dataType: 'html',
				success: function(response){
					
						
//					 $('#modal-asignaravance').modal('hide');

//					getLista(proroll_id,ini,fin,procesos,estado);
				}
			};

			$.ajax(options)		
			
		   .done(function (res) {
            $('#actualizarListSaco').html(res);
        })
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });


			
			
		}else{
			  bootbox.alert("Para registrar la produccion, no se admiten valores nulos, revisar nuevamente ( completar los campos con ceros Ó revisar la asignació del operador )", function(){});
		}



	});

		   $('body').on('click', '#mostrarclaseb', function (e) {
        e.preventDefault();

        var id = $(this).data('claseb');

//        var permiso = 'disabled';

        var ver_claseb = $('#ver_claseb');

        var _options = {
            type: 'POST',
            url: 'index.php?page=prensa&accion=ajaxverclaseb',
            data: {
                'id': id
            },
            dataType: 'html',
            success: function (response) {
                ver_claseb.html('');


                $('#datosdisenoTXT').val('');
                $('#datosdisenoTXT').html(id);


                ver_claseb.html(response);

                $('#modal-claseb').modal('show');
            }
        };

        $.ajax(_options);

    });
    
    
    
});









