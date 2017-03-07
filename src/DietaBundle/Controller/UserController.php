<?php

namespace DietaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DietaBundle\Entity\User;


class UserController extends FOSRestController
{
    /**
     * @Rest\Get("/users")
     * @Rest\View
     *
     * Probar despues como quitarle la vista y hacerlo automatico con @Rest\View
     */
    public function getUsersAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DietaBundle:User')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;


        /*
         * Este ejemplo traabaja llamando a localhost/app_dev.php/users
         *
         * $data = array("Usuarios" => array(
            array(
                "nombre"   => "Víctor",
                "Apellido" => "Robles"
            ),
            array(
                "nombre"   => "Antonio",
                "Apellido" => "Martinez"
            )));

        return $data;

        */

    }




    /**
     * @Rest\Get("/user/{id}")
     * @Rest\View
     */
    public function idAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('DietaBundle:User')->find($id);
        if ($singleresult === null) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Post("/user/")
     */
    public function postAction(Request $request)
    {
        $data = new User;
        $name = $request->get('name');
        $role = $request->get('role');
        if(empty($name) || empty($role))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setName($name);
        $data->setRole($role);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("User Added Successfully", Response::HTTP_OK);
    }

   // williamduranway
    /**
     * edit o update action
     * Rest\Post("/user/")
     */
    public function newAction()
    {
        return $this->processForm(new User());
    }

    private function processForm(User $user)
    {
        $statusCode = $user->isNew() ? 201 : 204;

        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $user->save();

            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {
                $response->headers->set('Location',
                    $this->generateUrl(
                        'acme_demo_user_get', array('id' => $user->getId()),
                        true // absolute
                    )
                );
            }

            return $response;
        }

        return View::create($form, 400);
    }


    public function editAction(User $user)
    {
        return $this->processForm($user);
    }


    // williamduranway


    /**
     *
     *
     * @Rest\Put("/user/{id}")
     */
    public function updateAction($id,Request $request)
    {
        $data = new User;
        $name = $request->get('name');
        $role = $request->get('role');
        $sn = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if (empty($user)) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        elseif(!empty($name) && !empty($role)){
            $user->setName($name);
            $user->setRole($role);
            $sn->flush();
            return new View("User Updated Successfully", Response::HTTP_OK);
        }
        elseif(empty($name) && !empty($role)){
            $user->setRole($role);
            $sn->flush();
            return new View("role Updated Successfully", Response::HTTP_OK);
        }
        elseif(!empty($name) && empty($role)){
            $user->setName($name);
            $sn->flush();
            return new View("User Name Updated Successfully", Response::HTTP_OK);
        }
        else return new View("User name or role cannot be empty", Response::HTTP_NOT_ACCEPTABLE);
    }


    /**
     * @Rest\Delete("/user/{id}")
     */
    public function deleteAction($id)
    {
        $data = new User;
        $sn = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if (empty($user)) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $sn->remove($user);
            $sn->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }


    //williamduranway

    /**
    * Rest\View(statusCode=204)
    */
    public function removeAction(User $user)
    {
        $user->delete();
    }





}
