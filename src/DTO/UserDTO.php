<?php

namespace App\DTO;

use App\Entity\User;

/**
 * UserDTO Class; encapsulates User to UserDTO mappings
 */
class UserDTO extends DTO
{

    public $name;
    public $createdAt;
    public $updatedAt;
    public $username;
    public $email;
    public $id;
    public $roles;

    /**
     * UserDTO constructor
     *
     * @param User $user
     */
    public function __construct(User $user = null)
    {
        $this->className = 'App\DTO\UserDTO';
        if ($user) {
            $this->name = $user->getName();
            $this->createdAt = $user->getCreatedAt();
            $this->updatedAt = $user->getUpdatedAt();
            $this->id = $user->getId();
            $this->username = $user->getUsername();
            $this->email = $user->getEmail();
            $this->roles = $user->getRoles();
        }
    }
}
