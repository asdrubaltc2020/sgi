<?php

namespace Briooz\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Briooz\TaskBundle\Entity\Bodega;

class BodegasController extends Controller {

    public function indexAction(Request $request) {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $em = $this->getDoctrine()->getManager();
            $bodegas = $em->getRepository('BrioozTaskBundle:Bodega')->findBy(array(), array('name' => 'ASC'));

            $delete_form_ajax = $this->createCustomForm('BODEGA_ID', 'DELETE', 'briooz_bodega_delete');

            return $this->render('BrioozTaskBundle:Bodegas:index.html.twig', array('bodegas' => $bodegas, 'delete_form_ajax' => $delete_form_ajax->createView()));
        }else{
            return $this->redirectToRoute('briooz_usuario_login');
        }
    }

    public function addAction() {

        return $this->render('BrioozTaskBundle:Bodegas:add.html.twig');
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $bodega = $em->getRepository('BrioozTaskBundle:Bodega')->find($id);

        return $this->render('BrioozTaskBundle:Bodegas:edit.html.twig', array('bodega' => $bodega));
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $idBodega = $request->get('idbodega');
        $bodegaNew = $request->get('bodega');
        $descripcion=$request->get('descripcion');

        $bodega = $em->getRepository('BrioozTaskBundle:Bodega')->find($idBodega);

        if ($bodega != null) {
            $bodega->setName($bodegaNew);
            $bodega->setDescripcion($descripcion);
            $em->persist($bodega);
            $em->flush();
        }

        return $this->redirectToRoute('briooz_bodega_index');
    }

    public function creadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $bodega = $request->get('bodega');
        $descripcion=$request->get('descripcion');

        $bodegaObj = new Bodega();
        $bodegaObj->setDescripcion($bodega);
        $bodegaObj->setDescripcion($descripcion);

        $em->persist($bodegaObj);
        $em->flush();

        return $this->redirectToRoute('briooz_bodega_index');
    }

    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $bodega = $em->getRepository('BrioozTaskBundle:Bodega')->find($request->get('id'));

        if ($bodega != null) {
            $em->remove($bodega);
            $em->flush();
        }

        $cantidad = count($em->getRepository('BrioozTaskBundle:Bodega')->findAll());
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
