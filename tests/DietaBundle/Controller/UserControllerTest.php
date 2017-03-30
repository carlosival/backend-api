<?php

namespace DietaBundle\Tests\Controller;

use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{



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
