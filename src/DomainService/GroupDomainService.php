<?php

namespace App\DomainService;

use DateTime;
use App\DTO\GroupDTO;
use App\Entity\Group;
use App\DomainService\DomainService;
use App\DomainService\UserDomainService;
use Doctrine\ORM\EntityManagerInterface;

class GroupDomainService extends DomainService
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Group::class);
    }

    public function create($data)
    {
        $group = new Group();
        $group->setName($data->name);
        $group->setDescription($data->description);
        $group->setCreatedAt(new DateTime("now"));
        $this->entityManager->persist($group);
        $this->entityManager->flush();
        return new GroupDTO($group);
    }

    public function update(string $id, $data)
    {
        $group = $this->entityManager->getRepository(Group::class)->find($id);
        if (!$group) {
            return null;
        }
        !empty($data->name) ? $group->setName($data->name) : null;
        $group->setUpdatedAt(new DateTime("now"));
        !empty($data->description) ? $group->setDescription($data->description) : null;
        $this->entityManager->flush();
        return new GroupDTO($group);
    }

    public function assignUserToGroup(string $groupId, string $userId, UserDomainService $userDomainService )
    {
        $user = $userDomainService->retrieve($userId);
        $group = $this->entityManager->getRepository(Group::class)->find($groupId);

        if (!$group || !$user) {
            return self::DOMAIN_OBJECT_NOT_FOUND;
        }

        if ($group->addUser($user->getEntity())) {
            $this->entityManager->flush();
            return self::ACTION_SUCCEEDED;
        }
        return self::ACTION_FAILED;
    }

    public function removeUserFromGroup(string $groupId, string $userId, UserDomainService $userDomainService)
    {
        $user = $userDomainService->retrieve($userId);
        $group = $this->entityManager->getRepository(Group::class)->find($groupId);

        if (!$group || !$user) {
            return self::DOMAIN_OBJECT_NOT_FOUND;
        }

        if ($group->removeUser($user->getEntity())) {
            $this->entityManager->flush();
            return self::ACTION_SUCCEEDED;
        }
        return self::ACTION_FAILED;
    }
}
