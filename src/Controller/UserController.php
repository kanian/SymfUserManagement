<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use App\Controller\BaseController;
use App\DomainService\UserDomainService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends BaseController
{
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->domainService = new UserDomainService($entityManager);
        parent::__construct($logger);
    }

    /**
     * @Route("/users", methods={"GET"})
     *
     */
    function list() {
        try {
            
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $dtos = $this->domainService->list();
            return new JsonResponse(["data" => $dtos], JsonResponse::HTTP_OK);} catch (Exception $e) {
            return $this->sendServerError($e);
        }
    }
    /**
     * @Route("/users/{id}", methods={"GET"})
     */
    public function retrieve($id)
    {
        try {
            
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $dto = $this->domainService->retrieve($id);
            if (!$dto) {
                return new JsonResponse(["error_human" => "Not found",
                    "error_code" => "not_found",
                ], JsonResponse::HTTP_NOT_FOUND);
            }
            return new JsonResponse(['data' => $dto], JsonResponse::HTTP_FOUND);} catch (Exception $e) {
            return $this->sendServerError($e);
        }
    }

    //
    /**
     *
     * @Route("/users", methods={"POST"})
     *
     */
    public function create(Request $request)
    {
        try {
            
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $body = json_decode(
                $request->getContent());
            $dto = $this->domainService->create($body);
            return new JsonResponse(['data' => $dto], JsonResponse::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->sendServerError($e);
        }
    }

    /**
     * @Route("/users/{id}", methods={"PUT"})
     *
     */
    public function update(string $id, Request $request)
    {
        try {
            
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $body = json_decode(
                $request->getContent());
            $dto = $this->domainService->update($id, $body);
            if (!$dto) {
                return new JsonResponse(["error_human" => "Not found",
                    "error_code" => "not_found",
                ], JsonResponse::HTTP_NOT_FOUND);
            }
            return new JsonResponse(['data' => $dto], JsonResponse::HTTP_OK);} catch (Exception $e) {
            return $this->sendServerError($e);
        }
    }

    /**
     * @Route("/users/{id}", methods={"DELETE"})
     *
     */
    public function delete(string $id)
    {
        try {
            
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $deleted = $this->domainService->delete($id);
            if (!$deleted) {
                return new JsonResponse(["error_human" => "Not found",
                    "error_code" => "not_found",
                ], JsonResponse::HTTP_NOT_FOUND);
            }

            return new JsonResponse([], JsonResponse::HTTP_OK);} catch (Exception $e) {
            return $this->sendServerError($e);
        }
    }

}
