<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BaseController extends AbstractController
{

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    protected function sendServerError($e)
    {
        $status = $e instanceof AccessDeniedException ? JsonResponse::HTTP_UNAUTHORIZED : JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        $message = $e instanceof AccessDeniedException ? ["error_human" => "Unauthorized", "error_code" => "Unauthorized"]: ["error_human" => "Server Error", "error_code" => "server_error"];
        $this->logger->error("Error Occured " . $e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getLine());
        return new JsonResponse($message, $status);
    }
}
