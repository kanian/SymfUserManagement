<?php
namespace App\Controller;

use Exception;
use Psr\Log\LoggerInterface;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class SecurityController extends BaseController
{
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }
    
    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    /**
     * @Route("/", name="blackhole", methods={"GET"})
     */
    public function blackHole()
    {
        return $this->json(null);
    }
}
