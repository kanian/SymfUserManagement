<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_group")
 * @ORM\Entity(repositoryClass="App\Repository\UserGroupRepository")
 */
class UserGroup
{


    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, name="user_id")
     * 
     */
    private $user;

    /**
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="App\Entity\Group", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, name="group_id")
     */
    private $_group;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getGroup(): ?Group
    {
        return $this->_group;
    }

    public function setGroup(Group $_group): self
    {
        $this->_group = $_group;

        return $this;
    }
}
