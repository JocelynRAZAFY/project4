<?php

namespace App\Controller;

use App\Entity\User;
use App\EventSubscriber\Events;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $userManager;
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Route("/", name="user")
     */
    public function index()
    {
        $users = $this->userManager->addUser();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user/gestion/{id}", name="gestion", requirements={"id":"\d+"})
     */
    public function userGestion(User $user)
    {
        return $this->render('user/gestion.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user/gestion/{id}/{type}", name="presence", requirements={"id":"\d+"})
     */
    public function userPresence(User $user, string $type)
    {

        return $this->render('user/presence.html.twig', [
            'user' => $user,
            'type' => $type,
        ]);
    }
}
