<?php

namespace DietaBundle\Tests\Controller;

#use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Bazinga\Bundle\RestExtraBundle\Test\WebTestCase as WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertContains('Hello World', $client->getResponse()->getContent());

    }
}
