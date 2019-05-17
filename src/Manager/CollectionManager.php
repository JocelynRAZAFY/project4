<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 16/05/19
 * Time: 15:20
 */

namespace App\Manager;


use App\Entity\Detail;
use App\Entity\Family;
use App\Form\FamilyType;
use App\Repository\FamilyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CollectionManager extends BaseManager
{
    /**
     * @var FamilyRepository
     */
    private $familyRepository;

    /**
     * CollectionManager constructor.
     * @param EntityManagerInterface $em
     * @param ContainerInterface $container
     * @param RequestStack $requestStack
     * @param SessionInterface $session
     * @param LoggerInterface $logger
     * @param FamilyRepository $familyRepository
     */
    public function __construct(
        EntityManagerInterface $em,
        ContainerInterface $container,
        RequestStack $requestStack,
        SessionInterface $session,
        LoggerInterface $logger,
        FamilyRepository $familyRepository)
    {
        $this->familyRepository = $familyRepository;
        parent::__construct($em, $container, $requestStack, $session, $logger);
    }

    /**
     * Ajout de collection
     * @return array
     */
    public function updateCollection(Family $family)
    {

        $form = $this->createForm(FamilyType::class,$family);
        $form->handleRequest($this->request);

        if($form->isSubmitted() && $form->isValid()){
            $this->save($family);
            return [true,null];
        }

        return [false,$form];
    }

    /**
     * @return Family[]
     */
    public function getAllCollection()
    {
        $families = $this->familyRepository->findBy([],['id' => 'DESC']);
        return $families;
    }

    /**
     * Suppression de collection
     */
    public function deleteCollection()
    {
        $family = $this->familyRepository->find($this->data->id);
        $this->remove($family);
        return $this->success(['id' => $this->data->id]);
    }
}