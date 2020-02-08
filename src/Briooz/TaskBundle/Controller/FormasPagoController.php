<?php

namespace Briooz\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Briooz\TaskBundle\Entity\FormaPago;

class FormasPagoController extends Controller {

    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $formas = $em->getRepository('BrioozTaskBundle:FormaPago')->findBy(array(),array('descripcion'=>'ASC'));

        $delete_form_ajax = $this->createCustomForm('FORFAPAGO_ID', 'DELETE', 'briooz_formapago_delete');

        return $this->render('BrioozTaskBundle:FormasPago:index.html.twig', array('formaspago' =>$formas, 'delete_form_ajax' => $delete_form_ajax->createView()));
    }

    public function addAction() {

        return $this->render('BrioozTaskBundle:FormasPago:add.html.twig');
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $formapago = $em->getRepository('BrioozTaskBundle:FormaPago')->find($id);

        if ($formapago == null) {
            return $this->redirectToRoute('briooz_formapago_index');
        }

        return $this->render('BrioozTaskBundle:FormasPago:edit.html.twig', array('formapago' => $formapago));
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('idformapago');
        $formapago = $request->get('formapago');
        $descuento = $request->get('descuento');
        $recargo = $request->get('recargo');

        $formaP = $em->getRepository('BrioozTaskBundle:FormaPago')->find($id);
        $formaP->setDescripcion($formapago);
        $formaP->setDescuento($descuento);
        $formaP->setRecargo($recargo);
        $em->persist($formaP);
        $em->flush();
        return $this->redirectToRoute('briooz_formapago_index');
    }

    public function creadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $formapago = $request->get('formapago');
        $descuento = $request->get('descuento');
        $recargo = $request->get('recargo');

        $formaP = new FormaPago();
        $formaP->setDescripcion($formapago);
        $formaP->setDescuento($descuento);
        $formaP->setRecargo($recargo);

        $em->persist($formaP);
        $em->flush();

        return $this->redirectToRoute('briooz_formapago_index');
    }

    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $formapago = $em->getRepository('BrioozTaskBundle:FormaPago')->find($request->get('id'));

        if ($formapago != null) {
            $em->remove($formapago);
            $em->flush();
        }

        $cantidad = count($em->getRepository('BrioozTaskBundle:FormaPago')->findAll());
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
