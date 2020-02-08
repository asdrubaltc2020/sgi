<?php

namespace Briooz\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BrioozAdminBundle:Default:index.html.twig', array('name' => $name));
    }
}
