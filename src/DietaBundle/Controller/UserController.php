<?php

namespace DietaBundle\Controller;

use DietaBundle\Form\UserType;
use JMS\Serializer\SerializationContext;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DietaBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Security("is_granted('IS_AUTHENTICATED_FULLY')")
 */
class UserController extends FOSRestController
{

    /**
     * @Rest\Post("/user/{id}/avatar")
     * @Rest\View()
     */
    public function uploadAction(Request $request, $id){

        $sn = $this->getDoctrine()->getManager();
        $user = $sn->getRepository('DietaBundle:User')->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        $images = $request->files->all();

        foreach ($images as $key => $value){

            if( $value instanceof UploadedFile){

                $user->setImageFile($value);
                $sn->flush();


                $helper = $this->get('vich_uploader.templating.helper.uploader_helper');
                $baseUrl = $request->getSchemeAndHttpHost() . $request->getBasePath();
                $path = $baseUrl . $helper->asset($user, 'imageFile');

                $response = $this->createApiResponse($user, 200);
                $response->headers->set('Location',$path );

                return $response;

            }
            $response =new Response();
            $response->setStatusCode(400);
            return $response;
        }

    }

    /**
     * @Rest\Get("/user/{id}/avatar")
     * @Rest\View()
     */
    public function pictureAction(Request $request, $id){

        $sn = $this->getDoctrine()->getManager();
        $user = $sn->getRepository('DietaBundle:User')->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        $helper = $this->get('vich_uploader.templating.helper.uploader_helper');

        $baseUrl = $request->getSchemeAndHttpHost() . $request->getBasePath();
        $path = $baseUrl . $helper->asset($user, 'imageFile');



        $response = $this->createApiResponse($path, 200);
        return $response;
    }

    /**
     * @Rest\Get("/user/{id}/recetasseguidas")
     * @Rest\View
     *
     */
    public function recetaSeguidasAction(Request $request, $id) {


        $sn = $this->getDoctrine()->getManager();
        $user = $sn->getRepository('DietaBundle:User')->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }
        $recetasseguidas = $user->getRecetasSeguidas();

        $resposne = $this->createApiResponse($recetasseguidas, 200);

    }

    /**
     * @Rest\Get("/user/{id}/recetas")
     * @Rest\View
     *
     */
      public function recetasAction(Request $request, $id) {


          $sn = $this->getDoctrine()->getManager();
          $user = $sn->getRepository('DietaBundle:User')->find($id);

          if (!$user instanceof User) {
              throw new NotFoundHttpException('User not found');
          }
          $recetas = $user->getRecetas();

          $resposne = $this->createApiResponse($recetas, 200);

      }

    /**
     * @Rest\Get("/user/{id}/dietaseguidas")
     * @Rest\View
     *
     */
    public function dietasAction(Request $request, $id) {

        $sn = $this->getDoctrine()->getManager();
        $user = $sn->getRepository('DietaBundle:User')->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }
        $dietaseguidas = $user->getDietaSeguidas();

        $resposne = $this->createApiResponse($dietaseguidas, 200);

    }

    /**
     * @Rest\Get("/user/{id}/owndietas")
     * @Rest\View
     *
     */
    public function owndietasAction(Request $request, $id) {

        $sn = $this->getDoctrine()->getManager();
        $user = $sn->getRepository('DietaBundle:User')->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }
        $dietas = $user->getDietas();

        $resposne = $this->createApiResponse($dietas, 200);

    }



    /**
     * @Rest\Get("/user/{id}/friends")
     * @Rest\View
     *
     */

    public function friendsAction(Request $request, $id) {

        $sn = $this->getDoctrine()->getManager();
        $user = $sn->getRepository('DietaBundle:User')->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }
        $friends = $user->getMyFriends();

        $resposne = $this->createApiResponse($friends, 200);

    }

    /**
     * @Rest\Get("/users")
     * @Rest\View
     *
     *
     */
    public function allAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DietaBundle:User')->findAll();

        return array('users' => $restresult);

/*
         $data = array("Usuarios" => array(
            array(
                "nombre"   => "Víctor",
                "Apellido" => "Robles"
            ),
            array(
                "nombre"   => "Antonio",
                "Apellido" => "Martinez"
            )));

        return $data;*/

    }




    /**
     * @Rest\Get("/user/{id}")
     * @Rest\View
     */
    public function getAction($id)
    {

        $restresult = $this->getDoctrine()->getRepository('DietaBundle:User')->find($id);

        if (!$restresult instanceof User) {
            throw new NotFoundHttpException('Usuario not found');
        }

        return array('usuario' => $restresult);
    }




    /**
     * Alias a Registrar usuario.
     * @Rest\Post("/user")
     * @Rest\View
     *
     */
    public function newAction(Request $request)
    {
        return $this->processFormNew(new User(),$request);
    }

    /**
     * Edit o update action
     * @Rest\Put("/user/{id}")
     */
    public function editAction($id,Request $request)
    {
        return $this->processFormEdit($id,$request);
    }


    /**
     * @Rest\Delete("/user/{id}")
     * @Rest\View(statusCode=204)
     */
    public function deleteAction($id)
    {

        $sn = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('DietaBundle:User')->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('Usuario not found');
        }

        $sn->remove($user);
        $sn->flush();

        $response=new Response();
        return $response->setStatusCode(Response::HTTP_OK);

    }




    private function processFormNew(User $user,Request $request)
    {
           $data = json_decode($request->getContent(), true);

           $form = $this ->createForm( 'DietaBundle\Form\UserType',$user);

           $form->submit($data);

           if($form->isSubmitted() && $form->isValid()){


               return new Response($request->getContent()) ;
            }

        //$statusCode = $user->isNew() ? 201 : 204;
 // Obtenger datos del request
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');
 // Validar datos del request

 // Insertar datos a la base datos
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);

        // Salvar usuario en la Base de Datos
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

 // Doy una repuesta afirmativa o negativa en el HTTP HEADER.

        $response = new Response();
        $statusCode=201;
        // set the `Location` header only when creating new resources
        if (201 === $statusCode) {
            $response->setStatusCode(Response::HTTP_CREATED);
            $response->headers->set('Location',
                $this->generateUrl(
                    'dieta_user_get', array('id' => $user->getId()),
                    true // absolute
                )
            );
          return $response;
        }

        return $response->setStatusCode(Response::HTTP_BAD_REQUEST);
    }

    private function processFormEdit($id,Request $request)
    {
        // Obtenger datos del request

        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        // Validar datos del request
        $sn = $this->getDoctrine()->getManager();
        $user = $sn->getRepository('DietaBundle:User')->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('Usuario not found');
        }

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $sn->flush();

        $statusCode = 200;

        $response = new Response();

        if (200 === $statusCode) {

            $response->setStatusCode(Response::HTTP_OK);
            return $response;
        }

        return $response->setStatusCode(Response::HTTP_BAD_REQUEST);
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
