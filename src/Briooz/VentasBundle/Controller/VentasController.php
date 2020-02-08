<?php

namespace Briooz\VentasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use \Briooz\TaskBundle\Entity\Producto;
use \Briooz\TaskBundle\Entity\Cliente;
use \Briooz\TaskBundle\Entity\ProductoTalla;
use \Briooz\VentasBundle\Entity\Venta;
use \Briooz\TaskBundle\Entity\VentaProducto;
use \Briooz\VentasBundle\Entity\VentaFormaPago;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

class VentasController extends Controller {

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $ventas = $em->getRepository('BrioozVentasBundle:Venta')->findBy(array(),array('id'=>'DESC'));
        $delete_form_ajax = $this->createCustomForm('VENTA_ID', 'DELETE', 'briooz_venta_delete');

        return $this->render('BrioozVentasBundle:Ventas:index.html.twig', array('ventas' => $ventas, 'delete_form_ajax' => $delete_form_ajax->createView()));
    }

    public function addAction() {
        $em = $this->getDoctrine()->getManager();
        $iva = $this->container->getParameter('iva');

        //cargar las formas de pago
        $formaspago = $em->getRepository('BrioozTaskBundle:FormaPago')->findAll();
        $cantFormasPago = count($formaspago);

        return $this->render('BrioozVentasBundle:Ventas:add.html.twig', array('iva' => $iva, 'formaspago' => $formaspago, 'cantFormasPago' => $cantFormasPago));
    }

    public function addClienteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');

        $cliente = $em->getRepository('BrioozTaskBundle:Cliente')->find($id);

        $clienteR = array();
        if ($cliente != null) {
            $clienteR['id'] = $cliente->getId();
            $clienteR['nombres'] = $cliente->getNombres();
            $clienteR['apellidos'] = $cliente->getApellidos();
            $clienteR['celular'] = $cliente->getCelular();
            $clienteR['telefono'] = $cliente->getTelefono();
            $clienteR['ci'] = $cliente->getCi();
            $clienteR['ruc'] = $cliente->getRuc();
            $clienteR['direccion'] = $cliente->getDireccion();
            $clienteR['email'] = $cliente->getEmail();
        }

        return new Response(
                json_encode(array('cliente' => $clienteR)), 200, array('Content-Type' => 'application/json')
        );
    }

    public function addProductoAjaxAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');

        $producto = $em->getRepository('BrioozTaskBundle:Producto')->find($id);

        $producroR = array();
        if ($producto != null) {
            // $producto = new Producto();
            $producroR['id'] = $producto->getId();
            $producroR['codigointerno'] = $producto->getCodigoInterno();
            $producroR['producto'] = $producto->getModelo()->getDescripcion() . " " . $producto->getCategoria()->getDescripcion() . " - cod(" . $producto->getCodigoInterno() . ")";
            $producroR['precio'] = $producto->getPvp();
        }

        $iva = '0.' . $this->container->getParameter('iva');

        return new Response(
                json_encode(array('producto' => $producroR, 'iva' => $iva)), 200, array('Content-Type' => 'application/json')
        );
    }

    public function cargarFacturaAjaxAction(Request $requet) {
        $em = $this->getDoctrine()->getManager();
        $id = $requet->get('id');

        $venta = $em->getRepository('BrioozVentasBundle:Venta')->find($id);

        $ventaResult = array();
        //$venta = new Venta();
        if ($venta != null) {
            $ventaResult['id'] = $venta->getId();
            $ventaResult['tipocliente'] = $venta->getCliente()->getTipoCliente();

            $cliente = $venta->getCliente();

            if ($venta->getCliente()->getTipoCliente() == "PERSONA") {
                $ventaResult['nombre'] = $cliente->getNombres() . " " . $cliente->getApellidos();
                $ventaResult['ci'] = $cliente->getCi();
            } else {
                $ventaResult['razonsocial'] = $cliente->getNombreEmpresa();
                $ventaResult['ruc'] = $cliente->getRuc();
            }

            $ventaResult['fecha'] = $venta->getFecha()->format('Y-m-d');
            $ventaResult['hora'] = $venta->getHora()->format('H:i:s');

            $vendedor = $venta->getUsuario();
            $ventaResult['vendedor'] = $vendedor->getNombre() . " " . $vendedor->getApellidos();
            $ventaResult['direccion'] = $cliente->getDireccion();

            //buscar los productos de la venta
            $ventaproductos = $em->getRepository('BrioozTaskBundle:VentaProducto')->findBy(array('venta' => $venta->getid()));

            $productos = array();

            $pro = array();
            $proResult = array();
            foreach ($ventaproductos as $vp) {
                $proR = $em->getRepository('BrioozTaskBundle:Producto')->find($vp->getProducto()->getId());
                $pro['producto'] = "[" . $proR->getCodigoInterno() . "] " . $proR->getModelo()->getDescripcion() . " " . $proR->getCategoria()->getDescripcion();
                $pro['cantidad'] = $vp->getCantidad();
                $pro['descuento'] = $vp->getDescuento();
                $pro['unitario'] = $proR->getPvp();
                $pro['total'] = $vp->getTotal();

                if ($pro != null) {
                    $proResult[] = $pro;
                }
            }

            //datos de los costos de la factura
            $ventaResult['cantproductos'] = $venta->getCantproductos();
            $ventaResult['subtotal'] = $venta->getSubTotal();
            $ventaResult['iva'] = $venta->getIva();
            $ventaResult['descuentos'] = $venta->getDescuentos();
            $ventaResult['fijos'] = $venta->getDescuentoFijo();
            $ventaResult['total'] = $venta->getTotal();
        }


        return new Response(
                json_encode(array('id' => $id, 'venta' => $ventaResult, 'productos' => $proResult)), 200, array('Content-Type' => 'application/json')
        );
    }


    public function buscarclienteAction(Request $requet) {
        $em = $this->getDoctrine()->getManager();

        $filtro = $requet->get('filtro_cliente');

        $dql = "SELECT u FROM BrioozTaskBundle:Cliente u  WHERE u.ci LIKE :filtro or u.nombres LIKE :filtro or u.apellidos LIKE :filtro ORDER BY u.id DESC";
        $parameters = array('filtro' => '%' . $filtro . '%');
        $consulta = $em->createQuery($dql)->setMaxResults(4);
        $consulta->setParameters($parameters);

        $clientes = $consulta->getResult();

        $cliente = array();
        $clientesResult = array();

        if (count($clientes) > 0) {
            foreach ($clientes as $cl) {

                $cliente['id'] = $cl->getId();
                $cliente['nombres'] = $cl->getNombres();
                $cliente['apellidos'] = $cl->getApellidos();
                $cliente['ci'] = $cl->getCi();
                $cliente['ruc'] = $cl->getRuc();

                $clientesResult[] = $cliente;
            }
        }


        return new Response(
                json_encode(array('cantidad' => count($clientesResult), 'clientes' => $clientesResult)), 200, array('Content-Type' => 'application/json')
        );
    }

    public function buscarVentaAjaxAction(Request $requet){

        return new Response(
            json_encode(array('cantidad' => 1)), 200, array('Content-Type' => 'application/json')
        );
    }



    public function buscarProductoAction(Request $requet) {
        $em = $this->getDoctrine()->getManager();

        $codigo = $requet->get('filtro_busqueda');
        //$codigo = "JNN2KBN";

        $dql = "SELECT u FROM BrioozTaskBundle:Producto u  WHERE u.codigoInterno LIKE :codigo ORDER BY u.id DESC";
        $parameters = array('codigo' => '%' . $codigo . '%');

        $consulta = $em->createQuery($dql);
        $consulta->setParameters($parameters);

        $productos = $consulta->getResult();

        $producto = array();
        $productosResult = array();
        $cantidadTallas = array();
        $alltallas = array();

        if ($productos != null) {
            foreach ($productos as $pr) {

                $producto['id'] = $pr->getId();
                $producto['codigo'] = $pr->getCodigoInterno();
                $producto['total'] = $pr->getTotal();
                $producto['pvp'] = $pr->getPvp();
                $producto['producto'] = $pr->getModelo()->getDescripcion() . " " . $pr->getCategoria()->getDescripcion() . "";

                $productosResult[] = $producto;

                $proTallas = $em->getRepository('BrioozTaskBundle:ProductoTalla')->findBy(array('producto' => $pr->getId()));

                foreach ($proTallas as $proT) {
                    $alltallas[] = $proT->getTalla();
                    $cantidadTallas[$proT->getTalla()->getId()] = $proT->getCantidad();
                }
            }
        }


        if ($codigo == "") {
            $productosResult = array();
        }

        //  $alltallas=$em->getRepository('BrioozTaskBundle:Talla')->findAll();

        $tallas = array();
        $tallasResult = array();
        if (count($alltallas) > 0) {
            foreach ($alltallas as $talla) {

                $tallas['id'] = $talla->getId();
                $tallas['descripcion'] = $talla->getDescripcion();
                $tallas['cantidad'] = $cantidadTallas[$talla->getId()];
                $tallasResult[] = $tallas;
            }
        }

        return new Response(
                json_encode(array('productos' => $productosResult, 'tallas' => $tallasResult)), 200, array('Content-Type' => 'application/json')
        );
    }

    public function editAction($id) {
        
    }

    public function updateAction(Request $request) {
        
    }

    //crear la venta
    public function creadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $usuario = $this->getUser();
        $cliente = $em->getRepository('BrioozTaskBundle:Cliente')->find($request->get('id_cliente'));

        $descuentoall = $request->get('descuentoall');
        $total_venta = $request->get('total_venta');
        $subtotal_venta = $request->get('subtotal_venta');
        $subtotal_iva = $request->get('subtotal_iva');
        $nofactura = $request->get('nofactura');
        $descuentofijo = $request->get('descuentofijo');
        $item_selected = $request->get('item_selected');

        $fecha = date('Y-m-d');
        $hora = date('H:i:s');


        $venta = new Venta();
        $venta->setUsuario($usuario);
        $venta->setCliente($cliente);
        $venta->setDescuentos($descuentoall);
        $venta->setTotal($total_venta);
        $venta->setSubTotal($subtotal_venta);
        $venta->setIva($subtotal_iva);
        $venta->setNoFactura($nofactura);
        $venta->setDescuentoFijo($descuentofijo);
        $venta->setCantproductos($item_selected);
        $venta->setFecha($fecha);
        $venta->setHora($hora);

        $em->persist($venta);
        $em->flush();

        $formasPago = $request->get('fp');

        foreach ($formasPago as $fp) {
            $ventaFP = new VentaFormaPago();

            $id_forma_pago = $fp['id_forma_pago'];
            $descuento = $fp['descuento'];
            $recargo = $fp['recargo'];
            $monto = $fp ['monto'];

            $ventaFP->setDescuento($descuento);
            $ventaFP->setFormaPago($em->getRepository('BrioozTaskBundle:FormaPago')->find($id_forma_pago));
            $ventaFP->setMonto($monto);
            $ventaFP->setRecargo($recargo);
            $ventaFP->setVenta($venta);

            $em->persist($ventaFP);
            $em->flush();
        }

        //productos relacionados con la venta
        $productos = $request->get('productos');

        if ($productos != null) {

            foreach ($productos as $prod) {
                $idProducto = $prod['id'];
                $cantidad = $prod['cantidad'];
                $talla = $prod['talla'];

                $productoObj = $em->getRepository('BrioozTaskBundle:Producto')->find($idProducto);

                //actualizar los datos del producto
                //actualizar los valores del stock del producto
                $stockProducto = $productoObj->getTotal();
                $stockProducto = $stockProducto - $cantidad;

                $productoObj->setTotal($stockProducto);
                $em->persist($productoObj);
                $em->flush();

                //buscar los registros de producto talla
                $productoTalla = $em->getRepository('BrioozTaskBundle:ProductoTalla')->findOneBy(array('producto1' => $idProducto, 'talla' => $talla));

                if ($productoTalla != null) {
                    $cantidadTalla = $productoTalla->getCantidad();
                    $cantidadTalla = $cantidadTalla - $cantidad;
                    $productoTalla->setCantidad($cantidadTalla);
                    $em->persist($productoTalla);
                    $em->flush();
                }

                //nuevo registro ventaProducto
                $ventaProducto = new VentaProducto();

                $ventaProducto->setCantidad($cantidad);
                $ventaProducto->setProducto($productoObj);
                $ventaProducto->setVenta($venta);

                $em->persist($ventaProducto);
                $em->flush();
            }
        }

        return new Response(
                json_encode(array('id' => 1)), 200, array('Content-Type' => 'application/json')
        );
    }

    public function deleteAction(Request $request) {
        
    }


    public function printTestAction(){
        $connector = new FilePrintConnector("php://stdout");
        $printer = new Printer($connector);

        /* Height and width */
        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
        $printer->text("Height and bar width\n");
        $printer->selectPrintMode();
        $heights = array(1, 2, 4, 8, 16, 32);
        $widths = array(1, 2, 3, 4, 5, 6, 7, 8);
        $printer -> text("Default look\n");
        $printer->barcode("ABC", Printer::BARCODE_CODE39);

        foreach($heights as $height) {
            $printer -> text("\nHeight $height\n");
            $printer->setBarcodeHeight($height);
            $printer->barcode("ABC", Printer::BARCODE_CODE39);
        }
        foreach($widths as $width) {
            $printer -> text("\nWidth $width\n");
            $printer->setBarcodeWidth($width);
            $printer->barcode("ABC", Printer::BARCODE_CODE39);
        }
        $printer->feed();
// Set to something sensible for the rest of the examples
        $printer->setBarcodeHeight(40);
        $printer->setBarcodeWidth(2);

        /* Text position */
        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
        $printer->text("Text position\n");
        $printer->selectPrintMode();
        $hri = array (
            Printer::BARCODE_TEXT_NONE => "No text",
            Printer::BARCODE_TEXT_ABOVE => "Above",
            Printer::BARCODE_TEXT_BELOW => "Below",
            Printer::BARCODE_TEXT_ABOVE | Printer::BARCODE_TEXT_BELOW => "Both"
        );
        foreach ($hri as $position => $caption) {
            $printer->text($caption . "\n");
            $printer->setBarcodeTextPosition($position);
            $printer->barcode("012345678901", Printer::BARCODE_JAN13);
            $printer->feed();
        }

        /* Barcode types */
        $standards = array (
            Printer::BARCODE_UPCA => array (
                "title" => "UPC-A",
                "caption" => "Fixed-length numeric product barcodes.",
                "example" => array (
                    array (
                        "caption" => "12 char numeric including (wrong) check digit.",
                        "content" => "012345678901"
                    ),
                    array (
                        "caption" => "Send 11 chars to add check digit automatically.",
                        "content" => "01234567890"
                    )
                )
            ),
            Printer::BARCODE_UPCE => array (
                "title" => "UPC-E",
                "caption" => "Fixed-length numeric compact product barcodes.",
                "example" => array (
                    array (
                        "caption" => "6 char numeric - auto check digit & NSC",
                        "content" => "123456"
                    ),
                    array (
                        "caption" => "7 char numeric - auto check digit",
                        "content" => "0123456"
                    ),
                    array (
                        "caption" => "8 char numeric",
                        "content" => "01234567"
                    ),
                    array (
                        "caption" => "11 char numeric - auto check digit",
                        "content" => "01234567890"
                    ),
                    array (
                        "caption" => "12 char numeric including (wrong) check digit",
                        "content" => "012345678901"
                    )
                )
            ),
            Printer::BARCODE_JAN13 => array (
                "title" => "JAN13/EAN13",
                "caption" => "Fixed-length numeric barcodes.",
                "example" => array (
                    array (
                        "caption" => "12 char numeric - auto check digit",
                        "content" => "012345678901"
                    ),
                    array (
                        "caption" => "13 char numeric including (wrong) check digit",
                        "content" => "0123456789012"
                    )
                )
            ),
            Printer::BARCODE_JAN8 => array (
                "title" => "JAN8/EAN8",
                "caption" => "Fixed-length numeric barcodes.",
                "example" => array (
                    array (
                        "caption" => "7 char numeric - auto check digit",
                        "content" => "0123456"
                    ),
                    array (
                        "caption" => "8 char numeric including (wrong) check digit",
                        "content" => "01234567"
                    )
                )
            ),
            Printer::BARCODE_CODE39 => array (
                "title" => "Code39",
                "caption" => "Variable length alphanumeric w/ some special chars.",
                "example" => array (
                    array (
                        "caption" => "Text, numbers, spaces",
                        "content" => "ABC 012"
                    ),
                    array (
                        "caption" => "Special characters",
                        "content" => "$%+-./"
                    ),
                    array (
                        "caption" => "Extra char (*) Used as start/stop",
                        "content" => "*TEXT*"
                    )
                )
            ),
            Printer::BARCODE_ITF => array (
                "title" => "ITF",
                "caption" => "Variable length numeric w/even number of digits,\nas they are encoded in pairs.",
                "example" => array (
                    array (
                        "caption" => "Numeric- even number of digits",
                        "content" => "0123456789"
                    )
                )
            ),
            Printer::BARCODE_CODABAR => array (
                "title" => "Codabar",
                "caption" => "Varaible length numeric with some allowable\nextra characters. ABCD/abcd must be used as\nstart/stop characters (one at the start, one\nat the end) to distinguish between barcode\napplications.",
                "example" => array (
                    array (
                        "caption" => "Numeric w/ A A start/stop. ",
                        "content" => "A012345A"
                    ),
                    array (
                        "caption" => "Extra allowable characters",
                        "content" => "A012$+-./:A"
                    )
                )
            ),
            Printer::BARCODE_CODE93 => array (
                "title" => "Code93",
                "caption" => "Variable length- any ASCII is available",
                "example" => array (
                    array (
                        "caption" => "Text",
                        "content" => "012abcd"
                    )
                )
            ),
            Printer::BARCODE_CODE128 => array (
                "title" => "Code128",
                "caption" => "Variable length- any ASCII is available",
                "example" => array (
                    array (
                        "caption" => "Code set A uppercase & symbols",
                        "content" => "{A" . "012ABCD"
                    ),
                    array (
                        "caption" => "Code set B general text",
                        "content" => "{B" . "012ABCDabcd"
                    ),
                    array (
                        "caption" => "Code set C compact numbers\n Sending chr(21) chr(32) chr(43)",
                        "content" => "{C" . chr(21) . chr(32) . chr(43)
                    )
                )
            )
        );

        $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
        foreach ($standards as $type => $standard) {
            $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
            $printer->text($standard ["title"] . "\n");
            $printer->selectPrintMode();
            $printer->text($standard ["caption"] . "\n\n");
            foreach ($standard ["example"] as $id => $barcode) {
                $printer->setEmphasis(true);
                $printer->text($barcode ["caption"] . "\n");
                $printer->setEmphasis(false);
                $printer->text("Content: " . $barcode ["content"] . "\n");
                $printer->barcode($barcode ["content"], $type);
                $printer->feed();
            }
        }
        $printer->cut();
        $printer->close();
        
        die();
    }

    private function createCustomForm($id, $method, $route) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl($route, array('id' => $id)))
                        ->setMethod($method)
                        ->getForm();
    }

}
