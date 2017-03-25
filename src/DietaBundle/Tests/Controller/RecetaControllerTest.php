<?php

namespace DietaBundle\Tests\Controller;

#use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Bazinga\Bundle\RestExtraBundle\Test\WebTestCase as WebTestCase;
use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RecetaControllerTest extends \PHPUnit_Framework_TestCase
{

public function testAll () {

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

    }

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

       $data = array(
           'nombre' => $nombre,
           'tiempo_preparacion' => $tiempo_preparacion,
           'ingredientes' => $ingredientes,
           'preparacion' => $preparacion,
           'raciones' => $raciones,
           'user' => $user
       );

        // Prepare and Send the Request

       $request = $client->post('/app_dev.php/receta', null, json_encode($data));
       $response = $request->send();

       // Check the response

       $this->assertEquals(201, $response->getStatusCode());
       $this->assertTrue($response->hasHeader('Location'));
       $dataresponse = json_decode($response->getBody(true), true);
       $this->assertArrayHasKey('nombre', $dataresponse);

    }

   public function testEdit(){


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

   }


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


    public function tetsGetusuarios_seguidores (){

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


    }

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




    public function testGetowner () {

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

    }



}
