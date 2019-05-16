<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 16/05/19
 * Time: 15:20
 */

namespace App\Manager;


use App\Entity\Group;
use App\Form\GroupType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CollectionManager extends BaseManager
{

    public function __construct(
        EntityManagerInterface $em,
        ContainerInterface $container,
        RequestStack $requestStack,
        SessionInterface $session,
        LoggerInterface $logger)
    {
        parent::__construct($em, $container, $requestStack, $session, $logger);
    }

    public function addCollection()
    {
        $group = new Group();

        $form = $this->createForm(GroupType::class,$group);
        $form->handleRequest($this->request);

        if($form->isSubmitted() && $form->isValid()){
            $this->save($form->getData());

            return [true,null];
        }

        return [false,$form];
    }
}