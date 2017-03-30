<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28/03/17
 * Time: 13:15
 */

namespace DietaBundle\Tests\Controller;

use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{



    /**
     *
     * dieta_login_login                        POST     ANY      ANY    /login
     *
     */
    public function testLogin(){

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));

        // Build the resouce

        $username = 'carlosmartinezival@gmail.com';
        $passsword = 'test123';
      //  $plainPassword = ['first' => 'test123', 'second' => 'test123'];


        $data = array(
            'username' => $username,
            'password' => $passsword
           // 'plainPassword' => $plainPassword
        );




        // Prepare and Send the Request

        $request = $client->post('/app_dev.php/login', null, json_encode($data));
        $response = $request->send();

        // Check the response

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $this->assertEquals($response->getHeader('Content-Type'), 'application/json');
        $dataresponse = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('token', $dataresponse);

    }

    /*public function testloginInvalidCredentials()
    {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));

        // Build the resouce

        $username = 'carlosmartinezival@gmail.com';
        $passsword = 'test12345';
        //  $plainPassword = ['first' => 'test123', 'second' => 'test123'];


        $data = array(
            'username' => $username,
            'password' => $passsword
            // 'plainPassword' => $plainPassword
        );


        // Prepare and Send the Request

        $request = $client->post('/app_dev.php/login', null, json_encode($data));
        $response = $request->send();

        // Check the response


        $this->assertEquals(401, $response->getStatusCode());
    }*/

    /*protected function getAuthorizedHeaders($username, $headers = array())
    {
        $token = $this->lex->encode(['username' => $username]);
        $headers['Authorization'] = 'Bearer '.$token;
        return $headers;
    }*/

}