<?php

namespace App\DomainService;

use App\DomainService\DomainService;
use App\DTO\UserDTO;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class UserDomainService extends DomainService
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, User::class);
    }

    public function create($data)
    {
        $user = new User();
        $user->setName($data->name);
        $user->setCreatedAt(new DateTime("now"));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return new UserDTO($user);
    }

    public function update(string $id, $data)
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            return null;
        }
        $user->setName($data->name);
        $user->setUpdatedAt(new DateTime("now"));
        $this->entityManager->flush();
        return new UserDTO($user);
    }

}
