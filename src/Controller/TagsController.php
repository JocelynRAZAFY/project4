<?php

namespace App\Controller;

use App\Entity\Article;
use App\Manager\TagsManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TagsController extends AbstractController
{

    private $tagsManager;

    public function __construct(TagsManager $tagsManager)
    {
        $this->tagsManager = $tagsManager;
    }

    /**
     * @Route("/tag/add", name="add_tag")
     */
    public function addTag()
    {
        $result = $this->tagsManager->updateTag(new Article());

        if($result[0]){
            return $this->redirectToRoute('list_article');
        }

        return $this->render('tags/index.html.twig', [
            'form' => $result[1]->createView()
        ]);
    }

    /**
     * @Route("/tag/edit/{id}", name="edit_tag")
     */
    public function editTag(Article $article)
    {
        $result = $this->tagsManager->updateTag($article);

        if($result[0]){
            return $this->redirectToRoute('list_article');
        }

        return $this->render('tags/index.html.twig', [
            'form' => $result[1]->createView()
        ]);
    }

    /**
     * @Route("/article/list", name="list_article")
     */
    public function listTag()
    {
        $articles = $this->tagsManager->getAllArticle();

        return $this->render('tags/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/tags.json", name="all_tag")
     */
    public function getAllTags()
    {
        return $this->json($this->tagsManager->getAllTags());
    }

    /**
     * @Route("/delete_article",
     *     defaults = { "page" = 1 },
     *     options = { "expose" = true },
     *     name = "delete_article",
     * )
     */
    public function deleteArticle()
    {
        return $this->tagsManager->deleteArticle();
    }
}
