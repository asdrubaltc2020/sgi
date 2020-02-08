<?php

namespace Briooz\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Briooz\TaskBundle\Entity\Usuario;
use Briooz\TaskBundle\Entity\Usuariopermiso;
use \DateTime;

class UsuarioController extends Controller {

    public function homeAction(Request $request) {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {

            //cargar los datos necesarios para la pagina de inicio
            $em = $this->getDoctrine()->getManager();

            //estadisticas y datos para el dashboard
            $fechaHoy = date('Y-m-d');

            //obtener la cantidad de ventas por fechas
            //ventas de hoy
            $dql = "SELECT u FROM BrioozVentasBundle:Venta u WHERE  DATE_FORMAT(u.fecha,'%Y-%m-%d')=:fechaHoy ";
            $parameters = array('fechaHoy' => $fechaHoy);
            $consulta = $em->createQuery($dql);
            $consulta->setParameters($parameters);

            $ventasHoy = $consulta->getResult();
            $totalVentasHoy = 0;
            foreach ($ventasHoy as $vh) {
                $totalVentasHoy += $vh->getTotal();
            }

            //venta de la semana
            $allventas = $em->getRepository('BrioozVentasBundle:Venta')->findAll();
            $ventasSemana = array();
            $totalVentasSemana = 0;

            foreach ($allventas as $allv) {
                if ($this->isMismaSemana($allv->getFecha()->format('Y-m-d')) == true) {
                    $ventasSemana[] = $allv;
                }
            }

            foreach ($ventasSemana as $tvs) {
                $totalVentasSemana += $tvs->getTotal();
            }

            //ventas del mes
            $mesActual = date('Y-m');
            $dql1 = "SELECT u FROM BrioozVentasBundle:Venta u WHERE  DATE_FORMAT(u.fecha,'%Y-%m')=:fechaMes ";
            $parameters1 = array('fechaMes' => $mesActual);
            $consulta1 = $em->createQuery($dql1);
            $consulta1->setParameters($parameters1);

            $ventasMes = $consulta1->getResult();
            $totalVentasMes = 0;
            foreach ($ventasMes as $vm) {
                $totalVentasMes += $vm->getTotal();
            }

            //ventas del año
            $yearActual = date('Y');
            $dql2 = "SELECT u FROM BrioozVentasBundle:Venta u WHERE  DATE_FORMAT(u.fecha,'%Y')=:fechaYear ";
            $parameters2 = array('fechaYear' => $yearActual);
            $consulta2 = $em->createQuery($dql2);
            $consulta2->setParameters($parameters2);

            $ventasYear = $consulta2->getResult();
            $totalVentasYear = 0;

            foreach ($ventasYear as $vy) {
                $totalVentasYear += $vy->getTotal();
            }

            //ventas total
            $totalVentas = $em->getRepository('BrioozVentasBundle:Venta')->findAll();
            $totalVentasTotal = 0;
            foreach ($totalVentas as $tv) {
                $totalVentasTotal += $tv->getTotal();
            }

            //arreglo para guardar la cantidad de ventas segun fechas
            $ventas = array();

            $ventas['hoy'] = $totalVentasHoy;
            $ventas['total'] = $totalVentasTotal;
            $ventas['semana'] = $totalVentasSemana;
            $ventas['mes'] = $totalVentasMes;
            $ventas['year'] = $totalVentasYear;

            //CARGA DE DATOS PARA LAS GRAFICAS
            $compras = $em->getRepository('BrioozVentasBundle:Compra')->findAll();
            $proveedores = $em->getRepository('BrioozTaskBundle:Proveedor')->findAll();

            $cantPorProveedor = array();
            $cont = 0;
            foreach ($proveedores as $proveedor) {

                $datos = $this->cantidadComprarProveedor($compras, $proveedor);
                if ($datos[0] > 0) {
                    $cantPorProveedor[$cont][0] = $datos[0]; //cantidad de compras
                    $cantPorProveedor[$cont][1] = $proveedor->getEmpresa();
                    $cantPorProveedor[$cont][2] = $datos[1]; //monto total de compras
                    $cont++;
                }
            }

            //cargar el monto total compras por meses y año
            $cantidad_enero = 0;
            $cantidad_febrero = 0;
            $cantidad_marzo = 0;
            $cantidad_abril = 0;
            $cantidad_mayo = 0;
            $cantidad_junio = 0;
            $cantidad_julio = 0;
            $cantidad_agosto = 0;
            $cantidad_septiembre = 0;
            $cantidad_octubre = 0;
            $cantidad_noviembre = 0;
            $cantidad_diciembre = 0;

            $year = date('Y');

            $totalComprasYear = 0;

            $allCompras = $em->getRepository('BrioozVentasBundle:Compra')->findAll();
            foreach ($allCompras as $compra) {
                if ($compra->getFecha()->format('Y') == $year) {
                    if ($compra->getFecha()->format('m') == "01") {
                        $cantidad_enero += $compra->getTotal();
                    }
                    if ($compra->getFecha()->format('m') == "02") {
                        $cantidad_febrero += $compra->getTotal();
                    }
                    if ($compra->getFecha()->format('m') == "03") {
                        $cantidad_marzo += $compra->getTotal();
                    }
                    if ($compra->getFecha()->format('m') == "04") {
                        $cantidad_abril += $compra->getTotal();
                    }
                    if ($compra->getFecha()->format('m') == "05") {
                        $cantidad_mayo += $compra->getTotal();
                    }
                    if ($compra->getFecha()->format('m') == "06") {
                        $cantidad_junio += $compra->getTotal();
                    }
                    if ($compra->getFecha()->format('m') == "07") {
                        $cantidad_julio += $compra->getTotal();
                    }
                    if ($compra->getFecha()->format('m') == "08") {
                        $cantidad_agosto += $compra->getTotal();
                    }
                    if ($compra->getFecha()->format('m') == "09") {
                        $cantidad_septiembre += $compra->getTotal();
                    }
                    if ($compra->getFecha()->format('m') == "10") {
                        $cantidad_octubre += $compra->getTotal();
                    }
                    if ($compra->getFecha()->format('m') == "11") {
                        $cantidad_noviembre += $compra->getTotal();
                    }
                    if ($compra->getFecha()->format('m') == "12") {
                        $cantidad_diciembre += $compra->getTotal();
                    }
                }
            }

            $cantidadCompraMeses = array();
            $cantidadCompraMeses[0] = $cantidad_enero;
            $cantidadCompraMeses[1] = $cantidad_febrero;
            $cantidadCompraMeses[2] = $cantidad_marzo;
            $cantidadCompraMeses[3] = $cantidad_abril;
            $cantidadCompraMeses[4] = $cantidad_mayo;
            $cantidadCompraMeses[5] = $cantidad_junio;
            $cantidadCompraMeses[6] = $cantidad_julio;
            $cantidadCompraMeses[7] = $cantidad_agosto;
            $cantidadCompraMeses[8] = $cantidad_septiembre;
            $cantidadCompraMeses[9] = $cantidad_octubre;
            $cantidadCompraMeses[10] = $cantidad_noviembre;
            $cantidadCompraMeses[11] = $cantidad_diciembre;

            //algoritmo determinar minimo y maximo en ventas y su posicion en la grafica
            $maximo = -1;
            $postMaximo = -1;

            for ($i = 0; $i < 12; $i++) {
                if ($cantidadCompraMeses[$i] > $maximo) {
                    $maximo = $cantidadCompraMeses[$i];
                    $postMaximo = $i;
                }
            }

            $valoresMaximo = array();
            $valoresMaximo[0] = $maximo;
            $valoresMaximo[1] = $postMaximo;

            $minimo = 1000000000;
            $postMinimo = -1;

            for ($i = 0; $i < 12; $i++) {
                if ($cantidadCompraMeses[$i] < $minimo && $cantidadCompraMeses[$i] > 0) {
                    $minimo = $cantidadCompraMeses[$i];
                    $postMinimo = $i;
                }
            }

            $valoresMinimo = array();
            $valoresMinimo[0] = $minimo;
            $valoresMinimo[1] = $postMinimo;


            //cargar todos los productos

            $allProductos = $em->getRepository('BrioozTaskBundle:Producto')->findAll();

            $productoCantidades = array();
            $total = 0;

            foreach ($allProductos as $ap) {
                $total++;
            }

            $productoCantidades['total'][0] = $total;

            //cargar el monto total ventas por meses y año
            $ventas_enero = 0;
            $ventas_febrero = 0;
            $ventas_marzo = 0;
            $ventas_abril = 0;
            $ventas_mayo = 0;
            $ventas_junio = 0;
            $ventas_julio = 0;
            $ventas_agosto = 0;
            $ventas_septiembre = 0;
            $ventas_octubre = 0;
            $ventas_noviembre = 0;
            $ventas_diciembre = 0;

            $year = date('Y');

            $totalVentasYear = 0;

            $allVentas = $em->getRepository('BrioozVentasBundle:Venta')->findAll();
            foreach ($allVentas as $venta) {
                if ($venta->getFecha()->format('Y') == $year) {
                    if ($venta->getFecha()->format('m') == "01") {
                        $ventas_enero += $venta->getTotal();
                    }
                    if ($venta->getFecha()->format('m') == "02") {
                        $ventas_febrero += $venta->getTotal();
                    }
                    if ($venta->getFecha()->format('m') == "03") {
                        $ventas_marzo += $venta->getTotal();
                    }
                    if ($venta->getFecha()->format('m') == "04") {
                        $ventas_abril += $venta->getTotal();
                    }
                    if ($venta->getFecha()->format('m') == "05") {
                        $ventas_mayo += $venta->getTotal();
                    }
                    if ($venta->getFecha()->format('m') == "06") {
                        $ventas_junio += $venta->getTotal();
                    }
                    if ($venta->getFecha()->format('m') == "07") {
                        $ventas_julio += $venta->getTotal();
                    }
                    if ($venta->getFecha()->format('m') == "08") {
                        $ventas_agosto += $venta->getTotal();
                    }
                    if ($venta->getFecha()->format('m') == "09") {
                        $ventas_septiembre += $venta->getTotal();
                    }
                    if ($venta->getFecha()->format('m') == "10") {
                        $ventas_octubre += $venta->getTotal();
                    }
                    if ($venta->getFecha()->format('m') == "11") {
                        $ventas_noviembre += $venta->getTotal();
                    }
                    if ($venta->getFecha()->format('m') == "12") {
                        $ventas_diciembre += $venta->getTotal();
                    }
                }
            }

            $cantidadVentaMeses = array();
            $cantidadVentaMeses[0] = $ventas_enero;
            $cantidadVentaMeses[1] = $ventas_febrero;
            $cantidadVentaMeses[2] = $ventas_marzo;
            $cantidadVentaMeses[3] = $ventas_abril;
            $cantidadVentaMeses[4] = $ventas_mayo;
            $cantidadVentaMeses[5] = $ventas_junio;
            $cantidadVentaMeses[6] = $ventas_julio;
            $cantidadVentaMeses[7] = $ventas_agosto;
            $cantidadVentaMeses[8] = $ventas_septiembre;
            $cantidadVentaMeses[9] = $ventas_octubre;
            $cantidadVentaMeses[10] = $ventas_noviembre;
            $cantidadVentaMeses[11] = $ventas_diciembre;


            //productos por categoria
            $totalProductosHombre=count($em->getRepository('BrioozTaskBundle:Producto')->findBy(array('categoria'=>1)));
            $totalProductosMujer=count($em->getRepository('BrioozTaskBundle:Producto')->findBy(array('categoria'=>2)));
            $totalProductosKids=count($em->getRepository('BrioozTaskBundle:Producto')->findBy(array('categoria'=>3)));
            $totalProductosAccesorios=count($em->getRepository('BrioozTaskBundle:Producto')->findBy(array('categoria'=>4)));




            return $this->render('BrioozTaskBundle:Usuario:inicio.html.twig', array('ventas' => $ventas, 'cantPorProveedor' => $cantPorProveedor, 'cantidadCompraMeses' => $cantidadCompraMeses,
                'valoresMaximo' => $valoresMaximo, 'valoresMinimo' => $valoresMinimo, 'productoCantidades' => $productoCantidades,'cantidadVentaMeses'=>$cantidadVentaMeses,
                'totalProductosHombre'=>$totalProductosHombre,'totalProductosMujer'=>$totalProductosMujer,'totalProductosKids'=>$totalProductosKids,'totalProductosAccesorios'=>$totalProductosAccesorios));
        }else{
            return $this->redirectToRoute('briooz_usuario_inicio');
        }
    }

    private function cantidadComprarProveedor($compras, $proveedor) {
        $cant = 0;
        $monto = 0;

        $datos = array();

        foreach ($compras as $compra) {
            if ($compra->getProveedor()->getId() == $proveedor->getId()) {
                $cant++;
                $monto += $compra->getTotal();
            }
        }

        $datos[0] = $cant;
        $datos[1] = $monto;

        return $datos;
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository('BrioozTaskBundle:Usuario')->findBy(array(),array('nombre'=>'ASC'));
        $delete_form_ajax = $this->createCustomForm('USUARIO_ID', 'DELETE', 'briooz_usuario_delete');

        return $this->render('BrioozTaskBundle:Usuario:index.html.twig', array('usuarios' => $usuarios, 'delete_form_ajax' => $delete_form_ajax->createView()));
    }

    public function addAction() {
        return $this->render('BrioozTaskBundle:Usuario:add.html.twig');
    }

    public function changePasswordAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $password = $request->get('password');
        $id = $request->get('id');

        $usuario = $em->getRepository('BrioozTaskBundle:Usuario')->find($id);

        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($usuario, $password);

        $usuario->setPassword($encoded);

        $em->persist($usuario);
        $em->flush();

        return new Response(
                json_encode(array('password' => $password)), 200, array('Content-Type' => 'application/json')
        );
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('BrioozTaskBundle:Usuario')->find($id);

        if ($usuario == null) {
            return $this->redirectToRoute('briooz_usuario_index');
        }

        return $this->render('BrioozTaskBundle:Usuario:edit.html.twig', array('usuario' => $usuario));
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id_usuario');

        $usuario = $em->getRepository('BrioozTaskBundle:Usuario')->find($id);
        $usuario = new Usuario();

        $nombres = $request->get('nombres');
        $apellidos = $request->get('apellidos');
        $email = $request->get('email');
        $telefono = $request->get('telefono');
        $rol = $request->get('rol');
        $activo = $request->get('activo');
    }

    public function creadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $usuario = new Usuario();
        $usuario1 = $request->get('usuario');
        $nombres = $request->get('nombres');
        $apellidos = $request->get('apellidos');
        $email = $request->get('email');
        $telefono = $request->get('telefono');
        $password = $request->get('password');
        $rol = $request->get('rol');
        $activo = $request->get('activo');

        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($usuario, $password);

        $usuario->setUsuario($usuario1);
        $usuario->setNombre($nombres);
        $usuario->setApellidos($apellidos);
        $usuario->setTelefono($telefono);
        $usuario->setEmail($email);
        $usuario->setPassword($encoded);

        if ($activo == 1) {
            $usuario->setIsActive(1);
        } else {
            $usuario->setIsActive(0);
        }

        $usuario->setRole($rol);
        $usuario->setAvatar("perfil-falso.jpg"); //temporalmente
        $usuario->setUltimaConexion(new \DateTime('0000-00-00 00:00:00'));

        $em->persist($usuario);
        $em->flush();

        return $this->redirectToRoute('briooz_usuario_index');
    }

    private function createCustomForm($id, $method, $route) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl($route, array('id' => $id)))
                        ->setMethod($method)
                        ->getForm();
    }

    function isMismaSemana($fecha) {
        $anno = date("Y");
        $mes = date("m");
        $dia = date("d");

        // numero de la semana
        $semana = date("W", mktime(0, 0, 0, $mes, $dia, $anno));

        $valoresFecha = explode("-", $fecha);

        $dia2 = $valoresFecha[2];
        $mes2 = $valoresFecha[1];
        $anno2 = $valoresFecha[0];

        $semanaFecha = date("W", mktime(0, 0, 0, $mes2, $dia2, $anno2));



        if ($semana == $semanaFecha && $anno == $anno2) {
            return true;
        }

        return false;
    }

    public function passwordAction() {

        return $this->render('BrioozTaskBundle:Security:reset.html.twig', array('error' => 0));
    }

    public function resetAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $email = $request->get('email');

        $usuario = $em->getRepository('BrioozTaskBundle:Usuario')->findOneBy(array('email' => $email));

        if ($usuario == null) {
            return $this->render('BrioozTaskBundle:Security:reset.html.twig', array('error' => 1));
        } else {
            $password = $request->get('password');

            $longitud = 10;
            $key = '';
            $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $max = strlen($pattern) - 1;
            for ($i = 0; $i < $longitud; $i++) {
                $key .= $pattern{mt_rand(0, $max)};
            }

            $usuario->setCodigo($key);

            $em->persist($usuario);
            $em->flush();

            //enviar el email

            $message = \Swift_Message::newInstance()
                    ->setSubject('Código de verificación')
                    ->setFrom('soporte@briooz.com')
                    ->addTo($usuario->getEmail())
                    ->setBody(
                    $this->renderView(
                            'BrioozEmailBundle:Emails:codigo.html.twig', array('codigo' => $key,
                            )
                    ), 'text/html'
                    )
            ;
            $this->get('mailer')->send($message);

            return $this->render('BrioozTaskBundle:Security:codigo.html.twig', array('password' => $password, 'usuario' => $usuario, 'error' => 0));
        }
    }

}
