<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserAlwaysHasUserRoleTest extends WebTestCase
{
    protected function setup()
    {

        $this->user = new User;
        $this->roles = [];
        $this->user->setRoles($this->roles);
    }
    public function testSetRole()
    {
        $this->assertEquals($this->user->getRoles(), ['ROLE_USER']);
    }
}
