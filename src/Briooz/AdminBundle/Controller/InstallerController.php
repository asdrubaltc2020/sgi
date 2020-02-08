<?php

namespace Briooz\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InstallerController extends Controller
{
    public function indexAction()
    {
       return $this->render('BrioozAdminBundle:Install:newuser.html.twig');
    }
}
