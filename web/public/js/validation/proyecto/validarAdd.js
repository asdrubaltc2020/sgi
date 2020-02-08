$(function () {

    $('.checkusuarios').click(function (e) {

        var check = $(this).is(':checked');
        var val = $(this).val();
        if (check == true) {
            $('#perfil' + val).removeClass('hidden');
        } else {
            $('#perfil' + val).addClass('hidden');
        }
    });

    $('#btn-guardar-brief').click(function (e) {
        e.preventDefault();

        var url = "http://localhost/womtask2/web/orden_general/asociarBriefAjax";

        var radios = $('.briefAll:checked');
        if (radios.val() == null) {
            $('#error_brief_select').removeClass('hidden');
        } else {
            $('#error_brief_select').addClass('hidden');

            var numero_brief_sel = $('#numero_brief_sel').val();
            var id_brief_sel = $('#id_brief_sel').val();
            var proyecto_brief_sel = $('#proyecto_brief_sel').val();
            var cliente_brief_sel = $('#cliente_brief_sel').val();
            var resposable_brief_sel = $('#responsable_brief_sel').val();

            var html = "";
            html += '<div class="contenedor-brief-asociado">';
            html += '<h4 style="margin-top:0px;"><span class="label label-default">Brief asociado</span></h4>';
            html += '<label>Brief No: ' + numero_brief_sel + '</label><br/>';
            html += '<label>Proyecto: ' + proyecto_brief_sel + '</label><br/>';
            html += '<label>Cliente: ' + cliente_brief_sel + '</label><br/>';
            html += '<label>Resposnable: ' + resposable_brief_sel + '</label>';
            html += '</div>';

            $('#cont-brief-asociado').html(html);

            $('#addBrief').modal('hide');
        }
    });

    $('#boton-limpiar-busqueda').click(function (e) {
        e.preventDefault();
        $('#tipobrief').val(0);
        $('#cliente_buscar_brief').val(0);
        $('#proyecto_buscar_brief').val('');
        $('#cont_result').html("");
        $('#error_brief_select').addClass('hidden');
    });

    $('.btn-asociar-boton').click(function () {
        $('#tipobrief').val(0);
        $('#cliente_buscar_brief').val(0);
        $('#proyecto_buscar_brief').val('');
        $('#cont_result').html("");
        $('#error_brief_select').addClass('hidden');
    });

    $('#cont_result').on('click', '.briefAll', function () {
        //asignamos los valores del brief seleccionado
        var radios = $('.briefAll:checked');
        var row = radios.parents('tr');
        var numero_brief = row.data('id');
        var id_brief = row.children('.brief_id_sel');
        var brief_sel_proyecto = row.children('.brief_sel_proyecto');
        var brief_sel_cliente = row.children('.brief_sel_cliente');
        var brief_sel_responsable = row.children('.brief_sel_responsable');
        var tipobrief_busqueda = $('#tipobrief');

        $('#numero_brief_sel').val(numero_brief);
        $('#id_brief_sel').val(id_brief.html());
        $('#proyecto_brief_sel').val(brief_sel_proyecto.html());
        $('#cliente_brief_sel').val(brief_sel_cliente.html());
        $('#responsable_brief_sel').val(brief_sel_responsable.html());
        $('#tipo_brief').val(tipobrief_busqueda.val());

    });


    $('#boton-buscar-brief').click(function (e) {
        e.preventDefault();

        var tipobrief = $('#tipobrief').val();
        var cliente_buscar_brief = $('#cliente_buscar_brief').val();
        var proyecto_buscar_brief = $('#proyecto_buscar_brief').val();


        var error_tipobrief_buscar = $('#error_tipobrief_buscar');
        var cont_result = $('#cont_result');

        if (tipobrief == 0) {
            $('#tipobrief').css('border-color:red');
            error_tipobrief_buscar.removeClass('hidden');
        } else {
            $('#tipobrief').css('border-color:#ccc');
            error_tipobrief_buscar.addClass('hidden');
        }

        var data = {
            'tipobrief': tipobrief,
            'cliente_buscar_brief': cliente_buscar_brief,
            'proyecto_buscar_brief': proyecto_buscar_brief
        };

        var url = "http://localhost/womtask2/web/orden_general/addBriefAjax";
        if (tipobrief > 0) {
            $('.progress-buscando').removeClass('hidden');
            $.post(url, data, function (result) {
                var briefsR = result.briefs;
                $('.progress-buscando').addClass('hidden');

                if (result.cantidadBriefs > 0) {
                    var html = "";
                    html += '<div class="table-responsive">';
                    html += '<table class="table table-striped table-hover" id="tabla-resultado">';
                    html += '<thead><tr>\n\
                       <th width="5%">No</th>\n\
                       <th width="25%">Proyecto</th>\n\
                       <th width="25%">Cliente</th>\n\
                       <th width="25%">Responsable</th> ';
                    html += '<th width="10%"></th></tr></thead>';

                    $.each(briefsR, function (index) {
                        html += '<tr data-id="' + briefsR[index]['orden'] + '">';
                        html += '<td class="brief_id_sel">' + briefsR[index]['id'] + '</td>';
                        html += '<td class="brief_sel_proyecto">' + briefsR[index]['proyecto'] + '</td>';
                        html += '<td class="brief_sel_cliente">' + briefsR[index]['cliente'] + '</td>';
                        html += '<td class="brief_sel_responsable">' + briefsR[index]['responsable'] + '</td>';
                        html += '<td class="cont-radios"><input type="radio"  class="briefAll" name="briefS" value=' + briefsR[index]['id'] + '></td>';
                        html += '</tr>';

                    });
                    html += '</table>';
                    html += '</div>';

                    cont_result.html(html);
                } else {
                    var resultadoVacio = "<h2>No existen brief para sus busqueda</h2>";
                    resultadoVacio += "<a href='' class='btn btn-success'>Nuevo Brief</a>";
                    cont_result.html(resultadoVacio);
                }


            });
        }
    });



    $('#boton-cancelar').click(function (e) {
        e.preventDefault();
        $('#form')[0].reset();
    });

    $('#boton-enviar').click(function (e) {
        e.preventDefault();
        var enviar = true;

        var proyecto = $('#proyecto');
        var fechaInicio = $('#fechaInicio');
        var cliente = $('#cliente');
        var tipoOrden = $('#tipoOrden');
        var tipoFacturacion = $('#tipoFacturacion');
        var estadoFacturacion = $('#estadoFacturacion');
        var estado = $('#estado');

        var error_proyecto = $('#error_proyecto');
        var error_fechaInicio = $('#error_fechaInicio');
        var error_cliente = $('#error_cliente');
        var error_tipoOrden = $('#error_tipoOrden');
        var error_tipoFacturacion = $('#error_tipoFacturacion');
        var error_estadoFacturacion = $('#error_estadoFacturacion');
        var error_estado = $('#error_estado');

        if (proyecto.val() == "") {
            enviar = false;
            error_proyecto.removeClass('hidden');
            proyecto.css('border-color', '#a94442');
            proyecto.focus();
        } else {
            error_proyecto.addClass('hidden');
            proyecto.css('border-color', '#5cb85c');
        }

        if (fechaInicio.val() == "") {
            enviar = false;
            error_fechaInicio.removeClass('hidden');
            fechaInicio.css('border-color', '#a94442');
        } else {
            error_fechaInicio.addClass('hidden');
            fechaInicio.css('border-color', '#5cb85c');
        }

        if (cliente.val() == 0) {
            enviar = false;
            error_cliente.removeClass('hidden');
            cliente.css('border-color', '#a94442');
        } else {
            error_cliente.addClass('hidden');
            cliente.css('border-color', '#5cb85c');
        }

        if (tipoOrden.val() == 0) {
            enviar = false;
            error_tipoOrden.removeClass('hidden');
            tipoOrden.css('border-color', '#a94442');
        } else {
            error_tipoOrden.addClass('hidden');
            tipoOrden.css('border-color', '#5cb85c');
        }

        if (tipoFacturacion.val() == 0) {
            enviar = false;
            error_tipoFacturacion.removeClass('hidden');
            tipoFacturacion.css('border-color', '#a94442');
        } else {
            error_tipoFacturacion.addClass('hidden');
            tipoFacturacion.css('border-color', '#5cb85c');
        }

        if (estadoFacturacion.val() == 0) {
            enviar = false;
            error_estadoFacturacion.removeClass('hidden');
            estadoFacturacion.css('border-color', '#a94442');
        } else {
            error_estadoFacturacion.addClass('hidden');
            estadoFacturacion.css('border-color', '#5cb85c');
        }

        if (estado.val() == 0) {
            enviar = false;
            error_estado.removeClass('hidden');
            estado.css('border-color', '#a94442');
        } else {
            error_estado.addClass('hidden');
            estado.css('border-color', '#5cb85c');
        }

        var cont_result = $('#cont_result');
        var error_brief = $('#error_brief');

        if (cont_result.html() == "") {
            enviar = false;
            error_brief.removeClass('hidden');
        } else {
            error_brief.addClass('hidden');
        }

        //validar los usuarios seleccionados y sus perfiles
        var cantidadUsuarios = 0;
        $("input:checkbox:checked").each(function () {
            if ($(this).hasClass('checkusuarios')) {
                var val = $(this).val();
                var select = $('#perfil' + val).val();

                if (select == 0) {
                    $('#error_perfil' + val).removeClass('hidden');
                    enviar = false;
                } else {
                    $('#error_perfil' + val).addClass('hidden');
                }
            }
        });

        if (enviar == true) {
            $('#form').submit();
        }
    });

    $('.input-group.date').datepicker({
        format: "mm/dd/yyyy",
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
});
