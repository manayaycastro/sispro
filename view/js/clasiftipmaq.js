

$(document).on('ready', function () {

    $('body').on('click', '#mostrar_form_clasiftipmaq', function (e) {
        e.preventDefault();

        var id_clasiftipmaq = $(this).data('estado');
        var id = $('#id_' + id_clasiftipmaq).val();
        var permiso = 'disabled';

        var ver_form_clasiftipmaq_detalle = $('#ver_form_clasiftipmaq_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=clasiftipmaq&accion=ajaxverdetalleclasiftipmaq',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_clasiftipmaq_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_clasiftipmaq);

                ver_form_clasiftipmaq_detalle.html(response);

                $('#modal-form-clasiftipmaq').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_form_clasiftipmaq', function (e) {
        e.preventDefault();

        var id_clasiftipmaq = $(this).data('estado');
        var id = $('#id_' + id_clasiftipmaq).val();
        var permiso = 'enabled';

        var ver_form_clasiftipmaq_detalle = $('#ver_form_clasiftipmaq_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=clasiftipmaq&accion=ajaxverdetalleclasiftipmaq',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_clasiftipmaq_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_clasiftipmaq);

                ver_form_clasiftipmaq_detalle.html(response);

                $('#modal-form-clasiftipmaq').modal('show');
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