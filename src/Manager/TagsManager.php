<?php
/**
 * Created by PhpStorm.
 * User: jocelyn
 * Date: 5/18/19
 * Time: 6:14 PM
 */

namespace App\Manager;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\TagsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class TagsManager extends BaseManager
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var TagsRepository
     */
    private $tagsRepository;

    private $serializer;


    public function __construct(
        EntityManagerInterface $em,
        ContainerInterface $container,
        RequestStack $requestStack,
        SessionInterface $session,
        LoggerInterface $logger,
        ArticleRepository $articleRepository,
        TagsRepository $tagsRepository,
        SerializerInterface $serializer)
    {
        $this->articleRepository = $articleRepository;
        $this->tagsRepository = $tagsRepository;
        $this->serializer = $serializer;

        parent::__construct($em, $container, $requestStack, $session, $logger);
    }

    public function updateTag(Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($this->request);

        if($form->isSubmitted() && $form->isValid()){
            $this->save($article);

            return [true,null];
        }

        return [false, $form];
    }

    /**
     * Get all article
     * @return Article[]
     */
    public function getAllArticle()
    {
        $articles = $this->articleRepository->findBy([],['id' => 'DESC']);
        return $articles;
    }

    /**
     * @return array
     */
    public function getAllTags()
    {
        $tags = $this->tagsRepository->findAll();
        $result = $this->tagsRepository->transformAll($tags);
        return $result;
    }

    /**
     * @return JsonResponse
     */
    public function deleteArticle()
    {
        $article = $this->articleRepository->find($this->data->id);
        $this->remove($article);
        return $this->success(['id' => $this->data->id]);
    }

    /**
     * @return JsonResponse
     */
    public function contentPrism()
    {

        $code = '<label for="exampleInputEmail1">Email address</label>';
        $result = [
            'code' => $code,
            'language' => 'markup',
        ];
        return $this->success($result);
    }
}