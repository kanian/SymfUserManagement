<?php

// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Dotenv\Dotenv;

class PutGroupUserControllerTest extends WebTestCase
{
    protected function setup()
    {
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = array_key_exists('BASE_URI',$_ENV) ? $_ENV['BASE_URI'] : '';
        $client->request(
            'POST',
            $base_uri . '/groups',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name": "Test Group",
                "description": "A Group"
            }'
        );
        $response = $client->getResponse();
        $this->group = (json_decode($response->getContent()))->data;

        $client->request(
            'POST',
            $base_uri . '/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name": "Test User",
                "email": "testuser@gmail.com",
                "password": "test.123"
            }'
        );
        $response = $client->getResponse();
        $this->user = (json_decode($response->getContent()))->data;
    }
    protected function tearDown(){
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = array_key_exists('BASE_URI',$_ENV) ? $_ENV['BASE_URI'] : '';
        $client->request(
            'DELETE',
            $base_uri . '/groups/'.$this->group->id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $client->request(
            'DELETE',
            $base_uri . '/users/'.$this->user->id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
    }
    public function testAssignUserToGroup()
    {
        fwrite(STDERR, print_r($this->group, true));
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = array_key_exists('BASE_URI',$_ENV) ? $_ENV['BASE_URI'] : '';
        $client->request(
            'PUT',
            $base_uri . '/groups/' . $this->group->id . '/users/' . $this->user->id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
