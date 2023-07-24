<?php

namespace App\Controller;

use App\Manager\NewsManager;
use App\Utils\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route({
     *     "en": "/news",
     *     "fr": "/actualites"
     * }, name="news_listing")
     */
    public function index(Request $request, NewsManager $newsManager): Response
    {
        $filters = [
            'published' => [
                'translatable' => false,
                'value' => 1,
                'SQLComparison' => '='
            ]
        ];

        $newsPaginator = new Paginator(
            $request,
            $newsManager,
            $filters,
            'model.createdAt',
            3,
            'DESC'
        );

        return $this->render('news/index.html.twig', [
            'newsListing' => $newsPaginator->getRecords(),
            'pager' => $newsPaginator->getDisplayParameters(),
        ]);
    }

    /**
     * @Route({
     *     "en": "/news/{slug}",
     *     "fr": "/actualites/{slug}"
     * }, name="news_detail")
     */
    public function detail($slug, Request $request, NewsManager $newsManager): Response
    {
        $news = $newsManager->findBySlug($slug, $request->getLocale());

        if (!$news) {
            throw new NotFoundHttpException('This news doesnt exist');
        }

        return $this->render('news/detail.html.twig', [
            'news' => $news,
        ]);
    }
}
