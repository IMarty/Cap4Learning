<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Training;
use App\Entity\TrainingCategory;
use App\Form\ContactType;
use App\Form\TrainingSearchType;
use App\Mailer\Mailer;
use App\Manager\ContactManager;
use App\Manager\TrainingCategoryManager;
use App\Manager\TrainingManager;
use App\Utils\Paginator;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrainingController extends AbstractController
{
    /**
     * @Route({
     *     "en": "/training/search/{slug}",
     *     "fr": "/formation/recherche/{slug}"
     * }, name="training_list")
     */
    public function index(Request $request, $slug, TrainingCategoryManager $trainingCategoryManager, TrainingManager $trainingManager, TranslatorInterface $translator): Response
    {
        $category = null;

        $filters = [
            'published' => [
                'translatable' => false,
                'value' => 1,
                'SQLComparison' => '='
            ]
        ];

        if (!in_array($slug, ['all', 'toutes'])) {
            $category = $trainingCategoryManager->findBySlug($slug, $request->getLocale());

            if (!$category) {

                $locale = ($request->getLocale() == 'en') ? 'fr' : 'en';
                $category = $trainingCategoryManager->findBySlug($slug, $locale);

                if (!$category) {
                    throw $this->createNotFoundException('No categories with this slug');
                }
            }

            $filters['category'] = [
                'translatable' => false,
                'value' => $category->getId(),
                'SQLComparison' => '='
            ];

            $filters['category'] = [
                'translatable' => false,
                'value' => $category->getId(),
                'SQLComparison' => '='
            ];
        }

        $trainingSearch = [];
        $trainingSearchForm  = $this
            ->createForm(TrainingSearchType::class, $trainingSearch, [
                'method' => 'GET'
            ])
        ;

        $trainingSearchForm->handleRequest($request);
        if ($trainingSearchForm->isSubmitted() && $trainingSearchForm->isValid()) {
            $trainingSearch = $trainingSearchForm->getData();
        }

        if (isset($trainingSearch['title']) && !empty($trainingSearch['title'])) {
            $filters['title'] = [
                'translatable' => true,
                'value' => '%'.$trainingSearch['title'].'%',
                'SQLComparison' => 'LIKE',
                'isKeywordSearch' => true
            ];

            $filters['shortDescription'] = [
                'translatable' => true,
                'value' => '%'.$trainingSearch['title'].'%',
                'SQLComparison' => 'LIKE',
                'isKeywordSearch' => true
            ];

            $filters['longDescription'] = [
                'translatable' => true,
                'value' => '%'.$trainingSearch['title'].'%',
                'SQLComparison' => 'LIKE',
                'isKeywordSearch' => true
            ];

            $filters['requirements'] = [
                'translatable' => true,
                'value' => '%'.$trainingSearch['title'].'%',
                'SQLComparison' => 'LIKE',
                'isKeywordSearch' => true
            ];

            $filters['coveredSkills'] = [
                'translatable' => true,
                'value' => '%'.$trainingSearch['title'].'%',
                'SQLComparison' => 'LIKE',
                'isKeywordSearch' => true
            ];

            $filters['audience'] = [
                'translatable' => true,
                'value' => '%'.$trainingSearch['title'].'%',
                'SQLComparison' => 'LIKE',
                'isKeywordSearch' => true
            ];

            $filters['goals'] = [
                'translatable' => true,
                'value' => '%'.$trainingSearch['title'].'%',
                'SQLComparison' => 'LIKE',
                'isKeywordSearch' => true
            ];

            $filters['methods'] = [
                'translatable' => true,
                'value' => '%'.$trainingSearch['title'].'%',
                'SQLComparison' => 'LIKE',
                'isKeywordSearch' => true
            ];

            $filters['achievement'] = [
                'translatable' => true,
                'value' => '%'.$trainingSearch['title'].'%',
                'SQLComparison' => 'LIKE',
                'isKeywordSearch' => true
            ];

            $filters['metas'] = [
                'translatable' => true,
                'value' => '%'.$trainingSearch['title'].'%',
                'SQLComparison' => 'LIKE',
                'isKeywordSearch' => true
            ];
//
//            $filters['targetedJobs'] = [
//                'translatable' => true,
//                'value' => '%'.$trainingSearch['title'].'%',
//                'SQLComparison' => 'LIKE',
//                'isKeywordSearch' => true
//            ];

            $filters['moduleTitle'] = [
                'translatable' => true,
                'value' => '%'.$trainingSearch['title'].'%',
                'SQLComparison' => 'LIKE',
                'isKeywordSearch' => true,
                'dataModel' => [
                    'model' => 'App:Module',
                    'modelKey' => 'module',
                    'modelTranslation' => 'App:ModuleTranslation',
                    'modelTranslationKey' => 'moduleTranslation',
                    'joinCondition' => 'model.id = module.training',
                    'fieldCompared' => 'moduleTranslation.title'
                ]
            ];

            $filters['moduleDescription'] = [
                'translatable' => true,
                'value' => '%'.$trainingSearch['title'].'%',
                'SQLComparison' => 'LIKE',
                'isKeywordSearch' => true,
                'dataModel' => [
                    'model' => 'App:Module',
                    'modelKey' => 'module',
                    'modelTranslation' => 'App:ModuleTranslation',
                    'modelTranslationKey' => 'moduleTranslation',
                    'joinCondition' => 'model.id = module.training',
                    'fieldCompared' => 'moduleTranslation.description'
                ]
            ];
        }

        if (isset($trainingSearch['eligibleCpf']) && !empty($trainingSearch['eligibleCpf'])) {
            $filters['eligibleCpf'] = [
                'translatable' => false,
                'value' => 1,
                'SQLComparison' => '='
            ];
        }

        $trainingPaginator = new Paginator(
            $request,
            $trainingManager,
            $filters,
            'model.nextDate',
            8
        );

        $categories = $trainingCategoryManager->findByTranslationOrder(
            'title', 'asc', $request->getLocale()
        );

        return $this->render('training/index.html.twig', [
            'currentCategory' => $category,
            'categories' => $categories,
            'trainings' => $trainingPaginator->getRecords(),
            'pager' => $trainingPaginator->getDisplayParameters(),
            'filtersForm' => $trainingSearchForm->createView()
        ]);
    }

    /**
     * @Route({
     *     "en": "/training/{slug_category}/{slug}",
     *     "fr": "/formation/{slug_category}/{slug}"
     * }, name="training_detail")
     */
    public function detail(Request $request, $slug, TrainingManager $trainingManager, Mailer $mailer, ContactManager $contactManager): Response
    {
        $training = $trainingManager->findBySlug($slug, $request->getLocale());

        if (!$training) {
            throw $this->createNotFoundException('Training not found');
        }

        $contact = new Contact();
        $contact->setType(Contact::CONTACT_DEVIS);

        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $this->addFlash('success', 'Your message has been successfully sent !');
            $mailer->sendConfirmationContact($contact, $training->getTitle());
            $contact->setConversionPage($training->getTitle());
            $contactManager->save($contact);
            return $this->redirect($request->getUri());
        }

        return $this->render('training/detail.html.twig', [
            'training' => $training,
            'form' => $contactForm->createView(),
        ]);
    }
}
