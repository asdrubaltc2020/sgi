<?php

namespace Briooz\VentasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BrioozVentasBundle:Default:index.html.twig', array('name' => $name));
    }
}
