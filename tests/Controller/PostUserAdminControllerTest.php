<?php

namespace App\Tests\Controller;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostUserAdminControllerTest extends WebTestCase
{
    protected function setup()
    {
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = array_key_exists('BASE_URI',$_ENV) ? $_ENV['BASE_URI'] : '';
       
        
        $client->request(
            'POST', 
            $base_uri . '/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
              "username": "admin@example.com",
              "password": "admin"}'
        );
    }
    protected function tearDown(){
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = array_key_exists('BASE_URI',$_ENV) ? $_ENV['BASE_URI'] : '';
        
        $client->request(
            'DELETE',
            $base_uri . '/users/'.$this->user2->id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
        $client->request(
            'GET', 
            $base_uri . '/logout',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
    }
    public function testCreate()
    {
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = array_key_exists('BASE_URI',$_ENV) ? $_ENV['BASE_URI'] : '';
        $client->request(
            'POST', 
            $base_uri . '/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name": "Belier 14",
                "email": "agoodemail@gmail.com",
                "password": "test.123"
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $response = $client->getResponse();
        $this->user2 = (json_decode($response->getContent()))->data;
    }
}
