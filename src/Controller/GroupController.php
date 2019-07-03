<?php

namespace App\Controller;

use App\DomainService\GroupDomainService;
use App\DomainService\UserDomainService;
use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends BaseController
{
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->domainService = new GroupDomainService($entityManager);
        parent::__construct($logger);
    }

    /**
     * @Route("/groups", methods={"GET"})
     *
     *
     */
    function list() {
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $dtos = $this->domainService->list();
            return new JsonResponse(["data" => $dtos], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            return $this->sendServerError($e);
        }}
    /**
     * @Route("/groups/{id}", methods={"GET"})
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

    /**
     * @Route("/groups", methods={"POST"})
     *
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
     * @Route("/groups/{id}", methods={"PUT"})
     *
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
     * @Route("/groups/{id}", methods={"DELETE"})
     *
     *
     */
    public function delete(string $id)
    {
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $deleted = $this->domainService->delete($id);
            if($deleted === GroupDomainService::GROUP_NOT_EMPTY){
                return new JsonResponse(["error_human" => "Group not empty",
                "error_code" => "group_not_empty",
            ], JsonResponse::HTTP_CONFLICT);
            }
            if (!$deleted) {
                return new JsonResponse(["error_human" => "Not found",
                    "error_code" => "not_found",
                ], JsonResponse::HTTP_NOT_FOUND);
            }

            return new JsonResponse([], JsonResponse::HTTP_OK);} catch (Exception $e) {
            return $this->sendServerError($e);
        }
    }

    /**
     * @Route("/groups/{groupId}/users/{userId}", methods={"PUT"})
     *
     *
     */
    public function assignUserToGroup(string $groupId, string $userId, UserDomainService $userDomainService)
    {
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $assigned = $this->domainService->assignUserToGroup($groupId, $userId, $userDomainService);

            if ($assigned === GroupDomainService::DOMAIN_OBJECT_NOT_FOUND) {
                return new JsonResponse(["error_human" => "Not found",
                    "error_code" => "not_found",
                ], JsonResponse::HTTP_NOT_FOUND);
            } else if ($assigned === GroupDomainService::ACTION_FAILED) {
                return new JsonResponse(["error_human" => "Action failed",
                    "error_code" => "action_failed",
                ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
            return new JsonResponse(
                ["data" => ["assigned" => $assigned, "groupId" => $groupId, "userId" => $userId]],
                JsonResponse::HTTP_OK);} catch (Exception $e) {
            return $this->sendServerError($e);
        }
    }

    /**
     * @Route("/groups/{groupId}/users/{userId}", methods={"DELETE"})
     *
     *
     */
    public function removeUserFromGroup(string $groupId, string $userId, UserDomainService $userDomainService)
    {

        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $removed = $this->domainService->removeUserFromGroup($groupId, $userId, $userDomainService);
            
            if ($removed === GroupDomainService::DOMAIN_OBJECT_NOT_FOUND) {
                return new JsonResponse(["error_human" => "Not found",
                    "error_code" => "not_found",
                ], JsonResponse::HTTP_NOT_FOUND);
            } else if ($removed === GroupDomainService::ACTION_FAILED) {
                return new JsonResponse(["error_human" => "Action failed",
                    "error_code" => "action_failed",
                ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
            return new JsonResponse(["data" => []], JsonResponse::HTTP_OK);} catch (Exception $e) {
            return $this->sendServerError($e);
        }
    }

}
