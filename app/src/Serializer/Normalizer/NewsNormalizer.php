<?php

namespace App\Serializer\Normalizer;

use App\Helper\DateHelper;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class NewsNormalizer
 */
class NewsNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{

    /** @var UrlGeneratorInterface */
    private $router;

    /**
     * DataTableNews constructor
     * @param  UrlGeneratorInterface $router
     * @return void
     */
    public function __construct(UrlGeneratorInterface $router) {
        $this->router = $router;
    }
    
    /**
     * normalize
     * @return array
     */
    public function normalize(
        $object,
        $format = null,
        array $context = []
    ): array {

        $urlShow = $this->router->generate("news_show", [
            "news_id" => $object->getNewsId(),
        ]);

        $newsId = [
            "url" => $urlShow,
            "title" => "show news",
            "text" => $object->getNewsId(),
        ];

        $title = $object->getTitle();

        $newsDate = $object
            ->getDateNews()
            ->format(DateHelper::PHP_STANDARD_FORMAT);

        $fullText = mb_strimwidth($object->getFullText(), 0, 200, "...");

        $category = $object->getCategory() ?? '-';

        $control = [
            "urlShow" => $urlShow,
            "idDelete" => $object->getId(),
        ];

        return [$newsId, $title, $newsDate, $fullText, $category, $control];
    }
    
    /**
     * supportsNormalization
     * @param  mixed $data
     * @param  mixed $format
     * @return bool
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof \App\Entity\News;
    }
    
    /**
     * hasCacheableSupportsMethod
     * @return bool
     */
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
