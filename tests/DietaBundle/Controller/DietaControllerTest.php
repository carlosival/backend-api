<?php

namespace DietaBundle\Tests\Controller;

use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DietaControllerTest extends WebTestCase
{

  /**
   * dieta_dieta_new                          POST     ANY      ANY    /dieta
   *
   */
   /*public function testNew(){

       // create our http client (Guzzle)
       $client = new Client('http://localhost', array(
           'request.options' => array(
               'exceptions' => false,
           )
       ));

       // Build the resouce

       $nombre = 'Dieta'.rand(0,999);


       // Other properties that not going to be tested now
       $dieta_items = null;
       $usuarios_seguidores = null;
       $user = 1;


       $data = array(
           'nombre' => $nombre,
           'user' => $user
       );

       // Prepare and Send the Request

       $request = $client->post('/app_dev.php/dieta', null, json_encode($data));
       $response = $request->send();

       // Check the response

       $this->assertEquals(201, $response->getStatusCode());
       $this->assertTrue($response->hasHeader('Location'));
       $dataresponse = json_decode($response->getBody(true), true);
       $this->assertArrayHasKey('id', $dataresponse);
       $this->assertArrayHasKey('nombre', $dataresponse);


   }*/

    /**
     *dieta_dieta_all                          GET      ANY      ANY    /dietas
     *
     */

    /*public function testAll(){
        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));



        $request = $client->get('/app_dev.php/dietas', null, array());
        $response = $request->send();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

    }*/

  /**
   * dieta_dieta_get                          GET      ANY      ANY    /dieta/{id}
   *
   */
   /*public function testGet(){


       // create our http client (Guzzle)
       $client = new Client('http://localhost', array(
           'request.options' => array(
               'exceptions' => false,
           )
       ));



       $request = $client->get('/app_dev.php/dieta/1', null, array());
       $response = $request->send();

       $this->assertEquals(200, $response->getStatusCode());
       $this->assertTrue($response->hasHeader('Content-Type'));
       $this->assertEquals($response->getHeader('Content-Type'), 'application/json');
       $dataresponse = json_decode($response->getBody(true), true);
       $this->assertArrayHasKey('id', $dataresponse);
       $this->assertArrayHasKey('nombre', $dataresponse);
   }*/

  /**
   * dieta_dieta_edit                         PUT      ANY      ANY    /dieta/{id}
   *
   */
   /*public function testEdit(){

       // create our http client (Guzzle)
       $client = new Client('http://localhost', array(
           'request.options' => array(
               'exceptions' => false,
           )
       ));

       // Build the resouce

       $nombre = 'Dieta'.rand(0,999);


       // Other properties that not going to be tested now
       $dieta_items = null;
       $usuarios_seguidores = null;
       $user = 1;


       $data = array(
           'nombre' => $nombre

       );

       // Prepare and Send the Request

       $request = $client->put('/app_dev.php/dieta/1', null, json_encode($data));
       $response = $request->send();

       // Check the response

       $this->assertEquals(200, $response->getStatusCode());
      // $this->assertTrue($response->hasHeader('Location'));
       $dataresponse = json_decode($response->getBody(true), true);
       $this->assertArrayHasKey('id', $dataresponse);
       $this->assertArrayHasKey('nombre', $dataresponse);
       $this->assertEquals($nombre,$dataresponse['nombre']);

   }*/


    /**
     * dieta_dieta_addusuario_seguidor          POST     ANY      ANY    /dieta/{dietaid}/user/{userid}
     *
     */
    /*public function testAddSeguidor () {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));


        $request = $client->post('/app_dev.php/dieta/1/user/1', null, array());
        $response = $request->send();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');
    }*/

   /**
    * dieta_dieta_usuarios_seguidores          GET      ANY      ANY    /dieta/{id}/seguidores
    *
    */
    /*public function testGetSeguidores () {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));


        $request = $client->get('/app_dev.php/dieta/1/seguidores', null, array());
        $response = $request->send();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');
    }*/

    /**
    * dieta_dieta_usuario_seguidor             DELETE   ANY      ANY    /dieta/{dietaid}/user/{userid}
    *
    */
    /*public function testDeleteSeguidor () {

       // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));



        $request = $client->delete('/app_dev.php/dieta/1/user/1', null, array());
        $response = $request->send();

        $this->assertEquals(204, $response->getStatusCode());
//        $this->assertTrue($response->hasHeader('Content-Type'));
//        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

    }*/


    /**
     * dieta_dieta_addieta_dietaitem            POST     ANY      ANY    /dieta/{dietaid}/dietaitem/{dietaitemid}
     *
     */
    /*public function testAddDietaitems () {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));



        $request = $client->post('/app_dev.php/dieta/1/dietaitem/2', null, array());
        $response = $request->send();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');
    }*/


   /**
    * dieta_dieta_dieta_dietaitemss            GET      ANY      ANY    /dieta/{id}/dietaitems
    *
    */
    /*public function testGetDietaitems () {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));


        $request = $client->get('/app_dev.php/dieta/1/dietaitems', null, array());
        $response = $request->send();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');
    }*/
   /**
    * dieta_dieta_dieta_dietaitem              DELETE   ANY      ANY    /dieta/{dietaid}/dietaitem/{dietaitemid}
    *
    */
    /*public function testDeleteDietaitems () {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));


        $request = $client->delete('/app_dev.php/dieta/1/dietaitem/2', null, array());
        $response = $request->send();

        $this->assertEquals(204, $response->getStatusCode());
//        $this->assertTrue($response->hasHeader('Content-Type'));
//        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');
    }*/




   /**
    * dieta_dieta_owner                        GET      ANY      ANY    /dieta/{id}/owner
    *
    */

    /*public function testGetOwner () {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));



        $request = $client->get('/app_dev.php/dieta/1/owner', null, array());
        $response = $request->send();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');
        $dataresponse = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('id', $dataresponse);
        $this->assertArrayHasKey('username', $dataresponse);


    }*/



    /**
     * dieta_dieta_delete                       DELETE   ANY      ANY    /dieta/{id}
     *
     */
    public function testDelete () {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));



        $request = $client->delete('/app_dev.php/dieta/2', null, array());
        $response = $request->send();

        $this->assertEquals(204, $response->getStatusCode());
//        $this->assertTrue($response->hasHeader('Content-Type'));
//        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

    }

    protected function getAuthorizedHeaders($username = "carlosmartinezival@gmail.com",$passsword = "test123" ,$headers = array())
    {
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));

        // Prepare and Send the Request
        //Send a request to get the token.
        // Build the resouce to get the Token
        // $username = 'carlosmartinezival@gmail.com';
        // $passsword = 'test123';
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
        $headers['Authorization'] = 'Bearer '.$token;

        return $headers;
    }

}
