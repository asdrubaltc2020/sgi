$(function () {

    $("#form-buscar-producto").keypress(function (e) {
        if (e.which == 13) {
            return false;
        }
    });

    $('.btn-limpiar-cliente').click(function (e) {
        e.preventDefault();

        $('#nombre_re').html('');
        $('#ci_re').html('');
        $('#telefono_re').html('');
        $('#email_re').html('');
        $('#direccion_re').html('');
    });


    $('.btn-info-venta-ind').click(function (e) {
        e.preventDefault();

        var row = $(this).parents('tr');
        var id = row.data('id');

        $('#progress-load-factura').removeClass('hidden');

        var url = "/ventas/cargarfacturaajax";
        var data = {
            'id': id
        }

        $.post(url, data, function (result) {

            $('#progress-load-factura').addClass('hidden');

            var venta = result.venta;
            var tipoCliente = venta.tipocliente;

            $('#pop_numerofactura').html(venta['id']);

            if (tipoCliente == "PERSONA") {
                $('#pop-nombres').html(venta['nombre']);
                $('#pop-ciruc').html(venta['ci']);
            } else {
                $('#pop-nombres').html(venta['razonsocial']);
                $('#pop-ciruc').html(venta['ruc']);
            }

            $('#pop-fecha').html(venta['fecha']);
            $('#pop-hora').html(venta['hora']);
            $('#pop-tipocliente').html(tipoCliente);
            $('#pop-vendedor').html(venta['vendedor']);
            $('#pop-direccion').html(venta['direccion']);

            //carga de los productos de la factura
            var productos = result.productos;
            var html = "";

            $.each(productos, function (index) {
                html += "<tr>";
                html += "<td>" + productos[index]['producto'] + "</td>";
                html += "<td style='text-align: center;'>" + productos[index]['cantidad'] + "</td>";
                html += "<td style='text-align: center;'>" + productos[index]['descuento'] + "</td>";
                html += "<td style='text-align: center;'>" + productos[index]['unitario'] + "</td>";
                html += "<td style='text-align: center;'>" + productos[index]['total'] + "</td>";
                html += "</tr>";
            });

            $('#result-pro-factura').html(html);
            
            $('#pop_cantproductos').html(venta['cantproductos']);
            $('#pop_subtotal').html(venta['subtotal']);
            $('#pop_iva').html(venta['iva']);
            $('#pop_descuentos').html(venta['descuentos']);
            $('#pop_fijos').html(venta['fijos']);
            $('#pop_total').html(venta['total']);

        });

    });

    $('#filtro_cliente').keyup(function (e) {
        e.preventDefault();
        var form = $('#form-buscar-cliente');
        var url = form.attr('action');
        var data = form.serialize();

        var codigo = $('#filtro_cliente').val();
        var html = "";
        var cuerpoTablaCliente = $('#cuerpo_tabla_result_cliente');

        if (codigo != "") {
            $.post(url, data, function (result) {
                var clientes = result.clientes;
                var cantidad = result.cantidad;

                console.log(cantidad);
                $.each(clientes, function (index) {
                    html += "<tr data-id='" + clientes[index]['id'] + "'>";
                    html += "<td>" + clientes[index]['nombres'] + " " + clientes[index]['apellidos'] + "</td>";
                    html += "<td>" + clientes[index]['ci'] + "/ " + clientes[index]['ruc'] + "</td>";
                    html += "<td><a href='#' class='btn btn-xs btn-primary btn-add'><i class='fas fa-plus'></i></td>";
                    html += "</tr>";
                });

                cuerpoTablaCliente.html(html);
            });
        }

    });

    $('#filtro_busqueda').keyup(function (e) {
        e.preventDefault();

        var form = $('#form-buscar-producto');
        var url = form.attr('action');
        var data = form.serialize();

        var html = "";
        var cuerpoTabla = $('#cuerpo_tabla_result_producto');

        var codigo = $('#filtro_busqueda').val();
        if (codigo == "") {
            cuerpoTabla.html('');
        }

        if (codigo != "") {
            //Pedido al controlador con ajax
            $.post(url, data, function (result) {
                var productos = result.productos;
                var proTallas = result.productoTallas;
                var tallas = result.tallas;

                var tallasText = "";
                var select = "";
                select += "<select name='tallasproresult' id='tallasproresult' class='form-control'>";
                $.each(tallas, function (index) {
                    select += "<option value='" + tallas[index]['id'] + "'>" + tallas[index]['descripcion'] + "</option>";
                });

                select += "</select>";


                $.each(productos, function (index) {

                    html += "<tr data-id='" + productos[index]['id'] + "'>";
                    html += "<td style='padding-top:14px;'>" + productos[index]['codigo'] + "</td>";
                    html += "<td style='padding-top:14px;'>" + productos[index]['producto'] + "</td>";
                    html += "<td style='text-align:center;padding-top:14px;'>" + productos[index]['total'] + "</td>";
                    html += "<td><input type='number' name='cantidadselect' id='cantidadselect' placeholder='Cantidad' class='form-control' style='margin-top:0px;' min='1' value='1'/></td>";
                    html += "<td>";
                    html += select;
                    html += "</td>";
                    html += "<td style='text-align: center;padding-top:14px;'>" + productos[index]['pvp'] + "</td>";
                    html += "<td style='position:relative;padding-top:14px;'><a href='#' class='btn btn-success btn-xs btn-add-pro' style='position:absolute;width:85%;'><i class='fas fa-cart-plus'></i></td>";
                    html += "</tr>";
                });
                cuerpoTabla.html(html);
            });
        }
    });


    $('#cuerpo_tabla_result_cliente').on('click', '.btn-add', function (e) {
        e.preventDefault();
        var row = $(this).parents('tr');
        var id = row.data('id');

        var url = "/ventas/ventaaddclienteajax";
        var data = {
            'id': id
        }

        $.post(url, data, function (result) {
            var cliente = result.cliente;

            var nombres = cliente['nombres'] + " " + cliente['apellidos'];

            $('#nombre_re').html(nombres);
            $('#ci_re').html(cliente['ci'] + "/" + cliente['ruc']);
            $('#telefono_re').html(cliente['telefono'] + "/" + cliente['celular']);
            $('#email_re').html(cliente['email']);
            $('#direccion_re').html(cliente['direccion']);
        });

    });
    //eliminar el producto de los productos seleccionados
    $('#cuerpo_tabla_producto_select').on('click', '.btn-del-pro', function (e) {

        e.preventDefault();
        var row = $(this).parents('tr');
        var id = row.data('id');

        console.log(id);


    });

    $('#cuerpo_tabla_result_producto').on('click', '.btn-add-pro', function (e) {
        e.preventDefault();
        var row = $(this).parents('tr');
        var id = row.data('id');

        var cantidad = $('#cantidadselect').val();
        var talla = $('tallasproresult').val();

        var url = "/ventas/ventaaddproductoajax";
        var data = {
            'id': id,
        }

        var cantidad_pro_selected = parseInt($('#item_selected').html());


        $.post(url, data, function (result) {

            var producto = result.producto;

            var row = $('#cuerpo_tabla_producto_select').html();
            var tabla = $('#cuerpo_tabla_producto_select');

            var precio = parseFloat(producto['precio']);
            var subtotal = cantidad * precio;

            row += "<tr style='height:53px;' data-id=" + producto['id'] + ">";
            row += "<td style='padding: 14px 2px 0px 5px;'>" + producto['producto'] + "</td>";
            row += "<td style='padding: 14px 2px 0px 5px;'>" + producto['precio'] + " USD</td>";
            row += "<td style='text-align:center;padding: 8px 2px 0px 5px;'><input type='number' name='cantidad" + producto['id'] + "' id='cantidad" + producto['id'] + "' class='form-control' min='1' value=" + cantidad + " />";
            row += "<td style='text-align:center;padding: 8px 2px 0px 5px;'><input type='text' name='descuento" + producto['id'] + "' id='descuento" + producto['id'] + "' class='form-control' placeholder='0%'/></td>";
            row += "<td style='text-align:center;padding: 14px 2px 0px 5px;'>" + subtotal + "</td>";
            row += "<td style='text-align:center;padding: 14px 2px 0px 5px;s'><a href='#' class='btn btn-xs btn-danger btn-del-pro'><i class='fas fa-trash-alt'></i></a></td>";
            row += "</tr>";

            cantidad_pro_selected += 1;
            $('#item_selected').html(cantidad_pro_selected);

            tabla.html(row);

            //calculos para el resumen 
            var subtotal_actual = parseFloat($('#subtotal_venta').html());
            subtotal_actual += subtotal;
            $('#subtotal_venta').html(subtotal_actual);

            //calcular el aumento del iva
            var iva_sistema = parseFloat(result.iva);
            var subtotalIva = iva_sistema * subtotal_actual;

            $('#subtotal_iva').html(subtotalIva);

            var total = subtotal_actual + subtotalIva;

            //determianr los decuentos existentes
            //descuento global en % a todos los productos
            var descuentoall = parseFloat($('#descuentoall').html());

            //descuento fijo al monto global mas iva
            var descuentofijo = parseFloat($('#descuentofijo').html());

            var desAll = (total * descuentoall) / 100;

            total = total - desAll;

            //descuento monto fijo
            var descuentofijo = parseFloat($('#descuentofijo').html());
            total = total - descuentofijo;


            $('#total_venta').html(total);
            $('#totalnd').val(total);
        });



    });

    $('#btn-modal-descuentoall').click(function (e) {
        e.preventDefault();
        var descuentoall = parseFloat($('#descuentoall').html());

        $('#descuentoall_modal').val(descuentoall);
    });

    $('#btn-modal-descuentofijo').click(function (e) {
        e.preventDefault();
        var descuentofijo = parseFloat($('#descuentofijo').html());

        $('#descuentofijo_modal').val(descuentofijo);
    });


    $('.btn-save-desall').click(function (e) {

        e.preventDefault();
        var des = $('#descuentoall_modal').val();
        $('#descuentoall').html(des);

        //actualizar el monto total
        var total_venta = parseFloat($('#totalnd').val()); //valor actual de la venta
        var desF = parseFloat(des); //descuento nuevo en % parseado a float
        var desAll = (total_venta * desF) / 100; //descuento ya en dolares del descuento globla en %
        var descuentofijo = parseFloat($('#descuentofijo').html()); //descuento fijo actual
        total_venta = total_venta - desAll - descuentofijo;

        $('#total_venta').html(total_venta);
        $('#modalalldescuento').modal('hide');

    });

    $('.btn-save-desfijo').click(function (e) {
        e.preventDefault();

        var desfijo = $('#descuentofijo_modal').val();
        $('#descuentofijo').html(desfijo);

        //actualizar el monto total
        var total_venta = parseFloat($('#totalnd').val()); //valor total de la venta
        var des = parseFloat($('#descuentoall').html());
        var desF = parseFloat(des); //descuento nuevo en % parseado a float
        var desAll = (total_venta * desF) / 100; //descuento ya en dolares del descuento globla en %
        var descuentofijo = parseFloat($('#descuentofijo').html()); //descuento fijo actual
        total_venta = total_venta - desAll - descuentofijo;

        $('#total_venta').html(total_venta);
        $('#modaldescuentofijo').modal('hide');
    });


    $('.btn-finalizar-compra').click(function (e) {
        e.preventDefault();

    });





});
