$(function () {

    $('#myGrid').on('.btn-delete','click',function(){
        e.preventDefault();

        var row = $(this).parents('tr');
        var id = row.data('id');
        var form = $('#form');
        var url = form.attr('action').replace('COLOR_ID', id);
        var data = {'id': id};

        bootbox.confirm({
            title: "Eliminar Color",
            message: "¿Esta seguro que desea eliminar el Color? ",
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
    })
});
