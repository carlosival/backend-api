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
     * @Rest\Post("/receta")
     */
    public function newAction(Request $request)
    {
        return $this->processFormNew( $request,new Receta());
    }

    /**
     *
     * @Rest\Put("/receta/{id}")
     *
     */
    public function editAction( Request $request, $id)
    {
        return $this->processFormEdit($request, $id);
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

    private function processFormNew(Request $request,Receta $receta)
    {

        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $idsusuario = $data['user'];
        $usuario = $em->getRepository('DietaBundle:User')->find($idsusuario);

        if ($usuario === null) {
            throw new NotFoundHttpException('Usuario dueño de la receta no encontrado');
        }

        $receta ->setUser($usuario);
        unset($data['user']);

        foreach ($data as $dataproperty => $value)
        {
            if (property_exists('DietaBundle\\Entity\\Receta',$dataproperty )  && method_exists('DietaBundle\\Entity\\Receta', $setmetodo = 'set'. ucfirst($dataproperty))                       )
             {

               $receta->$setmetodo($value);
             }
        }

        $validator = $this->get('validator');
        $errors = $validator->validate($receta);


        if ( $er=$errors->count() === 0){


            $em->persist($receta);
            $em->flush();

            $response = new Response();
            $response->setStatusCode(201);
            $response->headers->set('Location',
                $this->generateUrl(
                    'dieta_receta_get', array('id' => $receta->getId()), //buscar la url de obtner receta esto esta mal
                    true // absolute
                )
            );

            return $response;
        }
        $response =new Response((string) $errors);
        $response->setStatusCode(400);
        return $response;

       /* $form = $this->createForm('DietaBundle\Form\RecetaType', $receta);
       // $form->submit($data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($receta);
            $em->flush();

            $response = new Response();
            $response->setStatusCode(201);

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

        return View::create($form, 400);*/
    }

    public function objectToArray($data)
    {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        if (is_array($data)) {
            return array_map(array($this, 'objectToArray'), $data);
        }

        return $data;
    }

}
