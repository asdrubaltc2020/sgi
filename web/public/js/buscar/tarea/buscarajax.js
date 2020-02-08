$(function () {
    $('.btn-tarea-buscar-ajax').click(function (e) {
        e.preventDefault();

        var form = $('#form-busqueda-tarea');
        var url = form.attr('action');
        var data = form.serialize();


        $('#buscar-progress').removeClass('hidden');

        //Pedido al controlador con ajax
        $.post(url, data, function (result) {
            var cuerpoTabla = $('#cuerpo-tabla-tareas');
            var tareas = result.tareas;
            var html = "";
            var color = "";
            var back = "";
            $('#buscar-progress').addClass('hidden');

            $.each(tareas, function (index) {

                var barra = "";
                var realizado = tareas[index]['realizado'];

                if (realizado <= 30) {
                    barra += "<div class='progress' style='margin-bottom: 0;'>";
                    barra += "<div class='progress-bar progress-bar-danger' role='progressbar' aria-valuenow='60' aria-valuemin='0' aria-valuemax='100' style='width: {{tarea.realizado}}%;'>";
                    barra += realizado + "%";
                    barra += "</div>";
                    barra += "</div>";
                }

                html += "<tr data-id='" + tareas[index]['id'] + "'>";
                html += "<td>" + tareas[index]['id'] + "</td>";
                html += "<td>" + tareas[index]['asunto'] + "</td>";
                html += "<td>" + tareas[index]['estado'] + "</td>";
                html += "<td>" + tareas[index]['asignadoa'] + "</td>";
                html += "<td>" + barra + "</td>";
                html += "<td style='text-align: right;'>";
                html+="<a href='/task/edit/"+tareas[index]['id']+"' class='btn btn-xs btn-success'><i class='far fa-eye'></i></a>";
                html+="<a href='#' class='btn btn-xs btn-danger btn-delete-ajax'><i class='fas fa-trash-alt'></i></a>";
                html += "</td>";
                html += "</tr>";

            });

            cuerpoTabla.html(html);
        });


    });

});
