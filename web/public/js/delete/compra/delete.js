$(function () {
    $('.btn-delete').click(function (e) {
        e.preventDefault();

        var row = $(this).parents('tr');
        var id = row.data('id');
        var form = $('#form');
        var url = form.attr('action').replace('COMPRA_ID', id);
        var data = {'id': id};

        console.log(url);

        bootbox.confirm({
            title: "Eliminar Compra",
            message: "¿Esta seguro que desea eliminar el Compra? ",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar',
                    className: 'btn-success'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Eliminar',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result == true) {
                    $('#delete-progress').removeClass('hidden');
                    //Pedido al controlador con ajax
                    $.post(url, data, function (result) {
                        $('#total').html(result.cantidad);
                        $('#delete-progress').addClass('hidden');
                        row.fadeOut();

                    })

                }
            }
        });


    });

});
