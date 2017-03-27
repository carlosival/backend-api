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
     * @Rest\Get("/dietas")                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ("/dietas")
     * @Rest\View()
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
            'dieta_dieta_all', // route
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
     * @Rest\View()
     */
    public function getAction($id)
    {
        $entity = $this->getDoctrine()->getRepository('DietaBundle:Dieta')->find($id);

        if (!$entity instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        $resposne = $this->createApiResponse($entity, 200);
        return $resposne;
        //return array('dieta' => $entity);
    }


    /**
     * @Rest\Post("/dieta")
     * @Rest\View()
     */
    public function newAction(Request $request)
    {
        return $this->processFormNew( $request,new Dieta());
    }

    /**
     *
     * @Rest\Put("/dieta/{id}")
     * @Rest\View()
     */
    public function editAction( Request $request, $id)
    {
        return $this->processFormEdit($request, $id);
    }


    /**
     * @Rest\Delete("/dieta/{id}")
     * @Rest\View()
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

        $response = $this->createApiResponse(null, 204);
        return $response;

    }



    /**
     * @Rest\Get("/dieta/{id}/seguidores")
     * @Rest\View()
     */
    public function usuarios_seguidoresAction(Request $request, $id){

        $sn = $this->getDoctrine()->getManager();
        $entity = $sn->getRepository('DietaBundle:Dieta')->find($id);


        if (!$entity instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        $usuarios_seguidores = $entity->getUsuariosSeguidores();


        $limit = $request->query->get('limit', 5);
        $page = $request->query->get('page', 1);
        // my manual, silly pagination logic. Use a real library like Pagerfanta
        $offset = ($page - 1) * $limit;
        $numberOfPages = (int) ceil(count($usuarios_seguidores) / $limit);



        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                array_slice( $usuarios_seguidores->getValues(),$offset,$limit),
                'usuarios_seguidores', // embedded rel
                'usuarios_seguidores'  // xml element name
            ),
            'dieta_dieta_usuarios_seguidores', // route
            array("id"=>$id), // route parameters
            $page,       // page number
            $limit,      // limit
            $numberOfPages       // total pages

        );


        $response = $this->createApiResponse($paginatedCollection, 200);
        return $response;
    }

    /**
     * @Rest\Delete("/dieta/{dietaid}/user/{userid}")
     * @Rest\View()
     */
    public function usuario_seguidor (Request $request, $dietaid, $userid) {

        $sn = $this->getDoctrine()->getManager();
        $resource = $sn->getRepository('DietaBundle:Dieta')->find($dietaid);
        $sub_resource = $sn->getRepository('DietaBundle:User')->find($userid);

        if (!$resource instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        if (!$sub_resource instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        $resource->removeUsuariosSeguidore($sub_resource);
        $sn->flush();

        $response = $this->createApiResponse($resource, 204);
        return $response;
    }

    /**
     * @Rest\Post("/dieta/{dietaid}/user/{userid}")
     * @Rest\View()
     */
    public function addusuario_seguidor(Request $request, $dietaid, $userid){

        $sn = $this->getDoctrine()->getManager();
        $resource = $sn->getRepository('DietaBundle:Dieta')->find($dietaid);
        $subresource = $sn->getRepository('DietaBundle:User')->find($userid);

        if (!$resource instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        if (!$subresource instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        $resource->addUsuariosSeguidore($subresource);
        $sn->persist($resource);
        $sn->flush();

        $response = $this->createApiResponse($resource, 200);
        return $response;

    }

    /**
     * @Rest\Get("/dieta/{id}/dietaitems")
     * @Rest\View()
     */
    public function dieta_dietaitemsAction(Request $request, $id){

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
                array_slice( $dietaitems->getValues(),$offset,$limit),
                'dieta_dietaitems', // embedded rel
                'dieta_dietaitems'  // xml element name
            ),
            'dieta_dieta_dieta_dietaitems', // route
            array("id"=>$id), // route parameters
            $page,       // page number
            $limit,      // limit
            $numberOfPages       // total pages

        );


        $response = $this->createApiResponse($paginatedCollection, 200);
        return $response;
    }

    /**
     * @Rest\Delete("/dieta/{dietaid}/dietaitem/{dietaitemid}")
     * @Rest\View()
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

        $response = $this->createApiResponse($resource, 204);
        return $response;
    }

    /**
     * @Rest\Post("/dieta/{dietaid}/dietaitem/{dietaitemid}")
     *
     * @Rest\View()
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

        $response = $this->createApiResponse($resource, 200);
        return $response;

    }




    /**
     * @Rest\Get("/dieta/{id}/owner")
     * @Rest\View()
     */
    public function ownerAction (Request $request, $id){

        $sn = $this->getDoctrine()->getManager();
        $resource= $sn->getRepository('DietaBundle:Dieta')->find($id);


        if (!$resource instanceof Dieta) {
            throw new NotFoundHttpException('Dieta not found');
        }

        $subresource = $resource->getUser();

        $response = $this->createApiResponse($subresource, 200);
        return $response;
    }


    private function processFormNew(Request $request,Dieta $dieta)
    {

        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        if(isset($data['user'])) {
            $idsusuario = $data['user'];
            $usuario = $em->getRepository('DietaBundle:User')->find($idsusuario);

            if ($usuario === null) {
                throw new NotFoundHttpException('Usuario dueño de la receta no encontrado');
            }

            $dieta->setUser($usuario);
            unset($data['user']);
        }
        foreach ($data as $dataproperty => $value)
        {
            if (property_exists('DietaBundle\Entity\Receta',$dataproperty )  && method_exists('DietaBundle\Entity\Receta', $setmetodo = 'set'. ucfirst($dataproperty))                       )
            {

                $dieta->$setmetodo($value);
            }
        }

        $validator = $this->get('validator');
        $errors = $validator->validate($dieta);


        if ( $er=$errors->count() === 0){


            $em->persist($dieta);
            $em->flush();

            $response = $this->createApiResponse($dieta, 201);

            $response->headers->set('Location',
                $this->generateUrl(
                    'dieta_dieta_get', array('id' => $dieta->getId()), //buscar la url de obtner receta esto esta mal
                    true // absolute
                )
            );

            return $response;
        }
        $response = $this->createApiResponse((string) $errors,400);
        return $response;

    }

    private function processFormEdit(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $dieta = $em->getRepository('DietaBundle:Dieta')->find($id);

        if ($dieta === null) {
            throw new NotFoundHttpException('Dieta Not Found');
        }

        if(isset($data['user'])) {
            $idsusuario = $data['user'];
            $usuario = $em->getRepository('DietaBundle:User')->find($idsusuario);

            if ($usuario === null) {
                throw new NotFoundHttpException('Usuario dueño de la receta no encontrado');
            }

            $dieta->setUser($usuario);
            unset($data['user']);
        }


        foreach ($data as $dataproperty => $value)
        {
            if (property_exists('DietaBundle\Entity\Dieta',$dataproperty )  && method_exists('DietaBundle\Entity\Dieta', $setmetodo = 'set'. ucfirst($dataproperty))                       )
            {

                $dieta->$setmetodo($value);
            }
        }

        $validator = $this->get('validator');
        $errors = $validator->validate($dieta);


        if ( $er=$errors->count() === 0){


            $em->persist($dieta);
            $em->flush();

            $response = $this->createApiResponse($dieta,200);
            return $response;
        }

        $response =$this->createApiResponse((string) $errors,400);
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
