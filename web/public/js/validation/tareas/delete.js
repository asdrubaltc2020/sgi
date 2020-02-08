$(function () {

    $('.btn-delete-tarea').click(function (e) {
        e.preventDefault();

        bootbox.confirm({
            title: "Eliminar tarea",
            message: "¿Esta seguro que desea eliminar la tarea? ",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar',
                    className: 'btn-success'
                },
                confirm: {
                    label: '<i class="fas fa-trash-alt"></i> Confirmar',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result == true) {
                    var tarea = $('#tarea').val();

                    $('#form_delete').submit();
                }
            }
        });
    });

    $('.btn-delete-ajax').click(function (e) {
        e.preventDefault();
        var row = $(this).parents('tr');
        var id = row.data('id');

        var data = {
            'id': id
        };

        var url = "/task/deleteAjax";

        bootbox.confirm({
            title: "Eliminar tarea",
            message: "¿Esta seguro que desea eliminar la tarea? ",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar',
                    className: 'btn-success'
                },
                confirm: {
                    label: '<i class="fas fa-trash-alt"></i> Confirmar',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result == true) {
                    $("#gif" + id).removeClass('hidden');
                    $.post(url, data, function (result) {
                        //El usuario se ah eliminado 
                        row.fadeOut();
                        $("#gif" + id).addClass('hidden');
                        console.log(result.eliminado);
                    });
                }
            }
        });



    });

});
