<?php

namespace DietaBundle\Tests\Controller;

use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTestController extends WebTestCase
{

    /**
     *
     * dieta_registration_register              POST     ANY      ANY    /register
     *
     */

    public function testRegistration ()
    {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));

        // Build the resouce

        $username = 'carlosmartinezival@gmail.com';
        $email = 'carlosmartinezival@gmail.com';
        $plainPassword = ['first' => 'test123', 'second' => 'test123'];


        $data = array(
            'username' => $username,
            'email' => $email,
            'plainPassword' => $plainPassword
        );

        // Prepare and Send the Request

        $request = $client->post('/app_dev.php/register', null, json_encode($data));
        $response = $request->send();

        // Check the response

        $this->assertEquals(201, $response->getStatusCode());
//        $this->assertTrue($response->hasHeader('Location'));
//        $dataresponse = json_decode($response->getBody(true), true);
//        $this->assertArrayHasKey('id', $dataresponse);
//        $this->assertArrayHasKey('nombre', $dataresponse);


    }

    public function testRegsiterNewUserWithInvalidEmail()
    {

        // create our http client (Guzzle)
        $client = new Client('http://localhost', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));

        // Build the resouce

        $username = 'matko';
        $email = 'matkasgasgashgamail.com';
        $plainPassword = [
            'first' => 'test123', 'second' => 'test123'
        ];


        $data = array(
            'username' => $username,
            'email' => $email,
            'plainPassword' => $plainPassword
        );

        // Prepare and Send the Request

        $request = $client->post('/app_dev.php/register', null, json_encode($data));
        $response = $request->send();

        // Check the response

        $this->assertEquals(400, $response->getStatusCode());


    }



}
