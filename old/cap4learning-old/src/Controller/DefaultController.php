<?php

namespace App\Controller;

use App\Entity\Training;
use App\Form\HomeSearchType;
use App\Form\TrainingSearchType;
use App\Manager\NewsManager;
use App\Manager\TrainingCategoryManager;
use App\Manager\TrainingManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request, TrainingManager $trainingManager, TrainingCategoryManager $trainingCategoryManager, TranslatorInterface $translator): Response
    {
        $trainings = $trainingManager->findBy(
            ['published' => true],
            ['createdAt'=> 'DESC'],
            5
        );
        $trainingsCategories = $trainingCategoryManager->findBy([],['weight' => 'asc']);

        $searchTraining = [];
        $formTraining = $this->createForm(TrainingSearchType::class, $searchTraining, [
            'method' => 'GET',
            'action' => $this->generateUrl('training_list', [
                'slug' => $translator->trans('all'),
            ])
        ]);

        return $this->render('home/index.html.twig', [
            'trainings' => $trainings,
            'trainingsCategories' => $trainingsCategories,
            'formTraining' => $formTraining->createView()
        ]);
    }

    public function searchBar(Request $request, TranslatorInterface $translator)
    {
        $searchTraining = [];
        $formTraining = $this->createForm(TrainingSearchType::class, $searchTraining, [
            'method' => 'GET',
            'action' => $this->generateUrl('training_list', [
                'slug' => $translator->trans('all'),
            ])
        ]);

        return $this->render('components/searchbar.html.twig',
            ['form' => $formTraining->createView()]
        );
    }
}
