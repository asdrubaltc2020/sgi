<?php

namespace Briooz\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificacionController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        return $this->render('BrioozAdminBundle:Notificaciones:notificaciones.html.twig');
    }


}
