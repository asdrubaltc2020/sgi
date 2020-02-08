<?php

namespace Briooz\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Briooz\TaskBundle\Entity\CategoriaDeducible;

class DeduciblesController extends Controller {

    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $deducibles = $em->getRepository('BrioozTaskBundle:CategoriaDeducible')->findBy(array(),array('name'=>'ASC'));

        $delete_form_ajax = $this->createCustomForm('CATEGORIA_ID', 'DELETE', 'briooz_deducible_delete');

        return $this->render('BrioozTaskBundle:Deducibles:index.html.twig', array('deducibles' => $deducibles, 'delete_form_ajax' => $delete_form_ajax->createView()));
    }

    public function addAction() {

        return $this->render('BrioozTaskBundle:Deducibles:add.html.twig');
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $categoria = $em->getRepository('BrioozTaskBundle:CategoriaDeducible')->find($id);

        return $this->render('BrioozTaskBundle:Deducibles:edit.html.twig', array('categoria' => $categoria));
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $idCategoria = $request->get('idcategoria');
        $categoriaNew = $request->get('categoria');
        $descripcion = $request->get('descripcion');

        $categoria = $em->getRepository('BrioozTaskBundle:CategoriaDeducible')->find($idCategoria);

        if ($categoria != null) {
            $categoria->setName($categoriaNew);
            $categoria->setDescripcion($descripcion);
            $em->persist($categoria);
            $em->flush();
        }

        return $this->redirectToRoute('briooz_deducible_index');
    }

    public function creadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $categoria = $request->get('categoria');
        $descripcion = $request->get('descripcion');
        $categoriaObj = new CategoriaDeducible();
        $categoriaObj->setName($categoria);
        $categoriaObj->setDescripcion($descripcion);

        $em->persist($categoriaObj);
        $em->flush();

        return $this->redirectToRoute('briooz_deducible_index');
    }

    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $categoria = $em->getRepository('BrioozTaskBundle:CategoriaDeducible')->find($request->get('id'));

        if ($categoria != null) {
            $em->remove($categoria);
            $em->flush();
        }

        $cantidad = count($em->getRepository('BrioozTaskBundle:CategoriaDeducible')->findAll());
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
