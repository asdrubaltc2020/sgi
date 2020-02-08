
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

        //actualizar la variable que contiene el id del cliente
        $('#id_cliente').val(0);

    });

    $('.btn_check_forma').click(function (e) {
        var row = $(this).parents('tr');
        var id = row.data('id');

        //obtener el valor del descuento si aplica
        var descuento = parseFloat($('#descuento_u' + id).val());
        var recargo = parseFloat($('#recargo' + id).val());

        var valorCambio = descuento - recargo;
        console.log(valorCambio);

        var totalDescuentoFP = parseFloat($('#totalDescuentoFP').val());

        if ($(this).is(':checked')) {
            totalDescuentoFP += valorCambio;
        } else {
            totalDescuentoFP -= valorCambio;
        }

        $('#totalDescuentoFP').val(totalDescuentoFP);

        console.log('Total descuento:' + totalDescuentoFP);

        //total de la venta
        var total = parseFloat($('#total_venta').html());

        //aplicando el descuento por forma de pago
        var newTotal = total - (total * parseFloat(totalDescuentoFP)) / 100;

        $('#total_final').html(newTotal.toFixed(2));
        $('#total_final_h').val(newTotal.toFixed(2));

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

                $.each(clientes, function (index) {
                    html += "<tr data-id='" + clientes[index]['id'] + "'>";
                    html += "<td>" + clientes[index]['nombres'] + " " + clientes[index]['apellidos'] + "</td>";
                    html += "<td>" + clientes[index]['ci'] + "/ " + clientes[index]['ruc'] + "</td>";
                    html += "<td><a href='#' class='btn btn-xs btn-success btn-add'><i class='fas fa-plus'></i></td>";
                    html += "</tr>";
                });

                cuerpoTablaCliente.html(html);
            });
        }else{
            cuerpoTablaCliente.html('')
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

        //contenedor para las variable de la cantidad de productos por tallas
        var cont_tallas_cantidad = $('#cont_tallas_cantidad');

        if (codigo != "") {
            //Pedido al controlador con ajax
            $.post(url, data, function (result) {
                var productos = result.productos;

                var tallas = result.tallas;

                var tallasText = "";
                var select = "";
                var tallasVal = "";
                select += "<select name='tallasproresult' id='tallasproresult' class='form-control'>";
                $.each(tallas, function (index) {
                    select += "<option value='" + tallas[index]['id'] + "'>" + tallas[index]['descripcion'] + "</option>";
                    tallasVal += "<input type='hidden' id='talla" + tallas[index]['id'] + "' value='" + tallas[index]['cantidad'] + "'/>";
                });

                select += "</select>";

                cont_tallas_cantidad.html(tallasVal);

                $.each(productos, function (index) {

                    html += "<tr data-id='" + productos[index]['id'] + "'>";
                    html += "<td style='padding-top:14px;'>" + productos[index]['codigo'] + "</td>";
                    html += "<td style='padding-top:14px;'>" + productos[index]['producto'] + "</td>";
                    html += "<td style='text-align:center;padding-top:14px;' id='cont_total_items'><input type='hidden' id='totalitems' value='" + productos[index]['total'] + "'><span>" + productos[index]['total'] + "</span></td>";
                    html += "<td><input type='number' name='cantidadselect' id='cantidadselect' placeholder='Cantidad' class='form-control' style='margin-top:0px;' min='1' value='1'/></td>";
                    html += "<td class='cont-select-tallas'>";
                    html += select;
                    html += "</td>";
                    html += "<td style='text-align: center;padding-top:14px;'>" + productos[index]['pvp'] + "</td>";
                    html += "<td style='position:relative;padding-top:14px;'><a href='#' class='btn btn-success btn-xs btn-add-pro' style='position:absolute;width:85%;'><i class='fas fa-cart-plus'></i></td>";
                    html += "</tr>";

                });
                cuerpoTabla.html(html);
            }
            );
        }
    });

    //adicionar el cliente a la factura
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

            $('#id_cliente').val(cliente['id']);
        });
    });

    //eliminar el producto de los productos seleccionados
    $('#cuerpo_tabla_producto_select').on('click', '.btn-del-pro', function (e) {

        e.preventDefault();
        var row = $(this).parents('tr');
        var id = row.data('id');
        var precio = parseFloat(row.data('precio'));
        var subtotal = parseFloat($('#subtotal_venta').html());

        subtotal = subtotal - precio;

        var iva_sistema = parseFloat('0.' + $('#iva_sistema').val());

        var iva = parseFloat(subtotal * iva_sistema);

        $('#subtotal_venta').html(subtotal.toFixed(2));
        $('#subtotal_iva').html(iva.toFixed(2));

        var desAll = 0;
        var descuentoall = parseFloat($('#descuentoall').html());

        var total = parseFloat(subtotal + iva);

        if (descuentoall > 0) {
            var desAll = (subtotal * descuentoall) / 100;
            total = subtotal - desAll;
        }

        //descuento fijo al monto global mas iva
        var descuentofijo = parseFloat($('#descuentofijo').html());

        //descuento monto fijo
        total = total - descuentofijo;

        $('#total_venta').html(total.toFixed(2));
        $('#totalnd').val(total.toFixed(2));


        //actualizar cantidad de elementos seleccionados al carrito
        var item_selected = parseInt($('#item_selected').html());
        item_selected--;
        $('#item_selected').html(item_selected);

        //determianr la talla seleccioanda y la cantidad
        var idtalla = '#talla_selected' + id;
        var idCantTalla = '#cantidad_seleted' + id;

        var talla = $(idtalla).val();
        var cantidadTalla = parseInt($(idCantTalla).html());

        //seleccionar la variable talla y actualizar su valor
        var idTallaVar = '#talla' + talla;

        var objTalla = $(idTallaVar);

        var newCantidadTalla = parseInt(objTalla.val()) + parseInt(cantidadTalla);
        objTalla.val(newCantidadTalla);

        //actualziar el total de items totales en stock
        var cantidadStock = parseInt($('#totalitems').val());

        console.log(cantidadTalla);

        var newCantidadStock = cantidadStock + cantidadTalla;
        $('#totalitems').val(newCantidadStock);

        $('#cont_total_items span').html(newCantidadStock);

        row.fadeOut();


    });

    $('#cuerpo_tabla_result_producto').on('change', '#cantidadselect', function (e) {

        var cantidad_temp = $(this).val();

        var talla = $('#tallasproresult').val();

        var idTalla = "#talla" + talla;
        var cantidadDisponibleTalla = $(idTalla).val();

        if (cantidad_temp > cantidadDisponibleTalla) {
            $(this).val(cantidadDisponibleTalla);
            var msj = $('#error_cantidad').removeClass('hidden');

            if (msj != null) {
                setTimeout(function () {
                    msj.addClass('hidden');
                }, 3000);
            }

        } else {
            $('#error_cantidad').addClass('hidden');
        }

    });


    $('#cuerpo_tabla_result_producto').on('click', '.btn-add-pro', function (e) {
        e.preventDefault();
        var row = $(this).parents('tr');
        var id = row.data('id');

        var cantidad = $('#cantidadselect').val();
        var talla = $('#tallasproresult').val();

        var idTalla = "#talla" + talla;

        var totalitems = $('#totalitems').val();
        var cont_total_items = $('#cont_total_items span');

        //verificar que el producto seleccionado se encuentra en stock
        //obtener cantidad de productos de la talla seleccionada
        var cantidadDisponibleTalla = $(idTalla).val();

        if (cantidadDisponibleTalla > 0) {

            totalitems = totalitems - cantidad;
            cont_total_items.html(totalitems);
            $('#totalitems').val(totalitems);

            var url = "/ventas/ventaaddproductoajax";
            var data = {
                'id': id
            }

            var cantidad_pro_selected = parseInt($('#item_selected').html());

            $.post(url, data, function (result) {

                var producto = result.producto;

                //var row = $('#cuerpo_tabla_producto_select').html();
                var row = "";
                var tabla = $('#cuerpo_tabla_producto_select');

                cantidad_pro_selected += 1;
                $('#item_selected').html(cantidad_pro_selected);

                var precio = parseFloat(producto['precio']);
                var subtotal = cantidad * precio;

                row += "<tr style='height:53px;' data-id=" + cantidad_pro_selected + " data-precio=" + producto['precio'] + " data-subtotal=" + subtotal + " >";
                row += "<td style='padding: 14px 2px 0px 5px;'>" + producto['producto'] + "<input type='hidden' id='idproselected" + cantidad_pro_selected + "' value='" + producto['id'] + "'><input type='hidden' value='" + talla + "' id='talla_selected" + cantidad_pro_selected + "'/></td>";
                row += "<td style='padding: 14px 2px 0px 5px;' id='proselected_precio" + cantidad_pro_selected + "'>" + producto['precio'] + " <span>USD</span></td>";
                row += "<td style='text-align:center;padding: 14px 2px 0px 5px;' id='cantidad_seleted" + cantidad_pro_selected + "'>" + cantidad + " </td>";
                row += "<td style='text-align:center;padding: 8px 2px 0px 5px;'><input type='text' name='descuento" + cantidad_pro_selected + "' id='descuento" + cantidad_pro_selected + "' class='form-control control_descuento_pro_selected' placeholder='0'/></td>";
                row += "<td style='text-align:center;padding: 14px 2px 0px 5px;'><span id='valor_subtotal_pro" + cantidad_pro_selected + "'>" + subtotal + "</span></td>";
                row += "<td style='text-align:center;padding: 14px 2px 0px 5px;s'><a href='#' class='btn btn-xs btn-danger btn-del-pro'><i class='fas fa-trash-alt'></i></a></td>";
                row += "</tr>";

                tabla.append(row);

                //calculos para el resumen 
                var subtotal_actual = parseFloat($('#subtotal_venta').html());
                subtotal_actual += subtotal;
                $('#subtotal_venta').html(subtotal_actual.toFixed(2));

                //calcular el aumento del iva
                var iva_sistema = parseFloat(result.iva);
                var subtotalIva = parseFloat(iva_sistema * subtotal_actual);

                $('#subtotal_iva').html(subtotalIva.toFixed(2));

                var total = subtotal_actual + subtotalIva;

                //determianr los decuentos existentes
                //descuento global en % a todos los productos
                var descuentoall = parseFloat($('#descuentoall').html());

                //descuento fijo al monto global mas iva
                var descuentofijo = parseFloat($('#descuentofijo').html());

                var desAll = (total * descuentoall) / 100;

                total = total - desAll;

                //descuento monto fijo

                total = total - descuentofijo;
                $('#total_venta').html(total.toFixed(2));
                $('#totalnd').val(total.toFixed(2));

                //disminuir en 1 la cantidad disponible de articulos para la talla seleccionada
                $(idTalla).val(cantidadDisponibleTalla - cantidad);

            });
        } else {
            var msj = $('#error_cantidad').removeClass('hidden');

            if (msj != null) {
                setTimeout(function () {
                    msj.addClass('hidden');
                }, 3000);
            }
        }

    });

    //cambios en el campo de descuento en % del producto ya seleccionado
    $('#cuerpo_tabla_producto_select').on('keyup', '.control_descuento_pro_selected', function (e) {
        var row = $(this).parents('tr');
        var id = row.data('id');

        var por_descuento = parseFloat($(this).val());


        if ($(this).val() != '') {
            var subtotal = parseFloat(row.data('subtotal')).toFixed(2);
            //campo subatotal
            var id_campo = '#valor_subtotal_pro' + id;
            var valor_subtotal_pro = $(id_campo);
            var iva_sistema = parseFloat('0.' + $('#iva_sistema').val());

            var newSubtotal = ((subtotal * por_descuento) / 100);
            var newPrecio = parseFloat(subtotal - newSubtotal).toFixed(2);

            valor_subtotal_pro.html(newPrecio);

            //variable para almacenar el total de la venta
            var total = 0;

            //actualizar la tabla de importes globales
            var obj_subtotal_venta = $('#subtotal_venta');
            var obj_subtotal_iva = $('#subtotal_iva');
            var obj_descuentoall = $('#descuentoall');
            var obj_descuentofijo = $('#descuentofijo');
            var obj_total_venta = $('#total_venta');

            var subtotal_venta = parseFloat(obj_subtotal_venta.html());
            var subtotal_iva = parseFloat(obj_subtotal_iva.html());
            var descuentoall = parseFloat(obj_descuentoall.html());
            var descuentofijo = parseFloat(obj_descuentofijo.html());


            //calculo y actualizacion de los datos
            //re-calcular el total del subtotal

            //obtengo la cantidad de productos seleccionados
            var cantidadProductosSelected = parseInt($('#item_selected').html());

            var subTotalTemporal = 0;
            var ivaTemporal = 0;

            for (i = 1; i <= cantidadProductosSelected; i++) {
                var id = '#valor_subtotal_pro' + i;
                subTotalTemporal += parseFloat($(id).html());
            }

            subtotal_venta = parseFloat(subTotalTemporal);
            ivaTemporal = parseFloat((subTotalTemporal * iva_sistema));



            //le sumamos el iva al precio total
            total = parseFloat(subTotalTemporal + ivaTemporal);
            //calculamos el descuento total en % si aplica
            var desAll = 0;
            if (descuentoall > 0) {
                var desAll = (total * descuentoall) / 100;
                total = total - desAll;
            }

            //descontamos en caso que aplique el descuento en monto fijo
            if (descuentofijo > 0) {
                total = parseFloat(total - descuentofijo);
            }

            //actualizar los datos en la vista
            obj_subtotal_venta.html(subtotal_venta.toFixed(2));
            obj_subtotal_iva.html(ivaTemporal.toFixed(2));
            obj_total_venta.html(total.toFixed(2));

        }



    });


    $('#btn-modal-descuentoall').click(function (e) {
        e.preventDefault();
        var descuentoall = parseFloat($('#descuentoall').html()).toFixed(2);

        $('#descuentoall_modal').val(descuentoall);
    });

    $('#btn-modal-descuentofijo').click(function (e) {
        e.preventDefault();
        var descuentofijo = parseFloat($('#descuentofijo').html()).toFixed(2);

        $('#descuentofijo_modal').val(descuentofijo);
    });


    $('.btn-save-desall').click(function (e) {

        e.preventDefault();
        var des = $('#descuentoall_modal').val();
        $('#descuentoall').html(des);

        //actualizar el monto total
        var total_venta = parseFloat($('#totalnd').val()).toFixed(2); //valor actual de la venta
        var desF = parseFloat(des).toFixed(2);
        ; //descuento nuevo en % parseado a float
        var desAll = (total_venta * desF) / 100; //descuento ya en dolares del descuento globla en %
        var descuentofijo = parseFloat($('#descuentofijo').html()).toFixed(2); //descuento fijo actual
        total_venta = total_venta - desAll - descuentofijo;

        $('#total_venta').html(total_venta);
        $('#modalalldescuento').modal('hide');

    });

    $('.btn-save-desfijo').click(function (e) {
        e.preventDefault();

        var desfijo = $('#descuentofijo_modal').val();
        $('#descuentofijo').html(desfijo);

        //actualizar el monto total
        var total_venta = parseFloat($('#totalnd').val()).toFixed(2); //valor total de la venta
        var des = parseFloat($('#descuentoall').html()).toFixed(2);
        var desF = parseFloat(des).toFixed(2); //descuento nuevo en % parseado a float
        var desAll = (total_venta * desF) / 100; //descuento ya en dolares del descuento globla en %
        var descuentofijo = parseFloat($('#descuentofijo').html()).toFixed(2); //descuento fijo actual
        total_venta = total_venta - desAll - descuentofijo;

        $('#total_venta').html(total_venta);
        $('#modaldescuentofijo').modal('hide');
    });

    $('.btn-buscar-venta').click(function(e){
        e.preventDefault();

        var factura=$('#factura_buscar').val();
        var cliente=$('#cliente_buscar').val();

        var data={
            "factura": factura,
            "cliente": cliente
        }

        var url=$('#form-busqueda').attr('action');

    });



});