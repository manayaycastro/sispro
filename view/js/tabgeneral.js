

$(document).on('ready', function () {

    $('body').on('click', '#mostrar_form_tabgen', function (e) {
        e.preventDefault();

        var id_tabgen = $(this).data('estado');
        var id = $('#id_' + id_tabgen).val();
        var permiso = 'disabled';

        var ver_form_tabgen_detalle = $('#ver_form_tabgen_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=tabgeneral&accion=ajaxverdetalletabgen',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_tabgen_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_tabgen);

                ver_form_tabgen_detalle.html(response);

                $('#modal-form-tabgen').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_form_tabgen', function (e) {
        e.preventDefault();

        var id_tabgen = $(this).data('estado');
        var id = $('#id_' + id_tabgen).val();
        var permiso = 'enabled';

        var ver_form_tabgen_detalle = $('#ver_form_tabgen_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=tabgeneral&accion=ajaxverdetalletabgen',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_tabgen_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_tabgen);

                ver_form_tabgen_detalle.html(response);

                $('#modal-form-tabgen').modal('show');
            }
        };

        $.ajax(_options);

    });


    $(document).on("click", "#bootbox-confirm", function (e) {
        var link = $(this).attr("href"); // "get" the intended link in a var
        e.preventDefault();
        bootbox.confirm("¿Esta seguro de querer eliminar el registro?", function (result) {
            if (result) {
                document.location.href = link;  // if result, "set" the document location       
            }
        });
    });

      $('body').on('click', '#tabgen', function (e) {
        e.preventDefault();

        var tabgen_id = $(this).data('estado');
         var id = $('#id_' + tabgen_id).val();
        var mostrardatos = $('#mostrardatos');
      
        var _options = {
            type: 'POST',
            url: 'index.php?page=tabgeneral&accion=ajaxFormRegisTabGenDet',
            data: {
                'tabgen_id': tabgen_id
               
            },
            dataType: 'html',
            success: function (response) {
                mostrardatos.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(tabgen_id);


                mostrardatos.html(response);

                $('#modal-form-tabgendet').modal('show');
//                    modalasignarinic.modal('show');
            }
        };

        $.ajax(_options);

    });
    
    
    
    $('body').on('click', '#btnguardardatos', function(e){
		e.preventDefault();

        var tabgen_id = $('#tabgen_id').val();
        var tabgendet_nombre= $('#tabgendet_nombre').val();
     

  $('#actualizar').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>"); 

			var options = {
				type: 'POST',
				url:'index.php?page=tabgeneral&accion=insertarDet',
				data: {
					'tabgen_id': tabgen_id,
                                        'tabgendet_nombre': tabgendet_nombre
				},
				dataType: 'html',
				success: function(response){

				}
			};

			$.ajax(options)		
			
		   .done(function (res) {
            $('#actualizar').html(res);
        })
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });




	});

});