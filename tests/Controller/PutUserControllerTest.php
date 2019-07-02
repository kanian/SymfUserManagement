<?php

// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PutUserControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = $_ENV['BASE_URI'];
        $client->request(
            'PUT', 
            $base_uri . '/users/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name": "Belier Toujours 4",
            }'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
