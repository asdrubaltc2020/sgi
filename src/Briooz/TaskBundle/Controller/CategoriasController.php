<?php

namespace Briooz\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Briooz\TaskBundle\Entity\Categoria;

class CategoriasController extends Controller {

    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $categorias = $em->getRepository('BrioozTaskBundle:Categoria')->findBy(array(),array('name'=>'ASC'));


        $delete_form_ajax = $this->createCustomForm('CATEGORIA_ID', 'DELETE', 'briooz_categoria_delete');

        return $this->render('BrioozTaskBundle:Categorias:index.html.twig', array('categorias' => $categorias, 'delete_form_ajax' => $delete_form_ajax->createView()));
    }

    public function addAction() {

        return $this->render('BrioozTaskBundle:Categorias:add.html.twig');
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $categoria = $em->getRepository('BrioozTaskBundle:Categoria')->find($id);

        return $this->render('BrioozTaskBundle:Categorias:edit.html.twig', array('categoria' => $categoria));
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $idCategoria = $request->get('idcategoria');
        $categoriaNew = $request->get('categoria');
        $descripcion=$request->get('descripcion');

        $categoria = $em->getRepository('BrioozTaskBundle:Categoria')->find($idCategoria);

        if ($categoria != null) {
            $categoria->setDescripcion($descripcion);
            $categoria->setName($categoriaNew);
            $em->persist($categoria);
            $em->flush();
        }

        return $this->redirectToRoute('briooz_categoria_index');
    }

    public function creadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $categoria = $request->get('categoria');
        $descripcion=$request->get('descripcion');

        $categoriaObj = new Categoria();
        $categoriaObj->setName($categoria);
        $categoriaObj->setDescripcion($descripcion);

        $em->persist($categoriaObj);
        $em->flush();

        return $this->redirectToRoute('briooz_categoria_index');
    }

    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $categoria = $em->getRepository('BrioozTaskBundle:Categoria')->find($request->get('id'));

        if ($categoria != null) {
            $em->remove($categoria);
            $em->flush();
        }

        $cantidad = count($em->getRepository('BrioozTaskBundle:Categoria')->findAll());
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
