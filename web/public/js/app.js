$(function () {



    $('.botonF1').hover(function () {
        $('.btn-opcion').addClass('animacionVer');
    });


    $('.contenedor-flotante').mouseleave(function () {
        $('.btn-opcion').removeClass('animacionVer');
    })

    var pathname = window.location.pathname;

    //enlaces padres
    var enlaces = $('.enlace-1');

    $.each(enlaces, function () {
        enlaces.removeClass("active open");
    });

    if (pathname === '/inicio') {
        $('#link-inicio').addClass('active').addClass('open');
    }

    if (pathname === '/usuario/') {
        $('#link-admin').addClass('open');
        $('#link-usuarios').addClass('active');
    }

    if (pathname === '/area/') {
        $('#link-admin').addClass('open');
        $('#link-areas').addClass('active');
    }

    if (pathname === '/cliente/') {
        $('#link-admin').addClass('open');
        $('#link-clientes').addClass('active');
    }

    if (pathname === '/tipo_peticiones/') {
        $('#link-admin').addClass('open');
        $('#link-tipopeticiones').addClass('active');
    }

    if (pathname === '/estado_peticiones/') {
        $('#link-admin').addClass('open');
        $('#link-estadopeticiones').addClass('active');
    }

    if (pathname === '/prioridad_peticiones/') {
        $('#link-admin').addClass('open');
        $('#link-prioridades').addClass('active');
    }

    if (pathname === '/complejidad_peticiones/') {
        $('#link-admin').addClass('open');
        $('#link-complejidades').addClass('active');
    }



//    $.each(enlaces, function () {
//        enlaces.removeClass("menu-item-admin-active");
//    });
//
//    if (pathname === '/admin/pedidos/') {
//        $('#enlace-m2').addClass('menu-item-admin-active');
//    }
//    if (pathname === '/ordenes/' || pathname === '/ordenes/listado' || pathname === '/ordenes/mistareas') {
//        $('#enlace-m3').addClass('menu-item-admin-active');
//    }
//    if (pathname === '/ordenes/estadisticas') {
//        $('#enlace-m13').addClass('menu-item-admin-active');
//    }
//
//    if (pathname == '/ordenes/calificaciones') {
//        $('#enlace-m14').addClass('menu-item-admin-active');
//    }
//
//    if (pathname == '/usuarios/') {
//        $('#enlace-m5').addClass('menu-item-admin-active');
//    }
//
//    if (pathname == '/roles/') {
//        $('#enlace-m6').addClass('menu-item-admin-active');
//    }
//    







    //herramienta de mensajes cortos
    $('[data-toggle="tooltip"]').tooltip();






});