<?php
namespace App\Controller;

use Exception;
use Psr\Log\LoggerInterface;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends BaseController
{
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }
    /**
     * @Route("/login", name="app_login", methods={"POST"})
     */
    public function login(Request $request)
    {
        try {
            $user = $this->getUser();

            return $this->json([
                'username' => $user->getUsername(),
                'roles' => $user->getRoles(),
            ]);} catch (Exception $e) {
            return $this->sendServerError($e);
        }
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
