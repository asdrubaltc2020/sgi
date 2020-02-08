<?php

namespace Briooz\VentasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Briooz\VentasBundle\Entity\Compra;

class ComprasController extends Controller {

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $compras = $em->getRepository('BrioozVentasBundle:Compra')->findBy(array(),array('id'=>'DESC'));

        $delete_form_ajax = $this->createCustomForm('COMPRA_ID', 'DELETE', 'briooz_compra_delete');

        return $this->render('BrioozVentasBundle:Compras:index.html.twig', array('compras' => $compras, 'delete_form_ajax' => $delete_form_ajax->createView()));
    }

    public function addAction() {
        $em = $this->getDoctrine()->getManager();

        $proveedores = $em->getRepository('BrioozTaskBundle:Proveedor')->findAll();

        return $this->render('BrioozVentasBundle:Compras:add.html.twig', array('proveedores' => $proveedores));
    }

    public function creadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $compra = new Compra();

        $lote = $request->get('lote');
        $proveedor = $request->get('proveedor');
        $items = $request->get('items');
        $subtotal = $request->get('subtotal');
        $iva = $request->get('iva');
        $total = $request->get('total');
        $factura = $request->get('factura');
        $fecha = $request->get('fecha');


        $compra->setLote($lote);
        $compra->setProveedor($em->getRepository('BrioozTaskBundle:Proveedor')->find($proveedor));
        $compra->setItems($items);
        $compra->setSubtotal($subtotal);
        $compra->setIva($iva);
        $compra->setTotal($total);
        $compra->setFactura($factura);
        $compra->setFecha($fecha);

        $em->persist($compra);
        $em->flush();

        return $this->redirectToRoute('briooz_compra_index');
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $proveedores = $em->getRepository('BrioozTaskBundle:Proveedor')->findAll();

        $compra = $em->getRepository('BrioozVentasBundle:Compra')->find($id);

        if ($compra == null) {
            return $this->redirectToRoute('briooz_compra_index');
        }


        return $this->render('BrioozVentasBundle:Compras:edit.html.twig', array('proveedores' => $proveedores, 'compra' => $compra));
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');
        $lote = $request->get('lote');
        $proveedor = $request->get('proveedor');
        $items = $request->get('items');
        $subtotal = $request->get('subtotal');
        $iva = $request->get('iva');
        $total = $request->get('total');
        $factura = $request->get('factura');
        $fecha = $request->get('fecha');

        $compra = $em->getRepository('BrioozVentasBundle:Compra')->find($id);

        if ($compra != null) {
            $compra->setLote($lote);
            $compra->setProveedor($em->getRepository('BrioozTaskBundle:Proveedor')->find($proveedor));
            $compra->setItems($items);
            $compra->setSubtotal($subtotal);
            $compra->setIva($iva);
            $compra->setTotal($total);
            $compra->setFactura($factura);
            $compra->setFecha($fecha);

            $em->persist($compra);
            $em->flush();
        }

        return $this->redirectToRoute('briooz_compra_index');
    }

    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');

        $compra = $em->getRepository('BrioozVentasBundle:Compra')->find($request->get('id'));

        if ($compra != null) {
            $em->remove($compra);
            $em->flush();
        }

        $cantidad = count($em->getRepository('BrioozVentasBundle:Compra')->findAll());
        return new Response(
                json_encode(array('cantidad' => $cantidad)), 200, array('Content-Type' => 'application/json')
        );
    }

    public function VerAction($id) {
        $em = $this->getDoctrine()->getManager();

        $proveedores = $em->getRepository('BrioozTaskBundle:Proveedor')->findAll();

        $compra = $em->getRepository('BrioozVentasBundle:Compra')->find($id);

        if ($compra == null) {
            return $this->redirectToRoute('briooz_compra_index');
        }


        return $this->render('BrioozVentasBundle:Compras:ver.html.twig', array('proveedores' => $proveedores, 'compra' => $compra));
    }

    private function createCustomForm($id, $method, $route) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl($route, array('id' => $id)))
                        ->setMethod($method)
                        ->getForm();
    }

}
