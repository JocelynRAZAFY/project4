<?php

namespace App\Controller;

use App\Manager\CrudOnePageManager;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CrudOnePageController extends AbstractController
{
    private $crudOnePageManager;
    public function __construct(CrudOnePageManager $crudOnePageManager)
    {
        $this->crudOnePageManager = $crudOnePageManager;
    }

    /**
     * @Route("/crud/one/page", name="crud_one_page")
     */
    public function index(VilleRepository $villeRepository)
    {

        return $this->render('crud_one_page/index.html.twig', []);
    }

    /**
     * @Route("/crud/one/page/update",
     *     defaults = { "page" = 1 },
     *     options = { "expose" = true },
     *     name = "crud_one_page_update",
     * )
     */
    public function updateOnePage()
    {
        return $this->crudOnePageManager->updateOnePage();
    }

    /**
     * @Route("/regionDepartementVille",
     *     defaults = { "page" = 1 },
     *     options = { "expose" = true },
     *     name = "region_departement_ville",
     * )
     */
    public function getRegionDepartementVille()
    {
        return $this->crudOnePageManager->getRegionDepartementVille();
    }

    /**
     * @Route("/crud_one_page_detail",
     *     defaults = { "page" = 1 },
     *     options = { "expose" = true },
     *     name = "crud_one_page_detail",
     * )
     */
    public function getDetail()
    {
        return $this->crudOnePageManager->getDetail();
    }

    /**
     * @Route("/crud_one_page_delete",
     *     defaults = { "page" = 1 },
     *     options = { "expose" = true },
     *     name = "crud_one_page_delete",
     * )
     */
    public function deleteContact()
    {
        return $this->crudOnePageManager->deleteContact();
    }
}
