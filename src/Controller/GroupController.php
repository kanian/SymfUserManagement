<?php

namespace App\Controller;

use App\DomainService\GroupDomainService;
use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->domainService = new GroupDomainService($entityManager);
    }

    /**
     * @Route("/groups", methods={"GET"})
     *
     *
     */
    function list() {
        $dtos = $this->domainService->list();
        return new JsonResponse(["data" => $dtos], JsonResponse::HTTP_OK);
    }
    /**
     * @Route("/groups/{id}", methods={"GET"})
     */
    public function retrieve($id)
    {
        $dto = $this->domainService->retrieve($id);
        if (!$dto) {
            return new JsonResponse(["error_human" => "Not found",
                "error_code" => "not_found",
            ], JsonResponse::HTTP_NOT_FOUND);
        }
        return new JsonResponse(['data' => $dto], JsonResponse::HTTP_FOUND);
    }

    /**
     * @Route("/groups", methods={"POST"})
     */
    public function create(Request $request)
    {
        $body = json_decode(
            $request->getContent());
        $dto = $this->domainService->create($body);
        return new JsonResponse(['data' => $dto], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/groups/{id}", methods={"PUT"})
     */
    public function update(string $id, Request $request)
    {
        $body = json_decode(
            $request->getContent());
        $dto = $this->domainService->update($id, $body);
        if (!$dto) {
            return new JsonResponse(["error_human" => "Not found",
                "error_code" => "not_found",
            ], JsonResponse::HTTP_NOT_FOUND);
        }
        return new JsonResponse(['data' => $dto], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/groups/{id}", methods={"DELETE"})
     */
    public function delete(string $id)
    {
        $deleted = $this->domainService->delete($id);
        if (!$deleted) {
            return new JsonResponse(["error_human" => "Not found",
                "error_code" => "not_found",
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([], JsonResponse::HTTP_OK);
    }

   
}
