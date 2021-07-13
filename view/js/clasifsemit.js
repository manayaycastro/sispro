

$(document).on('ready', function () {

    $('body').on('click', '#mostrar_form_clasifsemit', function (e) {
        e.preventDefault();

        var id_clasifsemit = $(this).data('estado');
        var id = $('#id_' + id_clasifsemit).val();
        var permiso = 'disabled';

        var ver_form_clasifsemit_detalle = $('#ver_form_clasifsemit_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=clasifsemit&accion=ajaxverdetalleclasifsemit',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_clasifsemit_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_clasifsemit);

                ver_form_clasifsemit_detalle.html(response);

                $('#modal-form-clasifsemit').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_form_clasifsemit', function (e) {
        e.preventDefault();

        var id_clasifsemit = $(this).data('estado');
        var id = $('#id_' + id_clasifsemit).val();
        var permiso = 'enabled';

        var ver_form_clasifsemit_detalle = $('#ver_form_clasifsemit_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=clasifsemit&accion=ajaxverdetalleclasifsemit',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_clasifsemit_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_clasifsemit);

                ver_form_clasifsemit_detalle.html(response);

                $('#modal-form-clasifsemit').modal('show');
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