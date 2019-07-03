<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRemoveRoleTest extends WebTestCase
{
    protected function setup()
    {
        $this->user = new User;
        $this->roles = ['ROLE_USER', 'ROLE_ADMIN'];
        $this->user->setRoles($this->roles);
    }
    public function testRemoveRole()
    {
        $this->user->removeRole('ROLE_ADMIN');
        $this->assertEquals($this->user->getRoles(), ['ROLE_USER']);
    }
}
