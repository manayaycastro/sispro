

$(document).on('ready', function () {

    $('body').on('click', '#mostrar_form_itemformulacion', function (e) {
        e.preventDefault();

        var id_item = $(this).data('estado');
      
        var id = $('#id_' + id_item).val();
        var permiso = 'disabled';

        var ver_itemformulacion_detalle = $('#ver_itemformulacion_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=itemformulacion&accion=ajaxverdetalleitemform',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_itemformulacion_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_item);

                ver_itemformulacion_detalle.html(response);

                $('#modal-form-itemformulacion').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_form_itemformulacion', function (e) {
        e.preventDefault();

        var id_item = $(this).data('estado');
        var id = $('#id_' + id_item).val();
        var permiso = 'enabled';

        var ver_itemformulacion_detalle = $('#ver_itemformulacion_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=itemformulacion&accion=ajaxverdetalleitemform',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_itemformulacion_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_item);

                ver_itemformulacion_detalle.html(response);

                $('#modal-form-itemformulacion').modal('show');
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