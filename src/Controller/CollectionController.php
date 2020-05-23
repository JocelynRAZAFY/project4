<?php

namespace App\Controller;

use App\Entity\Family;
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
        $result = $this->collectionManager->updateCollection(new Family());
        if($result[0]){
            return $this->redirectToRoute('list_collection');
        }
        return $this->render('collection/index.html.twig', [
            'form' => $result[1]->createView()
        ]);
    }

    /**
     * @Route("/collection/edit/{id}", name="edit_collection")
     */
    public function editCollection(Family $family)
    {
        $result = $this->collectionManager->updateCollection($family);
        if($result[0]){
            return $this->redirectToRoute('list_collection');
        }
        return $this->render('collection/index.html.twig', [
            'form' => $result[1]->createView()
        ]);
    }

    /**
     * @Route("/collection/list", name="list_collection")
     */
    public function listCollection()
    {
        $groups = $this->collectionManager->getAllCollection();

        return $this->render('collection/index.html.twig', [
            'groups' => $groups
        ]);
    }

    /**
     * @Route("/delete_collection",
     *     defaults = { "page" = 1 },
     *     options = { "expose" = true },
     *     name = "delete_collection",
     * )
     */
    public function deleteCollection()
    {
        return $this->collectionManager->deleteCollection();
    }
}
