<?php

namespace App\DTO;

use Closure;

class DTO
{
    protected $className;

    public function mapToDTO($entity = null)
    {
        if (!$entity) {
            return null;
        }
        $dto = new $this->className($entity);
        $dto->entity = $entity;
        return $dto;
    }

    public function mapArrayToDTOArray(array $entities)
    {
        $mapper = Closure::bind(function ($entity){return $this->mapToDTO($entity);}, $this);
        return array_map($mapper, $entities);
    }

    public function getEntity()
    {
        return $this->entity;
    }

}
