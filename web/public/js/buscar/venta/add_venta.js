$(function () {
    //recoleccion de la data para guardar la venta con ajax


    $('.btn-finalizar-compra').click(function (e) {
        e.preventDefault();
        var form = $('#form-add');

        var url = form.attr('action');
        var venta_progress = $('#venta-progress');
        var id_cliente = $('#id_cliente').val();

        var enviar = true;
        var campo_error = $('#error_venta');
        var campo_error_span = $('#error_venta span');
        var msj_error = "";

        var descuentoall = parseFloat($('#descuentoall').html());
        var total_venta = parseFloat($('#total_venta').html());
        var subtotal_venta = parseFloat($('#subtotal_venta').html());
        var subtotal_iva = parseFloat($('#subtotal_iva').html());
        var nofactura = $('#nofactura').val();
        var descuentofijo = parseFloat($('#descuentofijo').html());
        var item_selected = parseInt($('#item_selected').html());

        var cantFormasPago = parseInt($('#cantFormasPago').val());

        var formasPago = new Array();

        for (var i = 1; i <= cantFormasPago; i++) {

            var idSelectFormaPago = "#formaPagoSelected" + i;
            var selectFormaPago = $(idSelectFormaPago);

            if (selectFormaPago.is(':checked')) {

                //seleccioanr descuento
                var descuento = parseFloat($('#descuento_u' + i).val());
                //seleccionar recagargo
                var recargo = parseFloat($('#recargo' + i).val());
                //seleccionar monto
                var monto = parseFloat($('#pago' + i).val());

                //id tipo forma pago
                var id_forma_pago = selectFormaPago.val();


                var formaP = {
                    "id_forma_pago": id_forma_pago,
                    "descuento": descuento,
                    "recargo": recargo,
                    "monto": monto
                };

                formasPago.push(formaP);

            } else {

            }
        }

        //validacion de los datos

        //validacion del cliente
        if (id_cliente == 0) {
            enviar = false;
            msj_error = "Debe seleccionar un cliente para realizar la venta";
            campo_error_span.html(msj_error);
            campo_error.removeClass('hidden');
        } else {
            campo_error.addClass('hidden');
            msj_error = "";
            campo_error_span.html(msj_error);
        }

        if (nofactura == '') {
            enviar = false;
            msj_error = "Debe ingresar el numero de factura de la venta";
            campo_error_span.html(msj_error);
            campo_error.removeClass('hidden');
            $('#nofactura').css('border', '1px solid red');
        } else {
            campo_error.addClass('hidden');
            msj_error = "";
            campo_error_span.html(msj_error);
            $('#nofactura').css('border', '1px solid #ddd');
        }

        var panel_buscar_cliente = $('#panel_buscar_cliente');

        if (id_cliente == 0) {
            enviar = false;
            msj_error = "Debe seleccionar un cliente para generar la factura";
            campo_error_span.html(msj_error);
            campo_error.removeClass('hidden');
            panel_buscar_cliente.css('border', '1px solid red');
        } else {
            campo_error.addClass('hidden');
            msj_error = "";
            campo_error_span.html(msj_error);
            panel_buscar_cliente.css('border', '1px solid #ddd');
        }

        var panel_resul_productos = $('#panel_resul_productos');
        if (item_selected == 0) {
            enviar = false;
            msj_error = "Debe seleccionar al menos 1 producto para generar la factura";
            campo_error_span.html(msj_error);
            campo_error.removeClass('hidden');
            panel_resul_productos.css('border', '1px solid red');
        } else {
            campo_error.addClass('hidden');
            msj_error = "";
            campo_error_span.html(msj_error);
            panel_resul_productos.css('border', '1px solid #ddd');
        }


        if (!campo_error.hasClass('hidden')) {
            setTimeout(function () {
                campo_error.addClass('hidden');
            }, 5000);
        }



        //obtener la cantidad y los datos de los productos seleccionados

        var num_pro_seleccionados = parseInt($('#item_selected').html());
        var productos = new Array();

        for (var j = 1; j <= num_pro_seleccionados; j++) {
            var idProducto = $('#idproselected' + j).val();
            var cantTalla = parseInt($('#talla_selected').val());

            var producto = {
                'id': idProducto,
                'cantidad': num_pro_seleccionados,
                'talla': cantTalla
            };

            productos.push(producto);
        }

        if (enviar) {
            venta_progress.removeClass('hidden');
            var data = {
                "id_cliente": id_cliente,
                "descuentoall": descuentoall,
                "total_venta": total_venta,
                "subtotal_venta": subtotal_venta,
                "subtotal_iva": subtotal_iva,
                "nofactura": nofactura,
                "descuentofijo": descuentofijo,
                "item_selected": item_selected,
                "fp": formasPago,
                'productos': productos
            };

            $.post(url, data, function (result) {

                venta_progress.addClass('hidden');

                var msj_success = $('#venta_ok');
                msj_success.removeClass('hidden');

                if (!msj_success.hasClass('hidden')) {
                    setTimeout(function () {
                        msj_success.addClass('hidden');
                    }, 3000);
                }
            });
        }

    });






});