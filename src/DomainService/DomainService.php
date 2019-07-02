<?php

namespace App\DomainService;

use Doctrine\ORM\EntityManagerInterface;

class DomainService
{
    protected $entityClassName;

    public const INVALID_ACTION = 0;
    public const ACTION_SUCCEEDED = 1;
    public const ACTION_FAILED = 2;
    public const DOMAIN_OBJECT_NOT_FOUND = 3;


    public function __construct(EntityManagerInterface $entityManager, string $entityClassName)
    {
        $this->entityClassName = $entityClassName;
        $this->dtoClassName = "App\DTO\\" . $this->getShortName($this->entityClassName) . "DTO";
        $this->entityManager = $entityManager;
    }


    function list() {
        $entities = $this->entityManager->getRepository($this->entityClassName)->findAll();
        $dtoMapper = new $this->dtoClassName;
        $dtos = $dtoMapper->mapArrayToDTOArray($entities);
        return $dtos;
    }

    public function retrieve(string $id)
    {
        $entity = $this->entityManager->getRepository($this->entityClassName)->find($id);
        $dtoMapper = new $this->dtoClassName;
        return $dtoMapper->mapToDTO($entity);
    }


    public function delete(string $id)
    {
        $entity = $this->entityManager->getRepository($this->entityClassName)->find($id);
        if (!$entity) {
            return DomainService::DOMAIN_OBJECT_NOT_FOUND;
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
        return DomainService::ACTION_SUCCEEDED;
    }

    private function getShortName(string $entityClassName)
    {
        $path = explode('\\', $entityClassName);
        return array_pop($path);
    }

}
