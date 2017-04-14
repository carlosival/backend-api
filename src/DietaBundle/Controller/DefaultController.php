<?php

namespace DietaBundle\Controller;

use DietaBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\View\View;

class DefaultController extends Controller
{
    /**
     * Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('DietaBundle:Default:index.html.twig');
    }

    /**
     * @Rest\Get("/timeline/{id}/{timespan}")
     * @Rest\View()
     */
    public function timelineAction(Request $request, $id , $timespan)
    {

        $allrecetas =array();
        $fecha = $this->createDateTimefromstring($timespan);

        if($fecha ===null){

            throw new BadRequestHttpException("Invalid Date Format: The support format is 'Y-m-d H:i:s' ");
        }

        $sn = $this->getDoctrine()->getManager();
        $user = $sn ->getRepository('DietaBundle:User')->find($id);

        if ($user === null) {
            throw new NotFoundHttpException('User not found');
        }

        $recetas = $sn->getRepository('DietaBundle:Receta')->findRecentRecipesOrderedByDate($user, $fecha);

        $allrecetas[] = $recetas;


       /* if ($recetas === null) {
            throw new NotFoundHttpException('Receta not found');
        }*/


        foreach ( $user->getMyFriends() as $amigo  ){

            $recetasamigos = $sn->getRepository('DietaBundle:Receta')->findRecentRecipesOrderedByDate($amigo, $fecha);
            $allrecetas[] = $recetasamigos;
        }


        $response =$this->createApiResponse($allrecetas,200);
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


    function createDateTimefromstring($dateStr, $format = 'Y-m-d H:i:s')
    {
        date_default_timezone_set('UTC');
        $date = \DateTime::createFromFormat($format, $dateStr);
        return $date ? $date : null;
    }

}
