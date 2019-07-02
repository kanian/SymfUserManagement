<?php

// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostRegistrationControllerTest extends WebTestCase
{
    
    protected function tearDown(){
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = $_ENV['BASE_URI'];
       

        $client->request(
            'DELETE',
            $base_uri . '/users/'.$this->user->id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
    }
    public function testRegister()
    {
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = $_ENV['BASE_URI'];
        $client->request(
            'POST', 
            $base_uri . '/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
              "name": "A User To Simply Test Registration",
              "email": "ausertosimplytestregistration@gmail.com",
              "password": "test.123"
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $response = $client->getResponse();
        $this->user = (json_decode($response->getContent()))->data;
    }
}
