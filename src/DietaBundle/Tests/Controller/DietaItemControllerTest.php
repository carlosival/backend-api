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

      $clasificacion = array_rand(array('desayuno','aperitivo','comida','merienda','cena'));
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
      $this->assertArrayHasKey('clasificacion', $dataresponse);

 }

/**
 * dieta_dietaitem_get                      GET      ANY      ANY    /dietaitem/{id}
 *
 */

 public function testGet(){


 }

 /**
  * dieta_dietaitem_edit                     PUT      ANY      ANY    /dietaitem/{id}
  *
  */

  public function testEdit(){



  }
 /**
  * dieta_dietaitem_all                      GET      ANY      ANY    /dietaitems
  *
  *
  */

  public function testAll(){




  }


    /**
     * dieta_dietaitem_addietaitem_receta       POST     ANY      ANY    /dietaitem/{dietaitemid}/receta/{recetaid}
     *
     */
      public function testAddReceta(){


      }

    /**
     * dieta_dietaitem_dietaitem_recetas        GET      ANY      ANY    /dietaitem/{id}/recetas
     *
     *
     */
     public function testGetRecetas(){



     }

    /**
     * dieta_dietaitem_dietaitem_receta         DELETE   ANY      ANY    /dietaitem/{dietaitemid}/receta/{recetaid}
     *
     */
     public function testDeleteReceta(){



     }

 /**
  * dieta_dietaitem_delete                   DELETE   ANY      ANY    /receta/{id}
  *
  */
   public function testDelete(){



   }










}
