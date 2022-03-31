<?php

namespace App\Controller;

use App\Entity\News;
use App\Serializer\Normalizer\NewsNormalizer;
use App\Service\Parser\Transport\NotFoundException;
use App\Service\Parser\Transport\TransportException;
use App\Service\DownloadNews;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    // /**
    //  * Index page
    //  *
    //  * @Route("/", name="home")
    //  *
    //  * @return Response
    //  */
    // public function index(): Response
    // {
    //     return $this->render("home/index.html.twig");
    // }

    // /**
    //  * List datatable action
    //  *
    //  * @Route("/datatable/news", methods="POST", name="datatable_news")
    //  *
    //  * @param Request $request
    //  * @param ManagerRegistry $doctrine
    //  * @param NewsNormalizer $normalizer
    //  *
    //  * @return JsonResponse
    //  */
    // public function listDatatableAction(
    //     Request         $request,
    //     ManagerRegistry $doctrine,
    //     NewsNormalizer  $normalizer
    // ): JsonResponse
    // {
    //     // Get the parameters from DataTable Ajax Call
    //     $draw = (int)$request->request->get('draw');
    //     $start = (int)$request->request->get('start');
    //     $length = (int)$request->request->get('length');
    //     $search = (array)$request->request->get('search');
    //     $orders = (array)$request->request->get('order');
    //     $columns = (array)$request->request->get('columns');

    //     // Orders
    //     foreach ($orders as $key => $order) {
    //         $orderColumn = $order['column'];
    //         $orders[$key]['name'] = $columns[$orderColumn]['name'];
    //     }

    //     $entityManager = $doctrine->getManager();
    //     $results = $entityManager
    //         ->getRepository(News::class)
    //         ->getListForDataTable($start, $length, $orders, $search);

    //     $listObjects = $results['listObjects'];
    //     foreach ($listObjects as $item) {
    //         $data[] = $normalizer->normalize($item);
    //     }

    //     // Construct response
    //     $response = [
    //         'draw' => $draw,
    //         'recordsTotal' => $results['countRecords'],
    //         'recordsFiltered' => $results['listCount'],
    //         'data' => $data ?? [],
    //     ];

    //     $returnResponse = new JsonResponse();
    //     $returnResponse->setData($response);

    //     return $returnResponse;
    // }

    // /**
    //  * Download RBC news
    //  *
    //  * @Route("/download/rbc/news",  methods="POST", name="download_rbc_news")
    //  *
    //  * @param \App\Service\DownloadNews $parserNews
    //  *
    //  * @return JsonResponse
    //  * @throws NotFoundException
    //  * @throws TransportException
    //  */
    // public function downloadRBCNews(DownloadNews $parserNews): JsonResponse
    // {
    //     $addingCountNews = $parserNews->downloadRBCNews();

    //     return new JsonResponse([
    //         'message' => "Downloaded $addingCountNews news"
    //     ]);
    // }

    // /**
    //  * Show news
    //  *
    //  * @Route("/news/{news_id}/show", methods="GET", name="news_show")
    //  *
    //  * @param News $news
    //  *
    //  * @return Response
    //  */
    // public function show(News $news): Response
    // {
    //     return $this->render('home/news_show.html.twig', [
    //         'news' => $news
    //     ]);
    // }

    // /**
    //  * Delete news
    //  *
    //  * @Route("/news/{id}/delete", methods="POST", name="news_delete")
    //  *
    //  * @param Request $request
    //  * @param ManagerRegistry $doctrine
    //  * @param News $news
    //  *
    //  * @return JsonResponse
    //  */
    // public function delete(Request $request, ManagerRegistry $doctrine, News $news): JsonResponse
    // {
    //     if ($this->isCsrfTokenValid('delete-item', $request->request->get('_token'))) {
    //         $entityManager = $doctrine->getManager();
    //         $entityManager->remove($news);
    //         $entityManager->flush();
    //     }

    //     return new JsonResponse(['message' => 'News successfully deleted!']);
    // }


    /**
     * @Route("/{reactRouting}", name="home", defaults={"reactRouting": null})
     */
    public function index()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/api/users", name="users")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getUsers()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Olususi Oluyemi',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                'imageURL' => 'https://randomuser.me/api/portraits/women/50.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Camila Terry',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                'imageURL' => 'https://randomuser.me/api/portraits/men/42.jpg'
            ],
            [
                'id' => 3,
                'name' => 'Joel Williamson',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                'imageURL' => 'https://randomuser.me/api/portraits/women/67.jpg'
            ],
            [
                'id' => 4,
                'name' => 'Deann Payne',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                'imageURL' => 'https://randomuser.me/api/portraits/women/50.jpg'
            ],
            [
                'id' => 5,
                'name' => 'Donald Perkins',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                'imageURL' => 'https://randomuser.me/api/portraits/men/89.jpg'
            ]
        ];
    
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($users));
        
        return $response;
    }
}
