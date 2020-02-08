<?php

namespace Briooz\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Briooz\TaskBundle\Entity\Proveedor;

class ProveedoresController extends Controller {

    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $proveedores = $em->getRepository('BrioozTaskBundle:Proveedor')->findBy(array(),array('nombres'=>'ASC'));
        $delete_form_ajax = $this->createCustomForm('PROVEEDOR_ID', 'DELETE', 'briooz_proveedor_delete');

        return $this->render('BrioozTaskBundle:Proveedores:index.html.twig', array('proveedores' => $proveedores, 'delete_form_ajax' => $delete_form_ajax->createView()));
    }

    public function addAction() {

        return $this->render('BrioozTaskBundle:Proveedores:add.html.twig');
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $proveedor = $em->getRepository('BrioozTaskBundle:Proveedor')->find($id);

        return $this->render('BrioozTaskBundle:Proveedores:edit.html.twig', array('proveedor' => $proveedor));
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $idProveedor = $request->get('id');
        $codigo = $request->get('codigo');
        $nombres = $request->get('nombres');
        $apellidos = $request->get('apellidos');
        $email = $request->get('email');
        $celular = $request->get('celular');
        $telefono = $request->get('telefono');
        $descripcion = $request->get('descripcion');
        $empresa=$request->get('empresa');


        $proveedorObj = $em->getRepository('BrioozTaskBundle:Proveedor')->find($idProveedor);

        if ($proveedorObj != null) {
            $proveedorObj->setCodigo($codigo);
            $proveedorObj->setEmpresa($empresa);
            $proveedorObj->setNombres($nombres);
            $proveedorObj->setApellidos($apellidos);
            $proveedorObj->getCelular($celular);
            $proveedorObj->setTelefono($telefono);
            $proveedorObj->setEmail($email);
            $proveedorObj->setDescripcion($descripcion);

            $em->persist($proveedorObj);
            $em->flush();
        }

        return $this->redirectToRoute('briooz_proveedor_index');
    }

    public function creadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $codigo = $request->get('codigo');
        $empresa=$request->get('empresa');
        $nombres = $request->get('nombres');
        $apellidos = $request->get('apellidos');
        $email = $request->get('email');
        $celular = $request->get('celular');
        $telefono = $request->get('telefono');
        $descripcion = $request->get('descripcion');


        $proveedorObj = new Proveedor();
        $proveedorObj->setCodigo($codigo);
        $proveedorObj->setEmpresa($empresa);
        $proveedorObj->setNombres($nombres);
        $proveedorObj->setApellidos($apellidos);
        $proveedorObj->getCelular($celular);
        $proveedorObj->setTelefono($telefono);
        $proveedorObj->setEmail($email);
        $proveedorObj->setDescripcion($descripcion);

        $em->persist($proveedorObj);
        $em->flush();

        return $this->redirectToRoute('briooz_proveedor_index');
    }

    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $proveedor = $em->getRepository('BrioozTaskBundle:Proveedor')->find($request->get('id'));

        if ($proveedor != null) {
            $em->remove($proveedor);
            $em->flush();
        }

        $cantidad = count($em->getRepository('BrioozTaskBundle:Proveedor')->findAll());
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
