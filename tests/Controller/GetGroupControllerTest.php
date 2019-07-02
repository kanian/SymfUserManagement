<?php

// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetGroupControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.test');
        $base_uri = $_ENV['BASE_URI'];
        $client->request('GET', $base_uri . '/groups');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
