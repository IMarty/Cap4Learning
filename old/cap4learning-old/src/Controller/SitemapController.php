<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Page;
use App\Entity\Training;
use App\Manager\NewsManager;
use App\Manager\PageManager;
use App\Manager\TrainingCategoryManager;
use App\Manager\TrainingManager;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Sonata\MediaBundle\Provider\ImageProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap/xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(Request $request,
                          TranslatorInterface $translator,
                          ImageProvider $imageProvider,
                          NewsManager $newsManager,
                          TrainingCategoryManager $trainingCategoryManager,
                          TrainingManager $trainingManager,
                          PageManager $pageManager
    ): Response
    {
        $hostname = $request->getSchemeAndHttpHost();

        $urls = [];

        $urls = array_merge($urls, $this->getStaticPagesUrls());
        $urls = array_merge($urls, $this->getNewsUrls($newsManager, $imageProvider));
        $urls = array_merge($urls, $this->getTrainingsCategoriesUrls($trainingCategoryManager, $translator));
        $urls = array_merge($urls, $this->getTrainingsUrls($trainingManager, $imageProvider));
        $urls = array_merge($urls, $this->getPagesUrl($pageManager, $imageProvider));


        // Training


        // Fabrication de la réponse XML
        $response = new Response(
            $this->renderView('sitemap/index.html.twig', ['urls' => $urls,
                'hostname' => $hostname]),
            200
        );

        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }

    public function getStaticPagesUrls(): array
    {
        $urls = [];

        // Statics pages
        $routesStatics = [
            'homepage',
            'news_listing',
        ];

        foreach ($routesStatics as $route) {
            $newUrl = [
                'loc' => $this->generateUrl($route)
            ];
            $urls[] = $newUrl;
        }

        return $urls;
    }

    public function getNewsUrls(NewsManager $newsManager, ImageProvider $imageProvider)
    {
        $urls = [];

        // News
        $newsListing = $newsManager->findBy([
            'published' => true,
        ]);

        /** @var News $news */
        foreach ($newsListing as $news) {
            $newUrl = [
                'loc' => $this->generateUrl('news_detail', [
                    'slug' => $news->getSlug()
                ]),
                'lastmod' => $news->getUpdatedAt()->format('Y-m-d')
            ];

            if ($news->getPicture()) {
                $newUrl['image'] = [
                    'title' => $news->getTitle(),
                    'loc' => $imageProvider->generatePublicUrl($news->getPicture(), 'reference')
                ];
            }

            $urls[] = $newUrl;
        }

        return $urls;
    }

    public function getTrainingsCategoriesUrls(TrainingCategoryManager $trainingCategoryManager, TranslatorInterface $translator)
    {
        $urls = [];

        $newUrl = [
            'loc' => $this->generateUrl('training_list', [
                'slug' => $translator->trans('search.default')
            ]),
        ];

        $urls[] = $newUrl;

        $trainingCategoryListing = $trainingCategoryManager->findBy([],['weight' => 'asc']);
        /** @var News $news */
        foreach ($trainingCategoryListing as $trainingCategory) {
            $newUrl = [
                'loc' => $this->generateUrl('training_list', [
                    'slug' => $trainingCategory->getSlug()
                ]),
                'lastmod' => $trainingCategory->getUpdatedAt()->format('Y-m-d')
            ];

            $urls[] = $newUrl;
        }
        return $urls;
    }

    public function getTrainingsUrls(TrainingManager $trainingManager, ImageProvider $imageProvider): array
    {
        $urls = [];

        // News
        $trainings = $trainingManager->findBy([
            'published' => true,
        ]);

        /** @var Training $training */
        foreach ($trainings as $training) {
            $newUrl = [
                'loc' => $this->generateUrl('training_detail', [
                    'slug_category' => $training->getCategory()->getSlug(),
                    'slug' => $training->getSlug()
                ]),
                'lastmod' => $training->getUpdatedAt()->format('Y-m-d')
            ];

            if ($training->getPicture()) {
                $newUrl['image'] = [
                    'title' => $training->getTitle(),
                    'loc' => $imageProvider->generatePublicUrl($training->getPicture(), 'reference')
                ];
            }

            $urls[] = $newUrl;
        }

        return $urls;
    }

    public function getPagesUrl(PageManager $pageManager, ImageProvider $imageProvider)
    {
        $urls = [];

        // News
        $pages = $pageManager->findBy([
            'published' => true,
        ]);

        /** @var Page $page */
        foreach ($pages as $page) {
            $newUrl = [
                'loc' => $this->generateUrl('page_detail', [
                    'slug' => $page->getSlug()
                ]),
                'lastmod' => $page->getUpdatedAt()->format('Y-m-d')
            ];

            if ($page->getPicture()) {
                $newUrl['image'] = [
                    'title' => $page->getTitle(),
                    'loc' => $imageProvider->generatePublicUrl($page->getPicture(), 'reference')
                ];
            }

            $urls[] = $newUrl;
        }

        return $urls;
    }

}
