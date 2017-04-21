<?php

namespace DietaBundle\Tests\Controller;

use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

   /**
    * dieta_user_addfriends                    POST     ANY      ANY    /api/user/{id}/friend/{friendid}
    *
    */

   public function testAddFriend () {

       $client = new Client('http://localhost', array(
           'request.options' => array(
               'exceptions' => false,
           )
       ));

       $headers = $this->getAuthorizedHeaders();

       $request = $client->post('/app_dev.php/api/user/1/friend/2', $headers, array());
       $response = $request->send();
       $this->assertEquals(200, $response->getStatusCode());
       $this->assertTrue($response->hasHeader('Content-Type'));
       $this->assertEquals($response->getHeader('Content-Type'), 'application/json');
       $dataresponse = json_decode($response->getBody(true), true);

   }

    /**
     * dieta_user_addfriends                    Delete     ANY      ANY    /api/user/{id}/friend/{friendid}
     *
     */

    public function testDeleteFriend () {

        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));

        $headers = $this->getAuthorizedHeaders();

        $request = $client->delete('/app_dev.php/api/user/1/friend/2', $headers, array());
        $response = $request->send();
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');
        $dataresponse = json_decode($response->getBody(true), true);

    }





    protected function getAuthorizedHeaders($username = "carlos@gmail.com",$passsword = "test123" ,$headers = array())
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
