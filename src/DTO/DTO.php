<?php

namespace App\DTO;

trait DTO
{
    public static function mapToDTO($entity = null)
    {
        if (!$entity) {
            return null;
        }
        $dto = new self::$className($entity);
        $dto->entity = $entity;
        return $dto;
    }

    public static function mapArrayToDTOArray(array $entities)
    {
        return array_map(function ($entity) {return self::mapToDTO($entity);}, $entities);
    }

    public function getEntity(){
        return $this->entity;
    }

}
