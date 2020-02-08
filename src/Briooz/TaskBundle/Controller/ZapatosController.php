<?php

namespace Briooz\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Briooz\TaskBundle\Entity\Proveedor;
use Briooz\TaskBundle\Entity\Producto;
use Briooz\TaskBundle\Entity\ProductoTalla;

class ZapatosController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $productos = $em->getRepository('BrioozTaskBundle:Producto')->findBy(array(),array('id'=>'DESC'));
        $delete_form_ajax = $this->createCustomForm('PRODUCTO_ID', 'DELETE', 'briooz_zapato_delete');

        return $this->render('BrioozTaskBundle:Zapatos:index.html.twig', array('productos' => $productos, 'delete_form_ajax' => $delete_form_ajax->createView()));
    }

    public function addAction() {
        $em = $this->getDoctrine()->getManager();

        $dql2 = "SELECT u FROM BrioozTaskBundle:Color u ORDER BY u.name ASC";
        $col = $em->createQuery($dql2);
        $colores = $col->getResult();
        $dql3 = "SELECT u FROM BrioozTaskBundle:Proveedor u ORDER BY u.empresa ASC";
        $pro = $em->createQuery($dql3);
        $proveedores = $pro->getResult();


        $tallas = $em->getRepository('BrioozTaskBundle:Talla')->findBy(array(),array('descripcion'=>'ASC'));
        $categorias = $em->getRepository('BrioozTaskBundle:Categoria')->findAll();
        $modelos = $em->getRepository('BrioozTaskBundle:Modelo')->findAll();

        $bodegas = $em->getRepository('BrioozTaskBundle:Bodega')->findAll();
        $tacos = $em->getRepository('BrioozTaskBundle:Taco')->findAll();


        return $this->render('BrioozTaskBundle:Zapatos:add.html.twig', array('categorias' => $categorias, 'modelos' => $modelos, 'colores' => $colores,
                    'proveedores' => $proveedores, 'bodegas' => $bodegas, 'tallas' => $tallas, 'tacos' => $tacos));
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $producto = $em->getRepository('BrioozTaskBundle:Producto')->find($id);
        $tallas = $em->getRepository('BrioozTaskBundle:Talla')->findAll();

        $productoTalla = array();
        if ($producto != null) {
            $productoTalla = $em->getRepository('BrioozTaskBundle:ProductoTalla')->findBy(array('producto' => $id));
        }

        $colores = $em->getRepository('BrioozTaskBundle:Color')->findAll();
        $categorias = $em->getRepository('BrioozTaskBundle:Categoria')->findAll();
        $modelos = $em->getRepository('BrioozTaskBundle:Modelo')->findAll();
        $proveedores = $em->getRepository('BrioozTaskBundle:Proveedor')->findAll();
        $bodegas = $em->getRepository('BrioozTaskBundle:Bodega')->findAll();
        $tacos = $em->getRepository('BrioozTaskBundle:Taco')->findAll();
        $estados = $em->getRepository('BrioozTaskBundle:EstadoProducto')->findAll();


        return $this->render('BrioozTaskBundle:Zapatos:edit.html.twig', array('producto' => $producto, 'tallaspro' => $productoTalla, 'tallas' => $tallas, 'colores' => $colores,
                    'categorias' => $categorias, 'modelos' => $modelos, 'proveedores' => $proveedores, 'bodegas' => $bodegas, 'tacos' => $tacos, 'estados' => $estados));
    }

    public function verAction($id) {
        $em = $this->getDoctrine()->getManager();

        $producto = $em->getRepository('BrioozTaskBundle:Producto')->find($id);
        $tallas = $em->getRepository('BrioozTaskBundle:Talla')->findAll();

        $productoTalla = array();
        if ($producto != null) {
            $productoTalla = $em->getRepository('BrioozTaskBundle:ProductoTalla')->findBy(array('producto' => $id));
        }

        return $this->render('BrioozTaskBundle:Zapatos:ver.html.twig', array('producto' => $producto, 'tallaspro' => $productoTalla, 'tallas' => $tallas));
    }

    public function buscarAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $categoria = $request->get('categoriabuscar');
        $codigo = $request->get('codigo_buscar');
        $modelo = $request->get('modelo_buscar');
        $color = $request->get('color_buscar');
        $talla = $request->get('talla_buscar');

        $dql = "";
        $parameters = array();

        $c = 2;

        //000
        if ($codigo == "" and $modelo == 0 and $color == 0) {

            $dql = "SELECT u FROM BrioozTaskBundle:Producto u  WHERE u.categoria=:categoria ORDER BY u.id DESC";
            $parameters = array('categoria' => $categoria);
        }

        //010
        if ($codigo == "" and $modelo != 0 and $color == 0) {

            $dql = "SELECT u FROM BrioozTaskBundle:Producto u  WHERE u.categoria=:categoria and u.modelo=:modelo ORDER BY u.id DESC";
            $parameters = array('categoria' => $categoria, 'modelo' => $modelo);
        }

        //011
        if ($codigo == "" and $modelo != 0 and $color != 0) {

            $dql = "SELECT u FROM BrioozTaskBundle:Producto u  WHERE u.categoria=:categoria and u.modelo=:modelo and u.color=:color ORDER BY u.id DESC";
            $parameters = array('categoria' => $categoria, 'modelo' => $modelo, 'color' => $color);
        }

        //001
        if ($codigo == "" and $modelo == 0 and $color != 0) {

            $dql = "SELECT u FROM BrioozTaskBundle:Producto u  WHERE u.categoria=:categoria  and u.color=:color ORDER BY u.id DESC";
            $parameters = array('categoria' => $categoria, 'color' => $color);
        }

        //100
        if ($codigo != "" and $modelo == 0 and $color == 0) {

            $dql = "SELECT u FROM BrioozTaskBundle:Producto u  WHERE u.categoria=:categoria  and u.codigoInterno LIKE :codigo ORDER BY u.id DESC";
            $parameters = array('categoria' => $categoria, 'codigo' => '%' . $codigo . '%');
        }

        //110
        if ($codigo != "" and $modelo != 0 and $color == 0) {

            $dql = "SELECT u FROM BrioozTaskBundle:Producto u  WHERE u.categoria=:categoria  and u.codigoInterno LIKE :codigo and u.modelo=:modelo ORDER BY u.id DESC";
            $parameters = array('categoria' => $categoria, 'codigo' => '%' . $codigo . '%', 'modelo' => $modelo);
        }

        //101
        if ($codigo != "" and $modelo == 0 and $color != 0) {

            $dql = "SELECT u FROM BrioozTaskBundle:Producto u  WHERE u.categoria=:categoria  and u.codigoInterno LIKE :codigo and u.color=:color ORDER BY u.id DESC";
            $parameters = array('categoria' => $categoria, 'codigo' => '%' . $codigo . '%', 'color' => $color);
        }

        //111
        if ($codigo != "" and $modelo != 0 and $color != 0) {

            $dql = "SELECT u FROM BrioozTaskBundle:Producto u  WHERE u.categoria=:categoria  and u.codigoInterno LIKE :codigo and u.color=:color and u.modelo=:modelo ORDER BY u.id DESC";
            $parameters = array('categoria' => $categoria, 'codigo' => '%' . $codigo . '%', 'color' => $color, 'modelo' => $modelo);
        }

        $consulta = $em->createQuery($dql);
        $consulta->setParameters($parameters);

        $productos = $consulta->getResult();

        if ($talla != 0) {
            $productost = array();

            foreach ($productos as $p) {
                if ($this->ProductoTieneTalla($p->getId(), $talla)) {
                    $productost[] = $p;
                }
            }

            $productos = $productost;
        }


        $delete_form_ajax = $this->createCustomForm('PRODUCTO_ID', 'DELETE', 'briooz_zapato_delete');

        $dql2 = "SELECT u FROM BrioozTaskBundle:Modelo u WHERE u.categoria=1 or u.categoria=3";
        $modelos = $em->createQuery($dql2);
        $modelos2 = $modelos->getResult();

        $colores = $em->getRepository('BrioozTaskBundle:Color')->findAll();
        $tallas = $em->getRepository('BrioozTaskBundle:Talla')->findAll();

        //buscar la cantidad disponible por tallas
        $tallaspro = array();
        foreach ($productos as $producto) {
            $prodtalla = $em->getRepository('BrioozTaskBundle:ProductoTalla')->findBy(array('producto' => $producto->getId()));
            if ($prodtalla != null) {
                $tallaspro[$producto->getId()] = $prodtalla;
            } else {
                $tallaspro[$producto->getId()] = null;
            }
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $productos, $request->query->getInt('page', 1), 25
        );

        return $this->render('BrioozTaskBundle:Zapatos:index.html.twig', array('zapatos' => $pagination, 'delete_form_ajax' => $delete_form_ajax->createView(), 'tallas' => $tallas,
                    'modelos' => $modelos2, 'colores' => $colores, 'tallaspro' => $tallaspro, 'cat' => $categoria));
    }

    private function ProductoTieneTalla($producto, $talla) {
        $em = $this->getDoctrine()->getManager();

        $pt = $em->getRepository('BrioozTaskBundle:ProductoTalla')->findOneBy(array('producto' => $producto, 'talla' => $talla));
        if ($pt == null)
            return false;
        return true;
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $codigointerno = $request->get('codigointerno');
        $categoria = $request->get('categoria');
        $modelo = $request->get('modelo');
        $color = $request->get('color');
        $proveedor = $request->get('proveedor');
        $codigoproveedor = $request->get('codigoproveedor');
        $bodega = $request->get('bodega');
        $fila = $request->get('fila');
        $precio = $request->get('precio');
        $pvp = $request->get('pvp');
        $taco = $request->get('taco');
        $detalle = $request->get('detalle');
        $idproducto = $request->get('idproducto');
        $minimo = $request->get('minimo');
        $maximo = $request->get('maximo');
        $id_compra = $request->get('id_compra_selected');
        $calificacion = $request->get('calificacion');

        $producto = $em->getRepository('BrioozTaskBundle:Producto')->find($idproducto);

        if ($producto != null) {

            $producto->setTaco($em->getRepository('BrioozTaskBundle:Taco')->find($taco));
            $producto->setBodega($em->getRepository('BrioozTaskBundle:Bodega')->find($bodega));
            $producto->setCategoria($em->getRepository('BrioozTaskBundle:Categoria')->find($categoria));
            $producto->setCodigoInterno($codigointerno);
            $producto->setCodigoProveedor($codigoproveedor);
            $producto->setColor($em->getRepository('BrioozTaskBundle:Color')->find($color));
            $producto->setDetalle($detalle);
            $producto->setFila($fila);
            $producto->setModelo($em->getRepository('BrioozTaskBundle:Modelo')->find($modelo));
            $producto->setPrecio($precio);
            $producto->setProveedor($em->getRepository('BrioozTaskBundle:Proveedor')->find($proveedor));
            $producto->setPvp($pvp);
            $producto->setTaco($em->getRepository('BrioozTaskBundle:Taco')->find($taco));
            $producto->setEstado($em->getRepository('BrioozTaskBundleEstadoProducto')->find(1));
            $producto->setCalificacion($calificacion);
            $producto->setMinimo($minimo);
            $producto->setMaximo($maximo);
            $producto->setCompra($em->getRepository('BrioozVentasBundle:Compra')->find($id_compra));
            $em->persist($producto);
            $em->flush();
        }

        //primero actualizar los registros del producto talla
        $productoTallas=$em->getRepository('BrioozTaskBundle:ProductoTalla')->findBy(array('producto'=>$idproducto));
        
        if($productoTallas!=null){
            foreach ($productoTallas as $pt){
                $em->remove($pt);
                $em->flush();
            }
        }
        
        $allTallas = $em->getRepository('BrioozTaskBundle:Talla')->findAll();
        $cantTallas = count($allTallas);
        $totalProductos = 0;
        for ($i = 1; $i < $cantTallas; $i++) {
            $talla = $request->get('talla' . $i);
            if ($talla != "") {
                $cantidadTallas = $request->get('cantidadtalla' . $talla);
                $totalProductos += $cantidadTallas;
                $proTalla = new ProductoTalla();
                $proTalla->setCantidad($cantidadTallas);
                $proTalla->setTalla($em->getRepository('BrioozTaskBundle:Talla')->find($talla));
                $proTalla->setProducto($producto);

                $em->persist($proTalla);
                $em->flush();
            }
        }

        $producto->setTotal($totalProductos);


        return $this->redirectToRoute('briooz_zapato_index', array('cat' => $categoria));
    }

    public function creadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $codigointerno = $request->get('codigointerno');
        $categoria = $request->get('categoria');
        $modelo = $request->get('modelo');
        $color = $request->get('color');
        $proveedor = $request->get('proveedor');
        $codigoproveedor = $request->get('codigoproveedor');
        $bodega = $request->get('bodega');
        $fila = $request->get('fila');
        $precio = $request->get('precio');
        $pvp = $request->get('pvp');
        $taco = $request->get('taco');
        $detalle = $request->get('detalle');
        $id_compra = $request->get('id_compra_selected');
        $minimo = $request->get('minimo');
        $maximo = $request->get('maximo');
        $calificacion = $request->get('calificacion');

        $producto = new Producto();
        $producto->setTaco($em->getRepository('BrioozTaskBundle:Taco')->find($taco));
        $producto->setBodega($em->getRepository('BrioozTaskBundle:Bodega')->find($bodega));
        $producto->setCategoria($em->getRepository('BrioozTaskBundle:Categoria')->find($categoria));
        $producto->setCodigoInterno($codigointerno);
        $producto->setCodigoProveedor($codigoproveedor);
        $producto->setColor($em->getRepository('BrioozTaskBundle:Color')->find($color));
        $producto->setDetalle($detalle);
        $producto->setFila($fila);
        $producto->setModelo($em->getRepository('BrioozTaskBundle:Modelo')->find($modelo));
        $producto->setPrecio($precio);
        $producto->setProveedor($em->getRepository('BrioozTaskBundle:Proveedor')->find($proveedor));
        $producto->setPvp($pvp);
        $producto->setTaco($em->getRepository('BrioozTaskBundle:Taco')->find($taco));
        $producto->setCompra($em->getRepository('BrioozVentasBundle:Compra')->find($id_compra));
        $producto->setMinimo($minimo);
        $producto->setMaximo($maximo);
        $producto->setEstado($em->getRepository('BrioozTaskBundle:EstadoProducto')->find(1));
        $producto->setCalificacion($calificacion);
        $producto->setTotal(0);
        $em->persist($producto);
        $em->flush();

        $allTallas = $em->getRepository('BrioozTaskBundle:Talla')->findAll();
        $cantTallas = count($allTallas);
        $totalProductos = 0;
        for ($i = 1; $i < $cantTallas; $i++) {
            $talla = $request->get('talla' . $i);
            if ($talla != "") {
                $cantidadTallas = $request->get('cantidadtalla' . $talla);
                $totalProductos += $cantidadTallas;
                $proTalla = new ProductoTalla();
                $proTalla->setCantidad($cantidadTallas);
                $proTalla->setTalla($em->getRepository('BrioozTaskBundle:Talla')->find($talla));
                $proTalla->setProducto($producto);

                $em->persist($proTalla);
                $em->flush();
            }
        }

        $producto->setTotal($totalProductos);
        $em->persist($producto);
        $em->flush();

        return $this->redirectToRoute('briooz_zapato_index');
    }

    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');
        $producto = $em->getRepository('BrioozTaskBundle:Producto')->find($id);


        //buscar los producto tallas
        $productotalla = $em->getRepository('BrioozTaskBundle:ProductoTalla')->findBy(array('producto' => $id));

        if ($productotalla != null) {
            foreach ($productotalla as $pt) {
                $em->remove($pt);
                $em->flush();
            }
        }

        if ($producto != null) {
            $em->remove($producto);
            $em->flush();
        }

        return new Response(
                json_encode(array('id' => 1)), 200, array('Content-Type' => 'application/json')
        );
    }

    public function buscarComprarAjaxAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $compra = $request->get('compra');

        $dql = "SELECT u FROM BrioozVentasBundle:Compra u  WHERE u.lote LIKE :compra  or u.factura LIKE :compra ORDER BY u.id DESC";
        $parameters = array('compra' => '%' . $compra . '%');

        $consulta = $em->createQuery($dql);
        $consulta->setParameters($parameters);

        $compras = $consulta->getResult();

        $comprasResult = array();
        $compra = array();


        foreach ($compras as $cp) {
            $compra['id'] = $cp->getId();
            $compra['lote'] = $cp->getLote();
            $compra['proveedor'] = $cp->getProveedor()->getEmpresa();
            $compra['factura'] = $cp->getFactura();
            $compra['fecha'] = $cp->getFecha()->format('Y-m-d');
            $comprasResult[] = $compra;
        }


        return new Response(
                json_encode(array('compras' => $comprasResult, 'compra' => $compra)), 200, array('Content-Type' => 'application/json')
        );
    }

    private function createCustomForm($id, $method, $route) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl($route, array('id' => $id)))
                        ->setMethod($method)
                        ->getForm();
    }

}
