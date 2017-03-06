<?php

namespace DietaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DietaBundle:Default:index.html.twig');
    }
}
