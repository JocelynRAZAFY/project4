<?php


namespace App\EventSubscriber;

use App\Entity\User;
use App\Manager\BaseManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserSubscriber extends BaseManager implements EventSubscriberInterface
{

    private $kernel;

    private $userRepository;

    public function __construct(
        EntityManagerInterface $em,
        ContainerInterface $container,
        RequestStack $requestStack,
        SessionInterface $session,
        LoggerInterface $logger,
        SerializerInterface $serializer,
        KernelInterface $kernel,
        UserRepository $userRepository)
    {
        $this->kernel = $kernel;
        $this->userRepository = $userRepository;
        parent::__construct($em, $container, $requestStack, $session, $logger, $serializer);
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::USER_CREATE => 'onUserCreate'
        ];
    }

    /**
     * @param GenericEvent $event
     */
    public function onUserCreate(GenericEvent $event)
    {
        $users = $event->getSubject();
        foreach ($users as  $item){
            if(!$this->userRepository->findOneBy(['prenom' =>$item])){
                $user = new User();
                $user->setPrenom($item);
                $this->save($user);
            }
        }
    }
}