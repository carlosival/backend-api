<?php

namespace DietaBundle\Controller;

use DietaBundle\Form\RecetaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DietaBundle\Entity\Receta;


class RecetaController extends FOSRestController
{

    /**
     * @Rest\Get("/recetas")
     * @Rest\View
     */
    public function allAction()
    {

        $restresult = $this->getDoctrine()->getRepository('DietaBundle:Receta')->findAll();

        return array('recetas' => $restresult);

    }

    /**
     * @Rest\Get("/receta/{id}")
     * @Rest\View
     */
    public function getAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('DietaBundle:Receta')->find($id);

        if (!$singleresult instanceof Receta) {
            throw new NotFoundHttpException('Receta not found');
        }

        return array('receta' => $singleresult);
    }

    /**
     * @Rest\Post("/receta/")
     */
    public function newAction()
    {
        return $this->processForm(new Receta());
    }

    /**
     *
     * @Rest\Put("/receta/{id}")
     *
     */
    public function editAction(Receta $receta)
    {
        return $this->processForm($receta);
    }


    /**
     * @Rest\Delete("/receta/{id}")
     * @Rest\View(statusCode=204)
     */
    public function deleteAction($id)
    {
        $sn = $this->getDoctrine()->getManager();
        $receta = $this->getDoctrine()->getRepository('DietaBundle:Receta')->find($id);

        if (!$receta instanceof Receta) {
            throw new NotFoundHttpException('Receta not found');
        }
        $sn ->remove($receta);
        $sn ->flush();
    }

    private function processForm(Receta $receta)
    {
        $statusCode = $receta->isNew() ? 201 : 204;

        $form = $this->createForm(new RecetaType(), $receta);
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {
                $response->headers->set('Location',
                    $this->generateUrl(
                        'dieta_receta_get', array('id' => $receta->getId()), //buscar la url de obtner receta esto esta mal
                        true // absolute
                    )
                );
            }

            return $response;
        }

        return View::create($form, 400);
    }



}
