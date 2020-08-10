<?php


namespace App\Manager;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserManager extends BaseManager
{

    private $userRepository;

    public function __construct(
        EntityManagerInterface $em,
        ContainerInterface $container,
        RequestStack $requestStack,
        SessionInterface $session,
        LoggerInterface $logger,
        UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct($em, $container, $requestStack, $session, $logger);
    }

    public function addUser()
    {
        $users = ['User1','User2','User3','User4','User5','User6'];
        foreach ($users as  $item){
            if(!$this->userRepository->findOneBy(['prenom' =>$item])){
                $user = new User();
                $user->setPrenom($item);
                $this->save($user);
            }
        }

        return $this->userRepository->findAll();
    }
}