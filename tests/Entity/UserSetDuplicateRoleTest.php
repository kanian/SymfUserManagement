<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserSetDuplicateRoleTest extends WebTestCase
{
    protected function setup()
    {

        $this->user = new User;
        $this->roles = ['ROLE_USER', 'ROLE_ADMIN'];
        $this->user->setRoles($this->roles);
    }
    public function testSetRole()
    {
        $this->user->setRole('ROLE_ADMIN');
        $this->assertEquals($this->user->getRoles(), $this->roles);
    }
}
