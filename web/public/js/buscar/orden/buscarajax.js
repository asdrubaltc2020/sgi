$(function () {
    $('.btn-buscar').click(function (e) {
        e.preventDefault();

        var form = $('#form-busqueda');
        var url = form.attr('action');
        var data = form.serialize();


        $('#buscar-progress').removeClass('hidden');
        //Pedido al controlador con ajax
        $.post(url, data, function (result) {
            //El usuario se ah eliminado 

            $('#buscar-progress').addClass('hidden');
            var cuerpoTabla = $('#cuerpo-tabla');
            var proyectos = result.proyectos;
            var html = "";
            var color = "";
            var back = "";
            $.each(proyectos, function (index) {
                if (proyectos[index]['estado'] == 1) {
                    back = "#fcf8e3";
                    color = "#73879C";
                }
                if (proyectos[index]['estado'] == 2) {
                    back = "#3498DB";
                    color = "#fff";
                }
                if (proyectos[index]['estado'] == 3) {
                    back = "#E74C3C";
                    color = "#fff";
                }
                if (proyectos[index]['estado'] == 4) {
                    back = "#1ABB9C";
                    color = "#fff";
                }

                html += "<tr data-id='" + proyectos[index]['id'] + "' style='background:" + back + ";color:" + color + "!important'>";
                html += "<td><a href='/orden_general/manage/"+proyectos[index]['id']+"' style='color:" + color + "'>#" + proyectos[index]['id'] + "</a></td>";
                html += "<td><a href='/orden_general/manage/"+proyectos[index]['id']+"' style='color:" + color + "'>" + proyectos[index]['proyecto'] + "</a></td>";
                html += "<td>" + proyectos[index]['cliente'] + "</td>";
                html += "<td style='text-align: right;'><a  href='/orden_general/manage/"+proyectos[index]['id']+"' class='btn btn-primary btn-xs'><i class='fas fa-info-circle'></i> Ver</a></td>";
                html += "</tr>";

            });

            cuerpoTabla.html(html);

        });


    });

});
