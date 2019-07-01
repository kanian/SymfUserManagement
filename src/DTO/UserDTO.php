<?php

namespace App\DTO;

use App\Entity\User;

/**
 * UserDTO Class; encapsulates User to UserDTO mappings
 */
class UserDTO
{

    use DTO;
    public $name;
    public $createdAt;
    public $updatedAt;
    public static $className = 'App\DTO\UserDTO';

    /**
     * UserDTO constructor
     *
     * @param User $user
     */
    public function __construct(User $user = null)
    {

        if ($user) {
            $this->name = $user->getName();
            $this->createdAt = $user->getCreatedAt();
            $this->updatedAt = $user->getUpdatedAt();
            $this->id = $user->getId();
            $this->ussername = $user->getUsername();
            $this->roles = $user->getRoles();
        }

    }
}
