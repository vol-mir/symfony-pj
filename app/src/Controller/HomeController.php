<?php

namespace App\Controller;

use App\Entity\News;
use App\Service\DataTable\DataTableNews;
use App\Service\Parser\NewsFromUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * Index page
     *
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render("home/index.html.twig");
    }

    /**
     * List datatable action
     *
     * @Route("/datatable/news", methods="POST", name="datatable_news")
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @param DataTableNews $dataTableNews
     *
     * @return JsonResponse
     */
    public function listDatatableAction(
        Request $request,
        ManagerRegistry $doctrine,
        DataTableNews $dataTableNews
    ): JsonResponse {
        // Get the parameters from DataTable Ajax Call
        $draw = (int) $request->request->get("draw");
        $start = (int) $request->request->get("start");
        $length = (int) $request->request->get("length");
        $search = (array) $request->request->get("search");
        $orders = (array) $request->request->get("order");
        $columns = (array) $request->request->get("columns");

        // Orders
        foreach ($orders as $key => $order) {
            $orderColumn = $order["column"];
            $orders[$key]["name"] = $columns[$orderColumn]["name"];
        }

        $entityManager = $doctrine->getManager();
        $results = $entityManager
            ->getRepository(News::class)
            ->getListForDT($start, $length, $orders, $search, $columns);

        $listOblects = $results["listOblects"];
        $filteredObjectsCount = $results["listCount"];
        $totalObjectsCount = $results["countRecords"];
        $data = $dataTableNews->getData($listOblects, $columns);
    
        // Construct response
        $response = [
            "draw" => $draw,
            "recordsTotal" => $totalObjectsCount,
            "recordsFiltered" => $filteredObjectsCount,
            "data" => $data,
        ];

        $returnResponse = new JsonResponse();
        $returnResponse->setData($response);

        return $returnResponse;
    }

    /**
     * Download RBC news
     *
     * @Route("/download/rbc/news",  methods="POST", name="download_rbc_news")
     *
     * @param Request $request
     * @param NewsFromUrl $newsFromUrl
     *
     * @return JsonResponse
     */
    public function downloadRBCNews(Request $request, NewsFromUrl $newsFromUrl): JsonResponse
    {
        if (!$this->isCsrfTokenValid('download-rbc-news', $request->request->get('_token'))) {
            die;
        }

        $addingCounNews = $newsFromUrl->getRBCNews(15);

        return new JsonResponse([
            "message" => "Downloaded $addingCounNews news"
        ]);
    }
}
