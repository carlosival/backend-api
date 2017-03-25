<?php

namespace DietaBundle\Controller;

use DietaBundle\Entity\Dieta;
use DietaBundle\Entity\DietaItem;
use DietaBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DietaBundle\Form\RecetaType;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;

class DietaController extends FOSRestController
{


    /**
     * @Rest\Get("/dietas")
     * @Rest\View
     */
    public function allAction(Request $request)
    {

        $entitys = $this->getDoctrine()->getRepository('DietaBundle:Dieta')->findAll();

        $limit = $request->query->get('limit', 5);
        $page = $request->query->get('page', 1);
        // my manual, silly pagination logic. Use a real library like Pagerfanta
        $offset = ($page - 1) * $limit;
        $numberOfPages = (int) ceil(count($entitys) / $limit);

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                array_slice($entitys, $offset, $limit),
                'dietas', // embedded rel
                'dietas'  // xml element name
            ),
            'dieta_dietas_all', // route
            array(), // route parameters
            $page,       // page number
            $limit,      // limit
            $numberOfPages       // total pages

        );


        $response = $this->createApiResponse($paginatedCollection, 200, 'json');
        return $response;

    }

    /**
     * @Rest\Get("/dieta/{id}")
     * @Rest\View
     */
    public function getAction($id)
    {
        $entity = $this->getDoctrine()->getRepository('DietaBundle:Dieta')->find($id);

        if (!$entity instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        return array('receta' => $entity);
    }


    /**
     * @Rest\Post("/dieta")
     */
    public function newAction(Request $request)
    {
        return $this->processFormNew( $request,new Dieta());
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
     * @Rest\Delete("/dieta/{id}")
     *
     */
    public function deleteAction($id)
    {
        $sn = $this->getDoctrine()->getManager();
        $entity = $this->getDoctrine()->getRepository('DietaBundle:Dieta')->find($id);

        if (!$entity instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }
        $sn ->remove($entity);
        $sn ->flush();

        $response = $this->createApiResponse(null, 200, 'json');
        return $response;

    }



    /**
     * @Rest\Get("/dieta/{id}/seguidores")
     * @Rest\View
     */
    public function usuarios_seguidoresAction(Request $request, $id){

        $sn = $this->getDoctrine()->getManager();
        $entity = $sn->getRepository('DietaBundle:Dieta')->find($id);


        if (!$entity instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        $usuarios_seguidores = $entity->getUsuarioSeguidores();


        $limit = $request->query->get('limit', 5);
        $page = $request->query->get('page', 1);
        // my manual, silly pagination logic. Use a real library like Pagerfanta
        $offset = ($page - 1) * $limit;
        $numberOfPages = (int) ceil(count($usuarios_seguidores) / $limit);



        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                array_slice( $usuarios_seguidores,$offset,$limit),
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
     * @Rest\Delete("/dieta/{dietaid}/user/{userid}")
     * @Rest\View(statusCode=204)
     */
    public function usuario_seguidor (Request $request, $resourceid, $subresourceid) {

        $sn = $this->getDoctrine()->getManager();
        $resource = $sn->getRepository('DietaBundle:Dieta')->find($resourceid);
        $sub_resource = $sn->getRepository('DietaBundle:User')->find($subresourceid);

        if (!$resource instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        if (!$sub_resource instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        $resource->removeUsuariosSeguidore($sub_resource);
        $sn->flush();

        $response = $this->createApiResponse($resource, 204, 'json');
        return $response;
    }

    /**
     * @Rest\Post("/dieta/{dietaid}/user/{userid}")
     * @Rest\View(statusCode=204)
     */
    public function addusuario_seguidor(Request $request, $resourceid, $subresourceid){

        $sn = $this->getDoctrine()->getManager();
        $resource = $sn->getRepository('DietaBundle:Dieta')->find($resourceid);
        $subresource = $sn->getRepository('DietaBundle:User')->find($subresourceid);

        if (!$resource instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        if (!$subresource instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        $resource->addUsuariosSeguidore($subresource);
        $sn->flush();

        $response = $this->createApiResponse($resource, 204, 'json');
        return $response;

    }

    /**
     * @Rest\Get("/dieta/{id}/dietaitems")
     * @Rest\View
     */
    public function dieta_dietaitemssAction(Request $request, $id){

        $sn = $this->getDoctrine()->getManager();
        $entity = $sn->getRepository('DietaBundle:Dieta')->find($id);


        if (!$entity instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        $dietaitems = $entity->getDietaItems();


        $limit = $request->query->get('limit', 5);
        $page = $request->query->get('page', 1);
        // my manual, silly pagination logic. Use a real library like Pagerfanta
        $offset = ($page - 1) * $limit;
        $numberOfPages = (int) ceil(count($dietaitems) / $limit);



        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                array_slice( $dietaitems,$offset,$limit),
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
     * @Rest\Delete("/dieta/{dietaid}/dietaitem/{dietaitemid}")
     * @Rest\View(statusCode=204)
     */
    public function dieta_dietaitem (Request $request, $dietaid, $dietaitemid) {

        $sn = $this->getDoctrine()->getManager();
        $resource = $sn->getRepository('DietaBundle:Dieta')->find($dietaid);
        $sub_resource = $sn->getRepository('DietaBundle:DietaItem')->find($dietaitemid);

        if (!$resource instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        if (!$sub_resource instanceof DietaItem) {
            throw new NotFoundHttpException('DietaItem not found');
        }

        $resource->removeDietaItem($sub_resource);
        $sn->flush();

        $response = $this->createApiResponse($resource, 204, 'json');
        return $response;
    }

    /**
     * @Rest\Post("/dieta/{dietaid}/dietaitem/{dietaitemid}")
     *
     * @Rest\View(statusCode=204)
     */
    public function addieta_dietaitem(Request $request, $dietaid, $dietaitemid){

        $sn = $this->getDoctrine()->getManager();
        $resource = $sn->getRepository('DietaBundle:Dieta')->find($dietaid);
        $subresource = $sn->getRepository('DietaBundle:DietaItem')->find($dietaitemid);

        if (!$resource instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        if (!$subresource instanceof DietaItem) {
            throw new NotFoundHttpException('DietaItem not found');
        }

        $resource->addDietaItem($subresource);
        $sn->flush();

        $response = $this->createApiResponse($resource, 204, 'json');
        return $response;

    }




    /**
     * @Rest\Get("/receta/{id}/owner")
     * @Rest\View
     */
    public function ownerAction (Request $request, $id){

        $sn = $this->getDoctrine()->getManager();
        $resource= $sn->getRepository('DietaBundle:Dieta')->find($id);


        if (!$resource instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        $subresource = $resource->getUser();

        $response = $this->createApiResponse($subresource, 200, 'json');
        return $response;
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
