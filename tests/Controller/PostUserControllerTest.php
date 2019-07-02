<?php

// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostUserControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = $_ENV['BASE_URI'];
        $client->request(
            'POST', 
            $base_uri . '/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name": "Belier",
                "email": "belier@gmail.com",
                "password": "test.123"
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}
