<?php

namespace Briooz\EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BrioozEmailBundle:Default:index.html.twig', array('name' => $name));
    }
}
