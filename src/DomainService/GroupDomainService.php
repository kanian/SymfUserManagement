<?php

namespace App\DomainService;

use App\DomainService\DomainService;
use App\DomainService\UserDomainService;
use App\DTO\GroupDTO;
use App\Entity\Group;
use App\Entity\User;
use App\Entity\UserGroup;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class GroupDomainService extends DomainService
{
    public const GROUP_NOT_EMPTY = 0;
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Group::class);
        $this->userGroupRepository = $this->entityManager->getRepository(UserGroup::class);
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

    public function delete(string $id)
    {
        $count = (int) $this->userGroupRepository->findCount($id);
        if ($count !== 0) {
            return self::GROUP_NOT_EMPTY;
        }
        $entity = $this->entityManager->getRepository($this->entityClassName)->find($id);
        if (!$entity) {
            return DomainService::DOMAIN_OBJECT_NOT_FOUND;
        }
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
        return DomainService::ACTION_SUCCEEDED;
    }

    public function assignUserToGroup(string $groupId, string $userId, UserDomainService $userDomainService)
    {
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        $group = $this->entityManager->getRepository(Group::class)->find($groupId);

        if ($this->isUserInGroup($user, $group)) {
            return self::ACTION_SUCCEEDED;
        }

        if (!$group || !$user) {
            return self::DOMAIN_OBJECT_NOT_FOUND;
        }

        $userGroup = new UserGroup();
        $userGroup->setUser($user);
        $userGroup->setGroup($group);
        $this->entityManager->persist($userGroup);
        $this->entityManager->flush();
        return self::ACTION_SUCCEEDED;
    }

    private function isUserInGroup($user, $group)
    {

        $found = $this->userGroupRepository->findOneBy(['user' => $user, '_group' => $group]);
        return !empty($found);
    }

    public function removeUserFromGroup(string $groupId, string $userId, UserDomainService $userDomainService)
    {
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        $group = $this->entityManager->getRepository(Group::class)->find($groupId);

        if (!$group || !$user) {
            return self::DOMAIN_OBJECT_NOT_FOUND;
        }
        $found = $this->userGroupRepository->findOneBy(['user' => $user, '_group' => $group]);
        if (!$found) {
            return self::ACTION_SUCCEEDED;
        }
        $this->entityManager->remove($found);
        $this->entityManager->flush();
        return self::ACTION_SUCCEEDED;

    }
}
