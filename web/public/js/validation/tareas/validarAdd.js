$(function () {

    $('#boton-enviar').click(function (e) {
        e.preventDefault();
        var enviar = true;

        //validar Tipo de Petición
        var asunto = $('#asunto');
        var asignadoa = $('#asignadoa');
        var estado = $('#estado');
        var prioridad = $('#prioridad');
        var fechainicio = $('#fechainicio');
        var fechafin = $('#fechafin');

        var error_asunto = $('#error_asunto');
        var error_asignadoa = $('#error_asignadoa');
        var error_estado = $('#error_estado');
        var error_prioridad = $('#error_prioridad');
        var error_fechainicio = $('#error_fechainicio');
        var error_fechafin = $('#error_fechafin');


        var isFocus = false;

        var mensaje_general_error = $('#mensaje_general_error');

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
        } else {
            asignadoa.css('border', '1px solid #3c763d');
            error_asignadoa.addClass('hidden');
            mensaje_general_error.addClass('hidden');
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


        if (enviar == true) {
            $('#form').submit();
        }
    });

    $('#asunto').change(function () {
        var asunto = $('#asunto');
        var error_asunto = $('#error_asunto');

        if (asunto.val() == "") {
            asunto.css('border', '1px solid #a94442');
            error_asunto.removeClass('hidden');
            check_asunto.addClass('hidden');
        } else {
            asunto.css('border', '1px solid #3c763d');
            error_asunto.addClass('hidden');
        }
    });

    $('#asignadoa').change(function () {
        var asignadoa = $('#asignadoa');
        var error_asignadoa = $('#error_asignadoa');

        if (asignadoa.val() == 0) {
            asignadoa.css('border', '1px solid #a94442');
            error_asignadoa.removeClass('hidden');
        } else {
            asignadoa.css('border', '1px solid #3c763d');
            error_asignadoa.addClass('hidden');
        }
    });

    $('#estado').change(function () {
        var estado = $('#estado');
        var error_estado = $('#error_estado');

        if (estado.val() == 0) {
            estado.css('border', '1px solid #a94442');
            error_estado.removeClass('hidden');
        } else {
            estado.css('border', '1px solid #3c763d');
            error_estado.addClass('hidden');
        }
    });

    $('#prioridad').change(function () {
        var prioridad = $('#prioridad');
        var error_prioridad = $('#error_prioridad');

        if (prioridad.val() == 0) {
            prioridad.css('border', '1px solid #a94442');
            error_prioridad.removeClass('hidden');
        } else {
            prioridad.css('border', '1px solid #3c763d');
            error_prioridad.addClass('hidden');
        }
    });

    $('#complejidad').change(function () {
        var complejidad = $('#complejidad');
        var error_complejidad = $('#error_complejidad');

        if (complejidad.val() == 0) {
            complejidad.css('border', '1px solid #a94442');
            error_complejidad.removeClass('hidden');
        } else {
            complejidad.css('border', '1px solid #3c763d');
            error_complejidad.addClass('hidden');
        }
    });

    $('#fechainicio').change(function () {
        var fechainicio = $('#fechainicio');
        var error_fechainicio = $('#error_fechainicio');

        if (fechainicio.val() == "") {
            fechainicio.css('border', '1px solid #a94442');
            error_fechainicio.removeClass('hidden');
        } else {
            fechainicio.css('border', '1px solid #3c763d');
            error_fechainicio.addClass('hidden');
        }
    });

    $('#fechafin').change(function () {
        var fechafin = $('#fechafin');
        var error_fechafin = $('#error_fechafin');

        if (fechafin.val() == "") {
            fechafin.css('border', '1px solid #a94442');
            error_fechafin.removeClass('hidden');
        } else {
            fechafin.css('border', '1px solid #3c763d');
            error_fechafin.addClass('hidden');
        }
    });

    $('#tiempoestimado').change(function () {
        var tiempoestimado = $('#tiempoestimado');
        var error_tiempoestimado = $('#error_tiempoestimado');

        if (tiempoestimado.val() == "") {
            tiempoestimado.css('border', '1px solid #a94442');
            error_tiempoestimado.removeClass('hidden');
        } else {
            tiempoestimado.css('border', '1px solid #3c763d');
            error_tiempoestimado.addClass('hidden');
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
});
