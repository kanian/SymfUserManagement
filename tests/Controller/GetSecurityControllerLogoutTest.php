<?php

// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetSecurityControllerLogoutTest extends WebTestCase
{
    protected function setup()
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
                "name": "Test User",
                "email": "ausertosimplytestregistration@gmail.com",
                "password": "test.123"
            }'
        );
        $response = $client->getResponse();
        $this->user = (json_decode($response->getContent()))->data;
        $this->user->password = "test.123";

        $client->request(
            'POST', 
            $base_uri . '/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
              "username": "ausertosimplytestregistration@gmail.com",
              "password": "'.$this->user->password.'"}'
        );
    }
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
    public function testLogin()
    {
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = $_ENV['BASE_URI'];
        $client->request(
            'GET', 
            $base_uri . '/logout',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
