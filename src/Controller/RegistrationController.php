<?php

namespace App\Controller;

namespace App\Controller;

//use App\Entity\User;
use App\DomainService\UserDomainService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    public function __construct(/*EntityManagerInterface $entityManager, */UserDomainService $domainService)
    {
       // $this->entityManager = $entityManager;
       // $this->domainService = new UserDomainService($entityManager);
       $this->domainService = $domainService;
    }
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $body = json_decode(
            $request->getContent());

        $dto = $this->domainService->create($body,$passwordEncoder);
        return new JsonResponse(['data' => $dto], JsonResponse::HTTP_CREATED);

    }
}
