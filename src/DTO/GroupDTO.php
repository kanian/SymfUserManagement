<?php

namespace App\DTO;

use App\DTO\UserDTO;
use App\Entity\Group;

/**
 * GroupDTO Class; encapsulates Group to GroupDTO mappings
 */
class GroupDTO extends DTO
{

    public $name;
    public $createdAt;
    public $updatedAt;
    public $id;
    public $users;

    /**
     * GroupDTO constructor
     *
     * @param Group $group
     */
    public function __construct(Group $group = null)
    {
        $this->className = 'App\DTO\GroupDTO';
        if ($group) {
            $this->name = $group->getName();
            $this->createdAt = $group->getCreatedAt();
            $this->updatedAt = $group->getUpdatedAt();
            $this->id = $group->getId();
            $userDTOMapper = new UserDTO;
            $this->users = $userDTOMapper->mapArrayToDTOArray( $group->getUsers());;
        }
    }
}
