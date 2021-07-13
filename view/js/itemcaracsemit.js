

$(document).on('ready', function () {

    $('body').on('click', '#mostrar_form_itemcaracsemit', function (e) {
        e.preventDefault();

        var id_itemcaracsemit = $(this).data('estado');
      
        var id = $('#id_' + id_itemcaracsemit).val();
        var permiso = 'disabled';

        var ver_formitemcaracsemi_id_detalle = $('#ver_formitemcaracsemi_id_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=itemcaracsemit&accion=ajaxverdetalleitemcaracsemit',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formitemcaracsemi_id_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_itemcaracsemit);

                ver_formitemcaracsemi_id_detalle.html(response);

                $('#modal-form-itemcaracsemi_id').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_form_itemcaracsemit', function (e) {
        e.preventDefault();

        var id_itemcaracsemit = $(this).data('estado');
        var id = $('#id_' + id_itemcaracsemit).val();
        var permiso = 'enabled';

        var ver_formitemcaracsemi_id_detalle = $('#ver_formitemcaracsemi_id_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=itemcaracsemit&accion=ajaxverdetalleitemcaracsemit',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formitemcaracsemi_id_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_itemcaracsemit);

                ver_formitemcaracsemi_id_detalle.html(response);

                $('#modal-form-itemcaracsemi_id').modal('show');
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


});