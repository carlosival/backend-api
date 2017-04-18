<?php

namespace DietaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\Form\FormInterface;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class LoginController extends Controller
{
    /**
     *
     *  This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Autorizacion y Autenticacion",
     *  resource=true,
     *  description="Metodo de Login Retorna una Token de seguridad desde de proporcion las credenciales de acceso ",
     *  *  statusCodes={
     *         200="Cuando las credenciales son correctas"
     *  },
     *  requirements={
     *      {
     *          "name"="username",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="Nombre de usuario"
     *      },
     *      {
     *          "name"="password",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="Password"
     *      }
     *
     * },
     * )
     *
     *
     *
     *
     *
     * @Rest\Post("/login")
     * @Rest\View()
     */
    public function loginAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if(isset($data['username']) && isset($data['password'])){
        $userName = $data['username'];
        $password = $data['password'];
        }else {
                    return new BadCredentialsException();

        }
        $user = $this->getDoctrine()
            ->getRepository('DietaBundle:User')
            ->findOneBy(['username' => $userName]);

        if (!$user) {
            throw $this->createNotFoundException();
        }

        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $password);

        if (!$isValid) {
            throw new BadCredentialsException();
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode([
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'confirmationtoken' => $user->getConfirmationToken(),
                'lastlogin' => $user->getLastLogin(),
                'username' => $user->getUsername(),
                'foto' => $user->getImageAvatar(),
                'exp' => time() + 86400 // 24 hours expiration
            ]);


        $response = $this->createApiResponse(['token' => $token],200);
        return $response;
    }


    /**
     * @param  Request $request
     * @param  FormInterface $form
     */
    private function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            throw new BadRequestHttpException();
        }

        $form->submit($data);
    }



    /**
     * Set base HTTP headers.
     *
     * @param Response $response
     *
     * @return Response
     */
    private function setBaseHeaders(Response $response)
    {
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

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
