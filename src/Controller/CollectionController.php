<?php

namespace App\Controller;

use App\Entity\Group;
use App\Form\GroupType;
use App\Manager\CollectionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CollectionController extends AbstractController
{
    private $collectionManager;

    public function __construct(CollectionManager $collectionManager)
    {
        $this->collectionManager = $collectionManager;
    }

    /**
     * @Route("/collection/add", name="add_collection")
     */
    public function addCollection()
    {
        $result = $this->collectionManager->addCollection();

        return $this->render('collection/index.html.twig', [
            'form' => $result[1]->createView()
        ]);
    }
}
