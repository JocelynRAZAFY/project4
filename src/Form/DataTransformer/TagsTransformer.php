<?php
/**
 * Created by PhpStorm.
 * User: jocelyn
 * Date: 5/18/19
 * Time: 5:54 PM
 */

namespace App\Form\DataTransformer;


use App\Entity\Tags;
use App\Repository\TagsRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagsTransformer implements DataTransformerInterface
{
    private $tagsRepository;

    public function __construct(TagsRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    /**
     * Transorm data array to string
     * @param mixed $value
     * @return mixed|string
     */
    public function transform($tags)
    {
        return implode(',', $tags);
    }

    /**
     * Transform string to array object of tags
     * @param mixed $value
     * @return Tags[]|array|mixed
     */
    public function reverseTransform($value)
    {
        $names = array_unique(array_filter(array_map('trim',explode(',', $value))));

        $tags = $this->tagsRepository->findBy(['label' => $names]);
        $newTags = array_diff($names,$tags);

        $tabTags= $tags;
        foreach($newTags as $newTag){
            $tag = new Tags();
            $tag->setLabel($newTag);

            $tabTags[] = $tag;
        }

        return $tabTags;
    }
}