<?php

namespace App\DomainService;

use App\DomainService\DomainService;
use App\DTO\GroupDTO;
use App\Entity\Group;
use DateTime;
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

}
