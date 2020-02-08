<?php

namespace Briooz\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Briooz\TaskBundle\Entity\Talla;

class TallasController extends Controller {

    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $tallas = $em->getRepository('BrioozTaskBundle:Talla')->findBy(array(),array('id'=>'ASC'));
        $delete_form_ajax = $this->createCustomForm('TALLA_ID', 'DELETE', 'briooz_talla_delete');

        return $this->render('BrioozTaskBundle:Tallas:index.html.twig', array('tallas' => $tallas, 'delete_form_ajax' => $delete_form_ajax->createView()));
    }

    public function addAction() {

        return $this->render('BrioozTaskBundle:Tallas:add.html.twig');
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $talla = $em->getRepository('BrioozTaskBundle:Talla')->find($id);

        return $this->render('BrioozTaskBundle:Tallas:edit.html.twig', array('talla' => $talla));
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $idTalla = $request->get('idtalla');
        $tallaNew = $request->get('talla');

        $talla = $em->getRepository('BrioozTaskBundle:Talla')->find($idTalla);

        if ($talla != null) {
            $talla->setDescripcion($tallaNew);
            $em->persist($talla);
            $em->flush();
        }

        return $this->redirectToRoute('briooz_talla_index');
    }

    public function creadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $talla = $request->get('talla');
        $tallaObj = new Talla();
        $tallaObj->setDescripcion($talla);

        $em->persist($tallaObj);
        $em->flush();

        return $this->redirectToRoute('briooz_talla_index');
    }

    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $talla = $em->getRepository('BrioozTaskBundle:Talla')->find($request->get('id'));

        if ($talla != null) {
            $em->remove($talla);
            $em->flush();
        }

        $cantidad = count($em->getRepository('BrioozTaskBundle:Talla')->findAll());
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
