<?php

namespace App\Controller;

use App\DomainService\UserDomainService;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        $dtos = $this->domainService->list();
        return new JsonResponse(["data" => $dtos], JsonResponse::HTTP_OK);
    }
    /**
     * @Route("/users/{id}", methods={"GET"})
     */
    public function retrieve($id)
    {
        try {
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
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        try {
            $body = json_decode(
                $request->getContent());
            $dto = $this->domainService->create($body, $passwordEncoder);
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
