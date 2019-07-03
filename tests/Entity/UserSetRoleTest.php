<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class userSetRoleTest extends WebTestCase
{
    protected function setup()
    {

        $this->user = new User;
        $this->roles = ['ROLE_USER', 'ROLE_ADMIN'];
        $this->user->setRoles($this->roles);
        // $this->user =  '{
        //   "name": "A Bogus User",
        //   "username": "bogususer@gmail.com",
        //   "roles": [
        //       "ROLE_USER"
        //   ]';
        // $mockEntityManager = $this->createMock(EntityManagerInterface::class);
        // $mockRepository = $this->createMaock(UserRepository::class);
        // $mockRepository->find(13)->willReturn($this->user);
        // $mockEntityManager->getRepository(User::class)->willReturn($mockRepository);
        //$this->userDomainService = new UserDomainService($mockEntityManager);

    }
    public function testSetRole()
    {
        $this->assertEquals($this->user->getRoles(), $this->roles);
    }
}
