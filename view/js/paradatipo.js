

$(document).on('ready', function () {

    $('body').on('click', '#mostrar_form_paradatipo', function (e) {
        e.preventDefault();

        var id_paradatipo = $(this).data('estado');
        var id = $('#id_' + id_paradatipo).val();
        var permiso = 'disabled';

        var ver_form_paradatipo = $('#ver_form_paradatipo');

        var _options = {
            type: 'POST',
            url: 'index.php?page=paradatipo&accion=ajaxverdetalleparadatipo',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_paradatipo.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_paradatipo);

                ver_form_paradatipo.html(response);

                $('#modal-form-paradatipo').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_form_paradatipo', function (e) {
        e.preventDefault();

        var id_paradatipo = $(this).data('estado');
        var id = $('#id_' + id_paradatipo).val();
        var permiso = 'enabled';

        var ver_form_paradatipo = $('#ver_form_paradatipo');

        var _options = {
            type: 'POST',
            url: 'index.php?page=paradatipo&accion=ajaxverdetalleparadatipo',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_paradatipo.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_paradatipo);

                ver_form_paradatipo.html(response);

                $('#modal-form-paradatipo').modal('show');
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