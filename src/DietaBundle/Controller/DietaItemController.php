<?php

namespace DietaBundle\Controller;

use DietaBundle\Entity\Receta;
use DietaBundle\Entity\User;
use DietaBundle\Form\RecetaType;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;
use DietaBundle\Entity\DietaItem;


class DietaItemController extends FOSRestController
{
    /**
     * List all DietaItems
     *
     * @Rest\Get("/dietaitems")
     * @Rest\View
     */
    public function allAction(Request $request)
    {

        $dietaItems = $this->getDoctrine()->getRepository('DietaBundle:DietaItem')->findAll();

        $limit = $request->query->get('limit', 5);
        $page = $request->query->get('page', 1);
        // my manual, silly pagination logic. Use a real library like Pagerfanta
        $offset = ($page - 1) * $limit;
        $numberOfPages = (int) ceil(count($dietaItems) / $limit);

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                array_slice($dietaItems, $offset, $limit),
                'dietaitems', // embedded rel
                'dietaitems'  // xml element name
            ),
            'dieta_dietaitems_all', // route
            array(), // route parameters
            $page,       // page number
            $limit,      // limit
            $numberOfPages       // total pages

        );

        $response = $this->createApiResponse($paginatedCollection, 200, 'json');
        return $response;


    }

    
    /**
     * Finds a Item an show
     *
     * @Rest\Get("/dietaitem/{id}")
     * @Rest\View
     */
    public function getAction($id)
    {

        $dietaitem = $this->getDoctrine()->getRepository('DietaBundle:DietaItem')->find($id);

        if (!$dietaitem instanceof DietaItem) {
            throw new NotFoundHttpException('Dieta not found');
        }

        return array('receta' => $dietaitem);

    }


    /**
     * @Rest\Post("/dietaitem")
     */
    public function newAction(Request $request)
    {
        return $this->processFormNew( $request,new DietaItem());
    }

    /**
     *
     * @Rest\Put("/dietaitem/{id}")
     *
     */
    public function editAction(Request $request, $id)
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
        $dietaitem = $this->getDoctrine()->getRepository('DietaBundle:DietaItem')->find($id);

        if (!$dietaitem instanceof DietaItem) {
            throw new NotFoundHttpException('Dieta not found');
        }
        $sn ->remove($dietaitem);
        $sn ->flush();
    }


    /**
     * @Rest\Get("/dietaitem/{id}/recetas")
     * @Rest\View
     */
    public function dietaitem_recetasAction(Request $request, $id){

        $sn = $this->getDoctrine()->getManager();
        $dietaitem = $sn->getRepository('DietaBundle:DietaItem')->find($id);


        if (!$dietaitem instanceof DietaItem) {
            throw new NotFoundHttpException('DietaItem not found');
        }

        $recetas = $dietaitem->getRecetas();


        $limit = $request->query->get('limit', 5);
        $page = $request->query->get('page', 1);
        // my manual, silly pagination logic. Use a real library like Pagerfanta
        $offset = ($page - 1) * $limit;
        $numberOfPages = (int) ceil(count($recetas) / $limit);



        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                array_slice( $recetas,$offset,$limit),
                'usuarios_seguidores', // embedded rel
                'usuarios_seguidores'  // xml element name
            ),
            'dieta_receta_usuarios_seguidores', // route
            array("id"=>$id), // route parameters
            $page,       // page number
            $limit,      // limit
            $numberOfPages       // total pages

        );


        $response = $this->createApiResponse($paginatedCollection, 200, 'json');
        return $response;
    }


    /**
     * @Rest\Delete("/dietaitem/{dietaitemid}/receta/{recetaid}")
     * @Rest\View(statusCode=204)
     */
    public function dietaitem_receta (Request $request, $dietaitemid, $recetaid) {

        $sn = $this->getDoctrine()->getManager();
        $dietaitem = $sn->getRepository('DietaBundle:DietaItem')->find($dietaitemid);
        $receta = $sn->getRepository('DietaBundle:Receta')->find($recetaid);

        if (!$receta instanceof DietaItem) {
            throw new NotFoundHttpException('DietaItem not found');
        }

        if (!$receta instanceof Receta) {
            throw new NotFoundHttpException('Receta not found');
        }

        $dietaitem->removeReceta($receta);
        $sn->flush();

        $response = $this->createApiResponse($receta, 204, 'json');
        return $response;
    }


    /**
     * @Rest\Post("/dietaitem/{dietaitemid}/receta/{recetaid}")
     * @Rest\View(statusCode=204)
     */
    public function addietaitem_receta(Request $request, $dietaitemid, $recetaid){

        $sn = $this->getDoctrine()->getManager();
        $dietaitem = $sn->getRepository('DietaBundle:DietaItem')->find($dietaitemid);
        $receta = $sn->getRepository('DietaBundle:Receta')->find($recetaid);

        if (!$dietaitem instanceof DietaItem) {
            throw new NotFoundHttpException('DietaItem not found');
        }

        if (!$receta instanceof Receta) {
            throw new NotFoundHttpException('Receta not found');
        }

        $dietaitem->addReceta($receta);
        $sn->flush();

        $response = $this->createApiResponse($receta, 204, 'json');
        return $response;

    }


    private function processFormNew(Request $request,DietaItem $dietaitem)
    {

        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();


        foreach ($data as $dataproperty => $value)
        {
            if (property_exists('DietaBundle\\Entity\\DietaItem',$dataproperty )  && method_exists('DietaBundle\\Entity\\DietaIem', $setmetodo = 'set'. ucfirst($dataproperty))                       )
            {

                $dietaitem->$setmetodo($value);
            }
        }

        $validator = $this->get('validator');
        $errors = $validator->validate($dietaitem);


        if ( $er=$errors->count() === 0){

            $em->persist($dietaitem);
            $em->flush();

            $response = $this->createApiResponse($dietaitem, 204, 'json');

            $response->headers->set('Location',
                $this->generateUrl(
                    'dieta_dietaitem_get', array('id' => $dietaitem->getId()), //buscar la url de obtner receta esto esta mal
                    true // absolute
                )
            );

            return $response;
        }

        $response = $this->createApiResponse((string) $errors, 204, 'json');
        return $response;

    }


    protected function createApiResponse($data, $statusCode = 200)
    {
        $json = $this->serialize($data);
        return new Response($json, $statusCode, array(
            'Content-Type' => 'application/json'
        ));
    }
    protected function serialize($data, $format = 'json')
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);
        return $this->get('serializer')->serialize($data, $format, $context);
    }



}
