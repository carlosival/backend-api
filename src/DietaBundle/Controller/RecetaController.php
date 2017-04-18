<?php

namespace DietaBundle\Controller;

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
use DietaBundle\Entity\Receta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Security("is_granted('IS_AUTHENTICATED_FULLY')")
 */
class RecetaController extends FOSRestController
{

    /**
     *
     *  This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Receta",
     *  resource=true,
     *  description=" ",
     *  statusCodes={
     *         200=" Devuelve la lista de Recetas"
     *  },
     * )
     *
     *
     * @Rest\Get("/recetas")
     * @Rest\View()
     */
    public function allAction(Request $request)
    {

        $recetas = $this->getDoctrine()->getRepository('DietaBundle:Receta')->findAll();

        $limit = $request->query->get('limit', 15);
        $page = $request->query->get('page', 1);
        // my manual, silly pagination logic. Use a real library like Pagerfanta
        $offset = ($page - 1) * $limit;
        $numberOfPages = (int) ceil(count($recetas) / $limit);

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
        array_slice($recetas, $offset, $limit),
        'recetas', // embedded rel
        'recetas'  // xml element name
    ),
    'dieta_receta_all', // route
    array(), // route parameters
    $page,       // page number
    $limit,      // limit
    $numberOfPages       // total pages

    );


        $response = $this->createApiResponse($paginatedCollection, 200);
        return $response;

    }

    /**
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Receta",
     *  resource=true,
     *  description=" ",
     *  statusCodes={
     *         200=" Obtiene una receta a partir del id proporcionado",
     *         404=" Si la receta no se encuentra "
     *  },
     *
     *   requirements={
     *      {
     *          "name"="id",
     *          "dataType"="numero",
     *          "requirement"="*",
     *          "description"="usuario id"
     *      }
     *  },
     *
     *
     * )
     *
     *
     * @Rest\Get("/receta/{id}")
     * @Rest\View
     */
    public function getAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('DietaBundle:Receta')->find($id);

        if (!$singleresult instanceof Receta) {
            throw new NotFoundHttpException('Receta not found');
        }
        $response = $this->createApiResponse($singleresult,200);
        return $response;

    }


    /**
     *
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Receta",
     *  resource=true,
     *  description=" ",
     *  *  statusCodes={
     *         201=" Crea una receta",
     *         400=" Cuando no es posible crear la receta debido a un error en la peticion "
     *  },
     *
     * *  requirements={
     *      {
     *          "name"="nombre",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="nombre de la receta"
     *      },
     *     {
     *          "name"="ingredientes",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="Arreglo con el orden de las operaciones en formato string ejemplo [' 2 spone sugar ','2 egg' ,' 1 gr apple']"
     *      },
     *      {
     *          "name"="preparacion",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="Arreglo con el orden de las operaciones en formato string ejemplo ['step1 do thing','step2 do next thing' ]"
     *      },
     *     {
     *          "name"="tiempopreparacion",
     *          "dataType"="numero",
     *          "requirement"="*",
     *          "description"="Cuanto tiempo demora realizar la preparacion"
     *      },
     *      {
     *          "name"="descripcion",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="Descripcion de como se realiza y lo que representa la receta."
     *      },
     *      {
     *          "name"="raciones",
     *          "dataType"="numero",
     *          "requirement"="*",
     *          "description"="Para cuantos comensales es la receta"
     *      }
     *},
     *
     *
     * )
     *
     *
     * @Rest\Post("/receta")
     */
    public function newAction(Request $request)
    {

        return $this->processFormNew( $request,new Receta());
    }

    /**
     *
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Receta",
     *  resource=true,
     *  description=" ",
     *  *  statusCodes={
     *         200=" Receta modificada satisfactoriamente",
     *         400=" Cuando no es posible modificar la receta debido a un error en la peticion "
     *  },
     *
     *  requirements={
     *      {
     *          "name"="nombre",
     *          "dataType"="string",
     *          "description"="nombre de la receta"
     *      },
     *     {
     *          "name"="ingredientes",
     *          "dataType"="string",
     *          "description"="Arreglo con el orden de las operaciones en formato string ejemplo [' 2 spone sugar ','2 egg' ,' 1 gr apple']"
     *      },
     *      {
     *          "name"="preparacion",
     *          "dataType"="string",
     *          "description"="Arreglo con el orden de las operaciones en formato string ejemplo ['step1 do thing','step2 do next thing' ]"
     *      },
     *     {
     *          "name"="tiempopreparacion",
     *          "dataType"="numero",
     *          "description"="Cuanto tiempo demora realizar la preparacion"
     *      },
     *      {
     *          "name"="descripcion",
     *          "dataType"="string",
     *          "description"="Descripcion de como se realiza y lo que representa la receta."
     *      },
     *      {
     *          "name"="raciones",
     *          "dataType"="numero",
     *          "description"="Para cuantos comensales es la receta"
     *      }
     *},
     *
     *
     * )
     *
     * @Rest\Put("/receta/{id}")
     *
     */
    public function editAction( Request $request, $id)
    {
        return $this->processFormEdit($request, $id);
    }


    /**
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Receta",
     *  description="Eiminar receta",
     *  statusCodes={
     *         204=" Receta no existe sea por que se elimino o por que no se encontro",
     *  },
     *
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="numero",
     *          "requirement"="*",
     *          "description"="usuario id"
     *      }
     *  },
     *  )
     *
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

        $response = $this->createApiResponse(null ,204 );
       return $response;
    }

    /**
     ** This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Receta",
     *  resource=true,
     *  description=" ",
     *  statusCodes={
     *         201=" Subir la imagen de la receta ",
     *         400=" No es posible subir la foto por errores en la peticion ",
     *         404=" Cuando no es posible subir la foto por que la receta asociada no se encuentra "
     *  },
     *)
     *
     * @Rest\Post("/receta/{id}/picture")
     * @Rest\View()
     */
    public function uploadAction(Request $request, $id){

        $sn = $this->getDoctrine()->getManager();
        $receta = $sn->getRepository('DietaBundle:Receta')->find($id);

        if (!$receta instanceof Receta) {
            throw new NotFoundHttpException('Receta not found');
        }

        $images = $request->files->all();

        foreach ($images as $key => $value){

            if( $value instanceof UploadedFile){

                $receta->setImageFile($value);
                $sn->flush();



                $response = new Response();
                $response->setStatusCode(201);

               # $response->headers->set('Location',$path);

                $response->headers->set('Location',
                    $this->generateUrl(
                        'dieta_receta_get', array('id' => $receta->getId()), //buscar la url de obtner receta esto esta mal
                        true // absolute
                    )
                );

                return $response;

            }
            $response =new Response();
            $response->setStatusCode(400);
            return $response;
        }

    }

    /**
     * @Rest\Get("/receta/{id}/picture")
     * @Rest\View()
     */
    public function pictureAction(Request $request, $id){

        $sn = $this->getDoctrine()->getManager();
        $receta = $sn->getRepository('DietaBundle:Receta')->find($id);

        if (!$receta instanceof Receta) {
            throw new NotFoundHttpException('Receta not found');
        }

        $helper = $this->get('vich_uploader.templating.helper.uploader_helper');

        $baseUrl = $request->getSchemeAndHttpHost() . $request->getBasePath();
        $path = $baseUrl . $helper->asset($receta, 'imageFile');



        $response = $this->createApiResponse($path, 200);
        return $response;
    }



    /**
     * @Rest\Get("/receta/{id}/seguidores")
     * @Rest\View()
     */
    public function usuarios_seguidoresAction(Request $request, $id){

        $sn = $this->getDoctrine()->getManager();
        $receta = $sn->getRepository('DietaBundle:Receta')->find($id);


        if (!$receta instanceof Receta) {
            throw new NotFoundHttpException('Receta not found');
        }

        $usuarios_seguidores = $receta->getUsuarioSeguidores();


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
            'dieta_receta_usuarios_seguidores', // route
            array("id"=>$id), // route parameters
            $page,       // page number
            $limit,      // limit
            $numberOfPages       // total pages

        );


        $response = $this->createApiResponse($paginatedCollection, 200);
        return $response;
    }

    /**
     * @Rest\Delete("/receta/{recetaid}/user/{userid}")
     * @Rest\View(statusCode=204)
     */
    public function usuario_seguidor (Request $request, $recetaid, $userid) {

        $sn = $this->getDoctrine()->getManager();
        $receta = $sn->getRepository('DietaBundle:Receta')->find($recetaid);
        $user = $sn->getRepository('DietaBundle:User')->find($userid);

        if (!$receta instanceof Receta) {
            throw new NotFoundHttpException('Receta not found');
        }

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        $receta->removeUsuarioSeguidores($user);
        $sn->flush();

        $response = $this->createApiResponse($receta, 204, 'json');
        return $response;
    }

    /**
     * @Rest\Post("/receta/{recetaid}/user/{userid}")
     * @Rest\View(statusCode=200)
     */
    public function addusuario_seguidor(Request $request, $recetaid, $userid){

        $sn = $this->getDoctrine()->getManager();
        $receta = $sn->getRepository('DietaBundle:Receta')->find($recetaid);
        $user = $sn->getRepository('DietaBundle:User')->find($userid);

        if (!$receta instanceof Receta) {
            throw new NotFoundHttpException('Receta not found');
        }

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        $receta->addUsuarioSeguidores($user);
        $sn->persist($receta);
        $sn->flush();

        $response = $this->createApiResponse($receta, 200, 'json');
        return $response;

    }



    /**
     * @Rest\Get("/receta/{id}/owner")
     * @Rest\View()
     */
    public function ownerAction (Request $request, $id){

        $sn = $this->getDoctrine()->getManager();
        $receta = $sn->getRepository('DietaBundle:Receta')->find($id);
        $owner = $receta->getUser();

        if (!$receta instanceof Receta) {
            throw new NotFoundHttpException('Receta not found');
        }

        $response = $this->createApiResponse($owner, 200, 'json');
        return $response;
    }


    private function processFormNew(Request $request,Receta $receta)
    {
       // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
       if(isset($data['user'])) {

        /*$idsusuario = $data['user'];
        $usuario = $em->getRepository('DietaBundle:User')->find($idsusuario);

        if ($usuario === null) {
            throw new NotFoundHttpException('Usuario dueño de la receta no encontrado');
        }

       // $receta ->setUser($usuario);*/
        unset($data['user']);

       }
        $receta->setUser($this->getUser());
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

            $response = $this->createApiResponse($receta,201);
            $response->headers->set('Location',
                $this->generateUrl(
                    'dieta_receta_get', array('id' => $receta->getId()), //buscar la url de obtner receta esto esta mal
                    true // absolute
                )
            );

            return $response;
        }

        $response = $this->createApiResponse((string) $errors, 400);
        return $response;

    }

    private function processFormEdit(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $receta = $em->getRepository('DietaBundle:Receta')->find($id);

        if ($receta === null) {
            throw new NotFoundHttpException('Receta Not Found');
        }


        foreach ($data as $dataproperty => $value)
        {
            if (property_exists('DietaBundle\Entity\Receta',$dataproperty )  && method_exists('DietaBundle\Entity\Receta', $setmetodo = 'set'. ucfirst($dataproperty))                       )
            {

                $receta->$setmetodo($value);
            }
        }

        $validator = $this->get('validator');
        $errors = $validator->validate($receta);


        if ( $er=$errors->count() === 0){


            $em->persist($receta);
            $em->flush();

            $response = $this->createApiResponse($receta,200);
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


}
