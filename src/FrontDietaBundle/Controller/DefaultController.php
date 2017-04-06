<?php

namespace FrontDietaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return new Response('Under the sea!');
       // return $this->get('templating')->render('FrontDietaBundle:Default:index.html.twig', array());
    }
}
