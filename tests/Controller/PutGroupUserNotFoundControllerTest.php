<?php

// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PutGroupUserNotFoundControllerTest extends WebTestCase
{
    
    public function testCreate()
    {
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = $_ENV['BASE_URI'];
        $client->request(
            'PUT', 
            $base_uri . '/groups/-1/users/-1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
