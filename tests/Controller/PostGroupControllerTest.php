<?php

// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostGroupControllerTest extends WebTestCase
{
    public function testCreate()
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
                "name": "A Group",
                "description": "A Description"
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}
