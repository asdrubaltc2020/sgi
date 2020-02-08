<?php

namespace Briooz\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Briooz\TaskBundle\Entity\Cliente;

class ClientesController extends Controller {

    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $clientes = $em->getRepository('BrioozTaskBundle:Cliente')->findBy(array(),array('nombres'=>'ASC'));

        $delete_form_ajax = $this->createCustomForm('CLIENTE_ID', 'DELETE', 'briooz_cliente_delete');

        return $this->render('BrioozTaskBundle:Clientes:index.html.twig', array('clientes' => $clientes, 'delete_form_ajax' => $delete_form_ajax->createView()));
    }

    public function addAction() {

        return $this->render('BrioozTaskBundle:Clientes:add.html.twig');
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $cliente = $em->getRepository('BrioozTaskBundle:Cliente')->find($id);

        return $this->render('BrioozTaskBundle:Clientes:edit.html.twig', array('cliente' => $cliente));
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $nombres = $request->get('nombres');
        $apellidos = $request->get('apellidos');
        $ci = $request->get('ci');
        $ruc = $request->get('ruc');
        $celular = $request->get('celular');
        $telefono = $request->get('telefono');
        $email = $request->get('email');
        $direccion = $request->get('direccion');
        $idCliente = $request->get('idcliente');
        $tipocliente = $request->get('tipocliente');
        $razonsocial = $request->get('razonsocial');
        $nombreempresa = $request->get('nombreempresa');

        $cliente = $em->getRepository('BrioozTaskBundle:Cliente')->find($idCliente);
        $cliente->setNombres($nombres);
        $cliente->setApellidos($apellidos);
        $cliente->setCi($ci);
        $cliente->setRuc($ruc);
        $cliente->setCelular($celular);
        $cliente->setTelefono($telefono);
        $cliente->setEmail($email);
        $cliente->setDireccion($direccion);
        $cliente->setTipoCliente($tipocliente);
        $cliente->setRazonSocial($razonsocial);
        $cliente->setNombreEmpresa($nombreempresa);

        $em->persist($cliente);
        $em->flush();

        return $this->redirectToRoute('briooz_cliente_index');
    }

    public function creadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $nombres = $request->get('nombres');
        $apellidos = $request->get('apellidos');
        $ci = $request->get('ci');
        $ruc = $request->get('ruc');
        $celular = $request->get('celular');
        $telefono = $request->get('telefono');
        $email = $request->get('email');
        $direccion = $request->get('direccion');
        $tipocliente = $request->get('tipocliente');
        $razonsocial = $request->get('razonsocial');
        $nombreempresa = $request->get('nombreempresa');

        $cliente = new Cliente();
        $cliente->setNombres($nombres);
        $cliente->setApellidos($apellidos);
        $cliente->setCi($ci);
        $cliente->setRuc($ruc);
        $cliente->setCelular($celular);
        $cliente->setTelefono($telefono);
        $cliente->setEmail($email);
        $cliente->setDireccion($direccion);
        $cliente->setTipoCliente($tipocliente);
        $cliente->setRazonSocial($razonsocial);
        $cliente->setNombreEmpresa($nombreempresa);

        $em->persist($cliente);
        $em->flush();

        return $this->redirectToRoute('briooz_cliente_index');
    }

    public function creadoAjaxAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $nombres = $request->get('nombres');
        $apellidos = $request->get('apellidos');
        $ci = $request->get('ci');
        $ruc = $request->get('ruc');
        $celular = $request->get('celular');
        $telefono = $request->get('telefono');
        $email = $request->get('email');
        $direccion = $request->get('direccion');
        $tipocliente = $request->get('tipocliente');
        $razonsocial = $request->get('razonsocial');
        $nombreempresa = $request->get('nombreempresa');

        $cliente = new Cliente();
        $cliente->setNombres($nombres);
        $cliente->setApellidos($apellidos);
        $cliente->setCi($ci);
        $cliente->setRuc($ruc);
        $cliente->setCelular($celular);
        $cliente->setTelefono($telefono);
        $cliente->setEmail($email);
        $cliente->setDireccion($direccion);
        $cliente->setTipoCliente($tipocliente);
        $cliente->setRazonSocial($razonsocial);
        $cliente->setNombreEmpresa($nombreempresa);

        $em->persist($cliente);
        $em->flush();

        return new Response(
                json_encode(array('id' => 1)), 200, array('Content-Type' => 'application/json')
        );
    }

    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $cliente = $em->getRepository('BrioozTaskBundle:Cliente')->find($request->get('id'));

        if ($cliente != null) {
            $em->remove($cliente);
            $em->flush();
        }

        $cantidad = count($em->getRepository('BrioozTaskBundle:Cliente')->findAll());
        return new Response(
                json_encode(array('cantidad' => $cantidad)), 200, array('Content-Type' => 'application/json')
        );
    }

    private function createCustomForm($id, $method, $route) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl($route, array('id' => $id)))
                        ->setMethod($method)
                        ->getForm();
    }

}
