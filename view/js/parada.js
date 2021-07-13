/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('ready', function () {

    $('body').on('click', '#mostrar_form_parada', function (e) {
        e.preventDefault();

        var id_parada = $(this).data('estado');
        var id = $('#id_' + id_parada).val();
        var permiso = 'disabled';


        var ver_formparada_detalle = $('#ver_formparada_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=parada&accion=ajaxverdetalleparada',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formparada_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_parada);

                ver_formparada_detalle.html(response);

                $('#modal-form-parada').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_form_parada', function (e) {
        e.preventDefault();

        var id_parada = $(this).data('estado');
        var id = $('#id_' + id_parada).val();
        var permiso = 'enabled';

        var ver_formparada_detalle = $('#ver_formparada_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=parada&accion=ajaxverdetalleparada',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formparada_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_parada);

                ver_formparada_detalle.html(response);

                $('#modal-form-parada').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#parada_registro', function (e) {
        e.preventDefault();




        var formparada_reg = $('#formparada_reg');

        var _options = {
            type: 'POST',
            url: 'index.php?page=parada&accion=ajaxparadareg',
            data: {
            },
            dataType: 'html',
            success: function (response) {
                formparada_reg.html('');


                formparada_reg.html(response);

                $('#modal-form-paradareg').modal('show');
            }
        };

        $.ajax(_options);

    });


    $('#area_id').on('change', function (e) {
        e.preventDefault();

        var area_id = $(this).val();

        if (area_id != -1) {
            getmaquina(area_id);
        } else {
            $('#maquina_id').attr('disabled', 'disabled');
            $('#maquina_id').val('-1');
        }
    });

    var getmaquina = function (area_id) {
        
      //  alert ("ingreso");
        var options = {
            type: 'POST',
            url: 'index.php?page=parada&accion=ajaxGetmaquina',
            data: {'area_id': area_id},
            datatype: 'html',
            success: function (response) {
                $('#maquina_id').removeAttr('disabled');
                $('#maquina_id').html(response);

            }
        };
        $.ajax(options);
    };




    $('#tippar_id').on('change', function (e) {
        e.preventDefault();

        var parada = $(this).val();

        if (parada != -1) {
            getparada(parada);
        } else {
            $('#par_id').attr('disabled', 'disabled');
            $('#par_id').val('-1');
        }
    });

    var getparada = function (tippar_id) {
        var options = {
            type: 'POST',
            url: 'index.php?page=parada&accion=ajaxGetparada',
            data: {'tippar_id': tippar_id},
            datatype: 'html',
            success: function (response) {
                $('#par_id').removeAttr('disabled');
                $('#par_id').html(response);

            }
        };
        $.ajax(options);
    };


    $(document).on("click", "#bootbox-confirm", function (e) {
        var link = $(this).attr("href"); // "get" the intended link in a var
        e.preventDefault();
        bootbox.confirm("¿Esta seguro de querer eliminar el registro?", function (result) {
            if (result) {
                document.location.href = link;  // if result, "set" the document location       
            }
        });
    });


    $('body').on('click', '#editar_parada', function (e) { //2020-12-11
        e.preventDefault();

        var id_parada = $(this).data('estado');


        var ver_formparadas = $('#ver_formparadas');

        var _options = {
            type: 'POST',
            url: 'index.php?page=parada&accion=ajaxparadas',
            data: {
                'id_parada': id_parada
            },
            dataType: 'html',
            success: function (response) {
                ver_formparadas.html('');


                $('#datosActualParada').val('');
                $('#datosActualParada').html(id_parada);


                ver_formparadas.html(response);

                $('#modal-regisparada').modal('show');
            }
        };

        $.ajax(_options);

    });



});
