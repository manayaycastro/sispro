/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('ready', function () {

    $('body').on('click', '#mostrar_form_maquina', function (e) {
        e.preventDefault();

        var id_maquina= $(this).data('estado');
        var id = $('#id_' + id_maquina).val();
        var permiso = 'disabled';

        var ver_formmaquina_detalle = $('#ver_formmaquina_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=maquinas&accion=ajaxverdetallemaquina',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formmaquina_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_maquina);

                ver_formmaquina_detalle.html(response);

                $('#modal-form-maquina').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_form_maquina', function (e) {
        e.preventDefault();

        var id_maquina = $(this).data('estado');
        var id = $('#id_' + id_maquina).val();
        var permiso = 'enabled';

        var ver_formmaquina_detalle = $('#ver_formmaquina_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=maquinas&accion=ajaxverdetallemaquina',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formmaquina_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_maquina);

                ver_formmaquina_detalle.html(response);

                $('#modal-form-maquina').modal('show');
            }
        };

        $.ajax(_options);

    });


       $('body').on('click', '#acceso_form_depresiacion', function (e) {
        e.preventDefault();

        var id_maquina = $(this).data('estado');
        var id = $('#id_' + id_maquina).val();
        var permiso = 'disabled';
//alert (id);
        var ver_formmaquina_depresiacion = $('#ver_formmaquina_depresiacion');

        var _options = {
            type: 'POST',
            url: 'index.php?page=maquinas&accion=ajaxverdetalledepresiacion',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formmaquina_depresiacion.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_maquina);

                ver_formmaquina_depresiacion.html(response);

                $('#modal-form-depreciasion').modal('show');
            }
        };

        $.ajax(_options);

    });


    
     $('body').on('click', '#mostrar_form_maquinameta', function (e) {
        e.preventDefault();

        var id_maquina = $(this).data('estado');
        var id = $('#id_' + id_maquina).val();
        var permiso = 'disabled';

        var ver_formmaquinameta_detalle = $('#ver_formmaquinameta_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=maquinas&accion=ajaxverdetallemaquinameta',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formmaquinameta_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_maquina);

                ver_formmaquinameta_detalle.html(response);

                $('#modal-form-maquinameta').modal('show');
            }
        };

        $.ajax(_options);

    });
    $('body').on('click', '#editar_form_maquinameta', function (e) {
        e.preventDefault();

        var id_maquina = $(this).data('estado');
        var id = $('#id_' + id_maquina).val();
        var permiso = 'enabled';

        var ver_formmaquinameta_detalle = $('#ver_formmaquinameta_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=maquinas&accion=ajaxverdetallemaquinameta',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formmaquinameta_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_maquina);

                ver_formmaquinameta_detalle.html(response);

                $('#modal-form-maquinameta').modal('show');
            }
        };

        $.ajax(_options);

    });
    
        $('body').on('click', '#maquina_meta_detalle', function (e) {
        e.preventDefault();

        var id_meta = $(this).data('estado');
        var id = $('#id_' + id_meta).val();
         var anio = $('#id_anio' + id_meta).val();
          var maquina = $('#id_maquina' + id_meta).val();
//        var permiso = 'enabled';

        var ver_meta_detalle = $('#ver_meta_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=maquinas&accion=ajaxverdetallemaquinametadet',
            data: {
                'id': id,
                'anio' : anio,
                'maquina' : maquina
            },
            dataType: 'html',
            success: function (response) {
                ver_meta_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_meta);

                ver_meta_detalle.html(response);

                $('#modal-form-meta-detalle').modal('show');
            }
        };

        $.ajax(_options);

    });
    

    $('body').on('click', '#agregarEstado', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        
        var idmetdet = $(this).data('estado');
        var valormensual = $('#valormensual-' + idmetdet).val();
        var sesion = $('#sesion').val();

       


        if (
                valormensual > 0

                ) {


            var loading = $(".loading-" + idmetdet);



            checkboxClickeado.hide();
            loading.show();

            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
               
            }

            var _options = {
                type: 'POST',
                url: 'index.php?page=maquinas&accion=ajaxmanejarestadometdet',
                data: {
                    'idmetdet': idmetdet,
                    'valormensual': valormensual,
                    'sesion': sesion,
                    'accion': accion
                },
                dataType: 'json',
                success: function (response) {




                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options);

        } else {

            alert("Debe Ingresar un valor valido.") ? "" : location.reload();
        }


    });


    
       $(document).on("click", "#bootbox-confirm-meta", function (e) {

        e.preventDefault();
        bootbox.confirm(" Advertencia!!!  solo se puede generar una programación al año por máquina. ¿Esta seguro que deseas continuar?", function (result) {
            if (result) {
               document.formulariometa.submit();     
            }
        });
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

    
    
//  ************************************* Inicio asignacion de maquina colaborador ************************************
//  ************************************* Inicio asignacion de maquina colaborador ************************************

    $('body').on('click', '#ver_asignacion_maq', function (e) {
        e.preventDefault();

        var id_empleado= $(this).data('estado');
       
        
        var id_emp = $('#id_' + id_empleado).val();
        var id_area = $('#idarea_' + id_empleado).val();
        var nombres = $('#nombres_' + id_empleado).val();
        var permiso = 'disabled';


        var ver_form_maquinacolab_detalle = $('#ver_form_maquinacolab_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=maquinacolab&accion=ajaxverdetallemaquinacolab',
            data: {
                'id_emp': id_emp,
                'id_area': id_area,
                 'nombres': nombres,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_maquinacolab_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(nombres);

                ver_form_maquinacolab_detalle.html(response);

                $('#modal-form-maquinacolab').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_asignacion_maq', function (e) {
        e.preventDefault();

          var id_empleado= $(this).data('estado');
       
        
        var id_emp = $('#id_' + id_empleado).val();
        var id_area = $('#idarea_' + id_empleado).val();
        var nombres = $('#nombres_' + id_empleado).val();
        var permiso = 'enabled';


        var ver_form_maquinacolab_detalle = $('#ver_form_maquinacolab_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=maquinacolab&accion=ajaxverdetallemaquinacolab',
            data: {
                'id_emp': id_emp,
                'id_area': id_area,
                 'nombres': nombres,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_maquinacolab_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(nombres);

                ver_form_maquinacolab_detalle.html(response);

                $('#modal-form-maquinacolab').modal('show');
            }
        };

        $.ajax(_options);

    });
    
    
    
    $('body').on('click', '#asignarmaqemp', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var idmaq = $(this).data('estado'); 
        var id_emp = $('#idemp' + idmaq).val(); 
        var id = $('#id' + idmaq).val(); 
      
 
            var loading = $(".loading-" + idmaq);
            checkboxClickeado.hide();
            loading.show();

            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "reasignar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=maquinacolab&accion=ajaxasignarmaqcol',
                data: {
                    'idmaq': idmaq,
                    'id_emp': id_emp,
                    'id': id,
                    'accion': accion
                },
                dataType: 'json',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options);

  

    });


//  ************************************* fin  asignacion de maquina colaborador ************************************
//  ************************************* fin  asignacion de maquina colaborador ************************************
    
    
    
    
    
    
    
    

    

});