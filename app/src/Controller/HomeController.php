<?php

namespace App\Controller;

use App\Entity\News;
use App\Service\Parser\Transport\NotFoundException;
use App\Service\Parser\Transport\TransportException;
use App\Service\DownloadNews;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * Index page
     *
     * @Route("/{reactRouting}", name="home", defaults={"reactRouting": null})
     *
     * @return Response
     */
    public function index()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/api/news", methods="GET", name="news")
     * 
     * @param ManagerRegistry $doctrine
     * 
     * @return JsonResponse
     */
    public function getNews(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $posts = $entityManager
            ->getRepository(News::class)
            ->getLastNews(15);
    
        $returnResponse = new JsonResponse();
        $returnResponse->setData($posts);

        return $returnResponse;
    }

    /**
     * Download RBC news
     *
     * @Route("/api/download/rbc/news",  methods="POST", name="download_rbc_news")
     *
     * @param \App\Service\DownloadNews $parserNews
     *
     * @return JsonResponse
     * @throws NotFoundException
     * @throws TransportException
     */
    public function downloadRBCNews(DownloadNews $parserNews): JsonResponse
    {
        $addingCountNews = $parserNews->downloadRBCNews();

        return new JsonResponse([
            'message' => "Downloaded $addingCountNews news"
        ]);
    }

    /**
     * Test news
     *
     * @Route("/api/tnews",  methods="GET", name="tnews")
     *
     *
     * @return JsonResponse
     */
    public function testCNews(): JsonResponse
    {
        return new JsonResponse([
            [
              "id" => 1,
              "author" => "Саша Печкин",
              "text" => "В четверг, четвертого числа...",
              "bigText" =>
                "в четыре с четвертью часа четыре чёрненьких чумазеньких чертёнка чертили чёрными чернилами чертёж."
            ],
            [
              "id" => 2,
              "author" => "Просто Вася",
              "text" => "Считаю, что $ должен стоить 35 рублей!",
              "bigText" => "А евро 42!"
            ],
            [
              "id" => 3,
              "author" => "Max Frontend",
              "text" => "Прошло 2 года с прошлых учебников, а $ так и не стоит 35",
              "bigText" => "А евро опять выше 70."
            ],
            [
              "id" => 4,
              "author" => "Гость",
              "text" => "Бесплатно. Без смс, про реакт, заходи - https: //maxpfrontend.ru",
              "bigText" =>
                "Еще есть группа VK, telegram и канал на youtube! Вся инфа на сайте, не реклама!"
            ]
          ]);
    }
}
