<?php

namespace Tests\DietaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
#use Bazinga\Bundle\RestExtraBundle\Test\WebTestCase as WebTestCase;
use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RecetaControllerTest extends WebTestCase
{



    /*public function testAll () {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));


        $request = $client->get('/app_dev.php/recetas', null, array());
        $response = $request->send();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

    }

        public function testGet () {

            // create our http client (Guzzle)
            $client = new Client('http://localhost', array(
                'request.options' => array(
                    'exceptions' => false,
                )
            ));



            $request = $client->get('/app_dev.php/receta/1', null, array());
            $response = $request->send();

            $this->assertEquals(200, $response->getStatusCode());
            $this->assertTrue($response->hasHeader('Content-Type'));
            $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

        }*/

   public function testNew () {

       // create our http client (Guzzle)
       $client = new Client('http://localhost', array(
           'request.options' => array(
               'exceptions' => false,
           )
       ));

        // Build the resouce

       $nombre = 'RecetaPrueba'.rand(0, 999);
       $tiempo_preparacion = rand(0, 100).'min';
       $ingredientes = ['Ingrediente kg','Ingrediente 2 soup','Ingrediente 3','Ingrediente 4','Ingrediente 5'];
       $preparacion = ['Operacion 1','Operacion 2','Operacion 3','Operacion 4','Operacion 5'];
       $raciones = rand(0,50);

       // Other properties that not going to be test now

       $user = 1;
      // $imageFile = new UploadedFile();
       $usuario_seguidores = null;
       $username = 'carlosmartinezival@gmail.com';

       $data = array(
           'nombre' => $nombre,
           'tiempo_preparacion' => $tiempo_preparacion,
           'ingredientes' => $ingredientes,
           'preparacion' => $preparacion,
           'raciones' => $raciones

       );

        // Prepare and Send the Request

       //Send a request to get the token.
       // Build the resouce to get the Token

       $username = 'carlosmartinezival@gmail.com';
       $passsword = 'test123';
       //  $plainPassword = ['first' => 'test123', 'second' => 'test123'];


       $credenciales = array(
           'username' => $username,
           'password' => $passsword
           // 'plainPassword' => $plainPassword
       );


       // Prepare and Send the Request

       $request = $client->post('/app_dev.php/login', null, json_encode($credenciales));
       $response = $request->send();

       $dataresponse = json_decode($response->getBody(true), true);
       $this->assertArrayHasKey('token', $dataresponse);

       $token = $dataresponse['token'];
       $headers = array();
       $headers['Authorization'] = 'Bearer '.$token;


       $request = $client->post('/app_dev.php/receta', $headers, json_encode($data));
       $response = $request->send();

       // Check the response

       $this->assertEquals(201, $response->getStatusCode());
       $this->assertTrue($response->hasHeader('Location'));
       $dataresponse = json_decode($response->getBody(true), true);
       $this->assertArrayHasKey('nombre', $dataresponse);

    }

   /*public function testEdit(){


       // create our http client (Guzzle)
       $client = new Client('http://localhost', array(
           'request.options' => array(
               'exceptions' => false,
           )
       ));

       // Build the resouce

       $nombre = 'RecetaPruebaEditada'.rand(0, 999);
       $tiempo_preparacion = rand(0, 100).'min';
       $ingredientes = ['Ingredientedit kg','Ingredienteedit 2 soup','Ingrediente 3'];
       $preparacion = ['Operacionedit 1','Operacionedit 2','Operacion 3','Operacion 4'];
       $raciones = rand(1,20);

       // Other properties that not going to be test now

       $userid = 1;
       // $imageFile = new UploadedFile();
       $usuario_seguidores = null;

       $data = array(
           'nombre' => $nombre,
           'tiempo_preparacion' => $tiempo_preparacion,
           'ingredientes' => $ingredientes,
           'preparacion' => $preparacion,
           'raciones' => $raciones,
           'userid' => $userid
       );

       // Prepare and Send the Request

       $request = $client->put('/app_dev.php/receta/1', null, json_encode($data));
       $response = $request->send();

       // Check the response

       $this->assertEquals(200, $response->getStatusCode());
       //$this->assertTrue($response->hasHeader('Location'));
       $dataresponse = json_decode($response->getBody(true), true);
       $this->assertArrayHasKey('nombre', $dataresponse);

   }*/


    /*public function testaddusuario_seguidor () {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));


        $request = $client->post('/app_dev.php/receta/1/user/1', null, array());
        $response = $request->send();

        // Extender y probar tambien la base de datos.

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

        $dataresponse = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('nombre', $dataresponse);

    }*/


   /* public function tetsGetusuarios_seguidores (){

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));


        $request = $client->get('/app_dev.php/receta/1/seguidores', null, array());
        $response = $request->send();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

        $dataresponse = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('usuarios_seguidores', $dataresponse);


    }*/

   /* public function testDeleteusuario_seguidor() {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));


        $request = $client->delete('/app_dev.php/receta/1/user/1', null, array());
        $response = $request->send();

        // Extender y probar tambien la base de datos.

        $this->assertEquals(204, $response->getStatusCode());
//        $this->assertEquals(0,$response->getBody()->getContentLength());
//        $this->assertTrue($response->hasHeader('Content-Type'));
//        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');
//
//        $dataresponse = json_decode($response->getBody(true), true);
//        $this->assertArrayHasKey('nombre', $dataresponse);

    }*/



    /*public function testGetowner () {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));


        $request = $client->get('/app_dev.php/receta/2/owner', null, array());
        $response = $request->send();


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

        $dataresponse = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('email', $dataresponse);

    }*/

    /*public function testRequiresAuthentication()
    {
        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));

        $request = $client->post('/app_dev.php/receta', ['body' => '[]'],array());
        $response = $request->send();
        $this->assertEquals(401, $response->getStatusCode());
    }*/

    protected function getAuthorizedHeaders($username, $headers = array())
    {
        $lex = $this->client->getContainer()->get('lexik_jwt_authentication.encoder');
        $token = $lex->encode(['username' => $username]);
        $headers['Authorization'] = 'Bearer '.$token;
        return $headers;
    }
}
