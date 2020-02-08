<?php

namespace Briooz\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Briooz\TaskBundle\Entity\Taco;

class TacosController extends Controller {

    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $tacos=$em->getRepository('BrioozTaskBundle:Taco')->findBy(array(),array('descripcion'=>'ASC'));
        $delete_form_ajax = $this->createCustomForm('TACO_ID', 'DELETE', 'briooz_taco_delete');

        return $this->render('BrioozTaskBundle:Tacos:index.html.twig', array('tacos' => $tacos, 'delete_form_ajax' => $delete_form_ajax->createView()));
    }

    public function addAction() {

        return $this->render('BrioozTaskBundle:Tacos:add.html.twig');
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $taco = $em->getRepository('BrioozTaskBundle:Taco')->find($id);

        return $this->render('BrioozTaskBundle:Tacos:edit.html.twig', array('taco' => $taco));
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $idTaco = $request->get('idtaco');
        $tacoNew = $request->get('taco');

        $taco = $em->getRepository('BrioozTaskBundle:Taco')->find($idTaco);

        if ($taco != null) {
            $taco->setDescripcion($tacoNew);
            $em->persist($taco);
            $em->flush();
        }

        return $this->redirectToRoute('briooz_taco_index');
    }

    public function creadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $taco = $request->get('taco');
        $tacoObj = new Taco();
        $tacoObj->setDescripcion($taco);

        $em->persist($tacoObj);
        $em->flush();

        return $this->redirectToRoute('briooz_taco_index');
    }

    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $taco = $em->getRepository('BrioozTaskBundle:Taco')->find($request->get('id'));

        if ($taco != null) {
            $em->remove($taco);
            $em->flush();
        }

        $cantidad = count($em->getRepository('BrioozTaskBundle:Taco')->findAll());
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
