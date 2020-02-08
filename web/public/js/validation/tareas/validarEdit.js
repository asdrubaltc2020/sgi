$(function () {

    $('#boton-enviar').click(function (e) {
        e.preventDefault();
        var enviar = true;

        //validar Tipo de Petición
        var tipoPeticion = $('#tipoPeticion');
        var asunto = $('#asunto');
        var asignadoa = $('#asignadoa');
        var estado = $('#estado');
        var prioridad = $('#prioridad');
        var complejidad = $('#complejidad');
        var fechainicio = $('#fechainicio');
        var fechafin = $('#fechafin');
        var tiempoestimado = $('#tiempoestimado');

        var error_tipo_peticion = $('#error_tipo_peticion');
        var error_asunto = $('#error_asunto');
        var error_asignadoa = $('#error_asignadoa');
        var error_estado = $('#error_estado');
        var error_prioridad = $('#error_prioridad');
        var error_complejidad = $('#error_complejidad');
        var error_fechainicio = $('#error_fechainicio');
        var error_fechafin = $('#error_fechafin');
        var error_tiempoestimado = $('#error_tiempoestimado');

        var check_tipo_peticion = $('#check_tipo_peticion');
        var check_asunto = $('#check_asunto');
        var check_asignadoa = $('#check_asignadoa');
        var check_estado = $('#check_estado');
        var check_prioridad = $('#check_prioridad');
        var check_complejidad = $('#check_complejidad');
        var check_fechainicio = $('#check_fechainicio');
        var check_fechafin = $('#check_fechafin');
        var check_tiempoestimado = $('#check_tiempoestimado');

        var isFocus = false;

        var mensaje_general_error = $('#mensaje_general_error');


        if (tipoPeticion.val() == 0) {
            tipoPeticion.css('border', '1px solid #a94442');
            enviar = false;
            error_tipo_peticion.removeClass('hidden');
            if (!isFocus) {
                isFocus = true;
                tipoPeticion.focus();
            }
            mensaje_general_error.removeClass('hidden');
            check_tipo_peticion.addClass('hidden');
        } else {
            tipoPeticion.css('border', '1px solid #3c763d');
            error_tipo_peticion.addClass('hidden');
            mensaje_general_error.addClass('hidden');
            check_tipo_peticion.removeClass('hidden');
        }

        if (asunto.val() == "") {
            enviar = false;
            asunto.css('border', '1px solid #a94442');
            error_asunto.removeClass('hidden');
            if (!isFocus) {
                isFocus = true;
                asunto.focus();
            }
            mensaje_general_error.removeClass('hidden');
        } else {
            asunto.css('border', '1px solid #3c763d');
            error_asunto.addClass('hidden');
            mensaje_general_error.addClass('hidden');
        }

        if (asignadoa.val() == 0) {
            asignadoa.css('border', '1px solid #a94442');
            enviar = false;
            error_asignadoa.removeClass('hidden');
            if (!isFocus) {
                isFocus = true;
                asignadoa.focus();
            }
            mensaje_general_error.removeClass('hidden');
            check_asignadoa.addClass('hidden');
        } else {
            asignadoa.css('border', '1px solid #3c763d');
            error_asignadoa.addClass('hidden');
            mensaje_general_error.addClass('hidden');
            check_asignadoa.removeClass('hidden');
        }

        if (estado.val() == 0) {
            estado.css('border', '1px solid #a94442');
            enviar = false;
            error_estado.removeClass('hidden');
            if (!isFocus) {
                isFocus = true;
                estado.focus();
            }
            mensaje_general_error.removeClass('hidden');
        } else {
            estado.css('border', '1px solid #3c763d');
            error_estado.addClass('hidden');
            mensaje_general_error.addClass('hidden');
        }

        if (prioridad.val() == 0) {
            prioridad.css('border', '1px solid #a94442');
            enviar = false;
            error_prioridad.removeClass('hidden');
            if (!isFocus) {
                isFocus = true;
                prioridad.focus();
            }
            mensaje_general_error.removeClass('hidden');
        } else {
            prioridad.css('border', '1px solid #3c763d');
            error_prioridad.addClass('hidden');
            mensaje_general_error.addClass('hidden');
        }

        if (complejidad.val() == 0) {
            complejidad.css('border', '1px solid #a94442');
            enviar = false;
            error_complejidad.removeClass('hidden');
            if (!isFocus) {
                isFocus = true;
                complejidad.focus();
            }
            mensaje_general_error.removeClass('hidden');
        } else {
            complejidad.css('border', '1px solid #3c763d');
            error_complejidad.addClass('hidden');
            mensaje_general_error.addClass('hidden');
        }

        if (fechainicio.val() == 0) {
            fechainicio.css('border', '1px solid #a94442');
            enviar = false;
            error_fechainicio.removeClass('hidden');
            if (!isFocus) {
                isFocus = true;
                fechainicio.focus();
            }
            mensaje_general_error.removeClass('hidden');
        } else {
            fechainicio.css('border', '1px solid #3c763d');
            error_fechainicio.addClass('hidden');
            mensaje_general_error.addClass('hidden');
        }

        if (fechafin.val() == 0) {
            fechafin.css('border', '1px solid #a94442');
            enviar = false;
            error_fechafin.removeClass('hidden');
            if (!isFocus) {
                isFocus = true;
                fechafin.focus();
            }
            mensaje_general_error.removeClass('hidden');
        } else {
            fechafin.css('border', '1px solid #3c763d');
            error_fechafin.addClass('hidden');
            mensaje_general_error.addClass('hidden');
        }

        if (tiempoestimado.val() == 0) {
            tiempoestimado.css('border', '1px solid #a94442');
            enviar = false;
            error_tiempoestimado.removeClass('hidden');
            if (!isFocus) {
                isFocus = true;
                tiempoestimado.focus();
            }
            mensaje_general_error.removeClass('hidden');
        } else {
            tiempoestimado.css('border', '1px solid #3c763d');
            error_tiempoestimado.addClass('hidden');
            mensaje_general_error.addClass('hidden');
        }

        if (enviar == true) {
            $('#form').submit();
        }

    });


    $('#tipoPeticion').change(function (e) {
        e.preventDefault();
        var tipoPeticion = $('#tipoPeticion');
        var error_tipo_peticion = $('#error_tipo_peticion');
        var check_tipo_peticion = $('#check_tipo_peticion');

        if (tipoPeticion.val() == 0) {
            tipoPeticion.css('border', '1px solid #a94442');
            error_tipo_peticion.removeClass('hidden');
            check_tipo_peticion.addClass('hidden');
        } else {
            tipoPeticion.css('border', '1px solid #3c763d');
            error_tipo_peticion.addClass('hidden');
            check_tipo_peticion.removeClass('hidden');
        }
    });

    $('#asunto').change(function () {
        var asunto = $('#asunto');
        var error_asunto = $('#error_asunto');
        var check_asunto = $('#check_asunto');

        if (asunto.val() == "") {
            asunto.css('border', '1px solid #a94442');
            error_asunto.removeClass('hidden');
            check_asunto.addClass('hidden');
        } else {
            asunto.css('border', '1px solid #3c763d');
            error_asunto.addClass('hidden');
            check_asunto.removeClass('hidden');
        }
    });

    $('#asignadoa').change(function () {
        var check_asignadoa = $('#check_asignadoa');
        var asignadoa = $('#asignadoa');
        var error_asignadoa = $('#error_asignadoa');

        if (asignadoa.val() == 0) {
            asignadoa.css('border', '1px solid #a94442');
            error_asignadoa.removeClass('hidden');
            check_asignadoa.addClass('hidden');
        } else {
            asignadoa.css('border', '1px solid #3c763d');
            error_asignadoa.addClass('hidden');
            check_asignadoa.removeClass('hidden');
        }
    });

    $('#estado').change(function () {
        var check_estado = $('#check_estado');
        var estado = $('#estado');
        var error_estado = $('#error_estado');

        if (estado.val() == 0) {
            estado.css('border', '1px solid #a94442');
            error_estado.removeClass('hidden');
            check_estado.addClass('hidden');
        } else {
            estado.css('border', '1px solid #3c763d');
            error_estado.addClass('hidden');
            check_estado.removeClass('hidden');
        }
    });

    $('#prioridad').change(function () {
        var check_prioridad = $('#check_prioridad');
        var prioridad = $('#prioridad');
        var error_prioridad = $('#error_prioridad');

        if (prioridad.val() == 0) {
            prioridad.css('border', '1px solid #a94442');
            error_prioridad.removeClass('hidden');
            check_prioridad.addClass('hidden');
        } else {
            prioridad.css('border', '1px solid #3c763d');
            error_prioridad.addClass('hidden');
            check_prioridad.removeClass('hidden');
        }
    });

    $('#complejidad').change(function () {
        var check_complejidad = $('#check_complejidad');
        var complejidad = $('#complejidad');
        var error_complejidad = $('#error_complejidad');

        if (complejidad.val() == 0) {
            complejidad.css('border', '1px solid #a94442');
            error_complejidad.removeClass('hidden');
            check_complejidad.addClass('hidden');
        } else {
            complejidad.css('border', '1px solid #3c763d');
            error_complejidad.addClass('hidden');
            check_complejidad.removeClass('hidden');
        }
    });

    $('#fechainicio').change(function () {
        var check_fechainicio = $('#check_fechainicio');
        var fechainicio = $('#fechainicio');
        var error_fechainicio = $('#error_fechainicio');

        if (fechainicio.val() == "") {
            fechainicio.css('border', '1px solid #a94442');
            error_fechainicio.removeClass('hidden');
            check_fechainicio.addClass('hidden');
        } else {
            fechainicio.css('border', '1px solid #3c763d');
            error_fechainicio.addClass('hidden');
            check_fechainicio.removeClass('hidden');
        }
    });

    $('#fechafin').change(function () {
        var check_fechafin = $('#check_fechafin');
        var fechafin = $('#fechafin');
        var error_fechafin = $('#error_fechafin');

        if (fechafin.val() == "") {
            fechafin.css('border', '1px solid #a94442');
            error_fechafin.removeClass('hidden');
            check_fechafin.addClass('hidden');
        } else {
            fechafin.css('border', '1px solid #3c763d');
            error_fechafin.addClass('hidden');
            check_fechafin.removeClass('hidden');
        }
    });

    $('#tiempoestimado').change(function () {
        var check_tiempoestimado = $('#check_tiempoestimado');
        var tiempoestimado = $('#tiempoestimado');
        var error_tiempoestimado = $('#error_tiempoestimado');

        if (tiempoestimado.val() == "") {
            tiempoestimado.css('border', '1px solid #a94442');
            error_tiempoestimado.removeClass('hidden');
            check_tiempoestimado.addClass('hidden');
        } else {
            tiempoestimado.css('border', '1px solid #3c763d');
            error_tiempoestimado.addClass('hidden');
            check_tiempoestimado.removeClass('hidden');
        }
    });



    $('.input-group.date').datepicker({
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        weekStart: 1,
        language: "es",
        multidate: false,
        daysOfWeekDisabled: "0,6",
        daysOfWeekHighlighted: "0,6",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true
    });

    $('#adjuntos').fileinput({
        theme: 'fa',
        language: 'es',
        uploadUrl: '',
        uploadAsync: false,
        minFileCount: 0,
        maxFileCount: 20,
        showUpload: true,
        showRemove: true,
    });

    $('.btn-add-seg').click(function (e) {
        e.preventDefault();
        $('#contenedor-seguidores').html('');
        var usuarios = new Array();
        var labels_usuarios = new Array();
        var c = 0;
        $("input:checkbox:checked").each(function () {
            if ($(this).hasClass('checkusuarios')) {
                usuarios[c] = $(this).val();
                labels_usuarios[c] = $(this).data('id');
                c++;
            }
        });
        var html = "";

        for (var i = 0; i < usuarios.length; i++) {
            html += "<div class='checkbox checkbox-primary' style='margin:10px 0;'><input type='checkbox' id='" + usuarios[i] + "' value='" + usuarios[i] + "' name='seguidores[" + i + "]' checked><label for='checkbox'>" + labels_usuarios[i] + "</label></div>";
        }

        $('#contenedor-seguidores').append(html);

        $('#myModalSeguidores').modal('hide');
    });

    $('.btn-add-tiempo').click(function (e) {
        e.preventDefault();

        var tarea = $('#id_tarea').val();
        var tiempodedicado = $('#tiempodedicado').val();
        var observacion_tiempo = $('#observacion_tiempo').val();
        var actividad = $('#actividades').val();

        var data = {
            'tarea': tarea,
            'tiempodedicado': tiempodedicado,
            'obseervacion': observacion_tiempo,
            'actividad': actividad
        };

        var url = "/task/addTiempo";

        $.post(url, data, function (result) {
            //El usuario se ah eliminado 
            $('#myModalTiempo').modal('hide');
        });
    });


    $('.btn-add-cambio').click(function (e) {
        e.preventDefault();
        var tarea = $('#id_tarea').val();
        var cambio = $('#cambio_nota');
        var ficheros = $('#formcambios').serialize();

        var enviar = true;
        if (cambio.val() == "") {
            enviar = false;
            $('#error_cambio_nota').removeClass('hidden');
            cambio.css('border', '1px solid #a94442');
        }

        if (enviar == true) {
            $('#formcambios').submit();
        }

    });


    $('.btn-editar').click(function (e) {
        e.preventDefault();

        $('#tipoPeticion').attr('disabled', false);
        $('#asunto').attr('disabled', false);
        $('#descripcion').attr('disabled', false);
        $('#asignadoa').attr('disabled', false);
        $('#estado').attr('disabled', false);
        $('#prioridad').attr('disabled', false);
        $('#complejidad').attr('disabled', false);
        $('#boton-add-seguidores').attr('disabled', false);
        $('#fechainicio').attr('disabled', false);
        $('#fechafin').attr('disabled', false);
        $('#tiempoestimado').attr('disabled', false);
        $('#realizado').attr('disabled', false);
        $('#adjuntos').attr('disabled', false);


        $('#tarea_editable').val(1);

    });
});
