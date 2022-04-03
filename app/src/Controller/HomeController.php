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
}
