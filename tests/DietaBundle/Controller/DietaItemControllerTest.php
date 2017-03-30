<?php

namespace DietaBundle\Tests\Controller;

use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DietaItemControllerTest extends WebTestCase
{




/**
 * dieta_dietaitem_new                      POST     ANY      ANY    /dietaitem
 *
 */

  public function testNew (){

      // create our http client (Guzzle)
      $client = new Client('http://localhost', array(
          'request.options' => array(
              'exceptions' => false,
          )
      ));

      // Build the resouce

      $clasificacion = array_rand(array('desayuno'=>'desayuno','aperitivo'=>'aperitivo','comida'=>'comida','merienda'=>'merienda','cena'=>'cena'));
      // No se va a probar ahora las rutinas nacen sin recetas.
      $recetas = null;


      // Other properties that not going to be test now



      $data = array(
          'clasificacion' => $clasificacion

      );

      // Prepare and Send the Request

      $request = $client->post('/app_dev.php/dietaitem', null, json_encode($data));
      $response = $request->send();

      // Check the response

      $this->assertEquals(201, $response->getStatusCode());
      $this->assertTrue($response->hasHeader('Location'));
      $dataresponse = json_decode($response->getBody(true), true);
      $this->assertArrayHasKey('id', $dataresponse);
      $this->assertArrayHasKey('clasificacion', $dataresponse);


 }

/**
 * dieta_dietaitem_get                      GET      ANY      ANY    /dietaitem/{id}
 *
 */

 public function testGet(){

     // create our http client (Guzzle)
     $client = new Client('http://localhost', array(
         'request.options' => array(
             'exceptions' => false,
         )
     ));



     $request = $client->get('/app_dev.php/dietaitem/13', null, array());
     $response = $request->send();

     $this->assertEquals(200, $response->getStatusCode());
     $this->assertTrue($response->hasHeader('Content-Type'));
     $this->assertEquals($response->getHeader('Content-Type'), 'application/json');
//     $dataresponse = json_decode($response->getBody(true), true);
//     $this->assertArrayHasKey('id', $dataresponse);
//     $this->assertEquals(13,$dataresponse['id']);
 }

 /**
  * dieta_dietaitem_edit                     PUT      ANY      ANY    /dietaitem/{id}
  *
  */

  public function testEdit(){


      // create our http client (Guzzle)
      $client = new Client('http://localhost', array(
          'request.options' => array(
              'exceptions' => false,
          )
      ));

      // Build the resouce

      $clasificacion = 'editdata';
      // No se va a probar ahora las rutinas nacen sin recetas.
      $recetas = null;


      // Other properties that not going to be test now



      $data = array(
          'clasificacion' => $clasificacion

      );

      // Prepare and Send the Request

      $request = $client->put('/app_dev.php/dietaitem/13', null, json_encode($data));
      $response = $request->send();

      // Check the response

      $this->assertEquals(200, $response->getStatusCode());
    //  $this->assertTrue($response->hasHeader('Location'));
      $dataresponse = json_decode($response->getBody(true), true);
      $this->assertArrayHasKey('id', $dataresponse);
      $this->assertArrayHasKey('clasificacion', $dataresponse);
       $this->assertEquals($clasificacion,$dataresponse['clasificacion']);


  }
 /**
  * dieta_dietaitem_all                      GET      ANY      ANY    /dietaitems
  *
  *
  */

  public function testAll(){

      // create our http client (Guzzle)
      $client = new Client('http://localhost', array(
          'request.options' => array(
              'exceptions' => false,
          )
      ));


      $request = $client->get('/app_dev.php/dietaitems', null, array());
      $response = $request->send();

      $this->assertEquals(200, $response->getStatusCode());
      $this->assertTrue($response->hasHeader('Content-Type'));
      $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

  }


    /**
     * dieta_dietaitem_addietaitem_receta       POST     ANY      ANY    /dietaitem/{dietaitemid}/receta/{recetaid}
     *
     */
      /*public function testAddReceta(){

          // create our http client (Guzzle)
          $client = new Client('http://localhost', array(
              'request.options' => array(
                  'exceptions' => false,
              )
          ));


          $request = $client->post('/app_dev.php/dietaitem/1/receta/1', null, array());
          $response = $request->send();

          $this->assertEquals(200, $response->getStatusCode());
          $this->assertTrue($response->hasHeader('Content-Type'));
          $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

      }*/

    /**
     * dieta_dietaitem_dietaitem_recetas        GET      ANY      ANY    /dietaitem/{id}/recetas
     *
     *
     */
     public function testGetRecetas(){

         // create our http client (Guzzle)
         $client = new Client('http://localhost', array(
             'request.options' => array(
                 'exceptions' => false,
             )
         ));


         $request = $client->get('/app_dev.php/dietaitem/1/recetas', null, array());
         $response = $request->send();

         $this->assertEquals(200, $response->getStatusCode());
         $this->assertTrue($response->hasHeader('Content-Type'));
         $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

     }

    /**
     * dieta_dietaitem_dietaitem_receta         DELETE   ANY      ANY    /dietaitem/{dietaitemid}/receta/{recetaid}
     *
     */
     public function testDeleteReceta(){

         // create our http client (Guzzle)
         $client = new Client('http://localhost', array(
             'request.options' => array(
                 'exceptions' => false,
             )
         ));


         $request = $client->delete('/app_dev.php/dietaitem/1/receta/1', null, array());
         $response = $request->send();

         $this->assertEquals(204, $response->getStatusCode());
         $this->assertTrue($response->hasHeader('Content-Type'));
         $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

     }

 /**
  * dieta_dietaitem_delete                   DELETE   ANY      ANY    /dietaitem/{id}
  *
  */
   /*public function testDelete(){

       // create our http client (Guzzle)
       $client = new Client('http://localhost', array(
           'request.options' => array(
               'exceptions' => false,
           )
       ));


       $request = $client->delete('/app_dev.php/dietaitem/1', null, array());
       $response = $request->send();

       $this->assertEquals(204, $response->getStatusCode());
//       $this->assertTrue($response->hasHeader('Content-Type'));
//       $this->assertEquals($response->getHeader('Content-Type'), 'application/json');

   }*/



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
