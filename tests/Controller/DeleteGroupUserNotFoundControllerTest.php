<?php

// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeleteGroupUserNotFoundControllerTest extends WebTestCase
{
    public function testRemoveUserFromGroupNotFound()
    {
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = $_ENV['BASE_URI'];
        $client->request(
            'DELETE', 
            $base_uri . '/groups/-1/users/-1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
