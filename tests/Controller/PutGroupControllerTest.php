<?php

// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PutGroupControllerTest extends WebTestCase
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
    }

    public function testUpdate()
    {
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = array_key_exists('BASE_URI',$_ENV) ? $_ENV['BASE_URI'] : '';
        $client->request(
            'PUT', 
            $base_uri . '/groups/'.$this->group->id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "name": "A Group modified",
                "description": "A Description modified"
            }'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
