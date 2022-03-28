<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepositoryInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class NewsController extends AbstractController
{
    /**
     * @var NewsRepositoryInterface
     */
    private $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @Route("/news/{page}", name="app_news", requirements={"page"="\d+"})
     */
    public function index(Request $request, $page = 1): Response
    {
        $pageSize = 5;
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $tags = $request->get('tags');
        $date = $request->get('date');

        if (!$this->dateValidation($date) && $date) {
            throw new \Exception('date is wrong');
        }

        $filteredData = $this->newsRepository->getFilteredNews($page, $pageSize, $date, (string) $tags);

        $jsonContent = $serializer->serialize($filteredData, 'json');
        var_dump($filteredData);
        return new JsonResponse([
            'message' => 'Ok',
            'data' => $jsonContent,
        ]);
    }

    private function dateValidation($date, $format = 'Y-m')
    {
        $dt = DateTime::createFromFormat($format, $date);
        return $dt && $dt->format($format) === $date;
    }
}
