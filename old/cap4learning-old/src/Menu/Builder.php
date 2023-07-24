<?php
// src/Menu/Builder.php
namespace App\Menu;

use App\Manager\PageManager;
use App\Manager\TrainingCategoryManager;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

final class Builder
{
    private $factory;
    private $trainingCategoryManager;
    private $pageManager;
    private $translator;

    public function __construct(FactoryInterface $factory,  TrainingCategoryManager $trainingCategoryManager, PageManager $pageManager, TranslatorInterface $translator)
    {
        $this->factory = $factory;
        $this->trainingCategoryManager = $trainingCategoryManager;
        $this->pageManager = $pageManager;
        $this->translator = $translator;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Homepage', ['route' => 'homepage']);
        $menu->addChild('Courses', [
                'uri' => '#',
            ])
        ;

        $menu['Courses']->addChild('All', [
            'route' => 'training_list',
            'routeParameters' => [
                'slug' => $this->translator->trans('all'),
            ]
        ]);

        $trainingsCategories = $this->trainingCategoryManager->findBy([],['weight' => 'asc']);
        foreach ($trainingsCategories as $category) {
            $menu['Courses']->addChild($category->getTitle(), [
                'route' => 'training_list',
                'routeParameters' => [
                    'slug' => $category->getSlug(),
                ]
            ]);
        }

        $menu['Courses']->addChild($this->translator->trans('Tailor-made'), [
            'route' => 'page_surmesure',
        ]);

        $menu->addChild('News', ['route' => 'news_listing']);
        $menu->addChild('Contact', ['route' => 'page_contact']);

        // Theming bootstrap
        $menu->setChildrenAttribute('class', 'navbar-nav');
        foreach ($menu as $child) {
            $child->setLinkAttribute('class', 'nav-link')
                ->setAttribute('class', 'nav-item');
        }

        $menu['Courses'] ->setAttributes([
            'class' => 'nav-item dropdown',
        ])
            ->setLinkAttributes([
                'class' => 'nav-link dropdown-toggle base-link',
                'data-toggle' => 'dropdown',
                'role' => 'button',
                'aria-expanded' => 'false',
                'data-bs-toggle' => "dropdown",
                'id' => 'courses_list'
            ])
            ->setChildrenAttributes([
                'class' => 'dropdown-menu',
                'aria-labelled-by' => 'courses_list'
            ])
        ;

        return $menu;
    }

    public function createSecondaryMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $pages = $this->pageManager->findPageForMenu('secondary');
        foreach ($pages as $page) {
            $menu->addChild($page->getTitle(), [
                'route' => 'page_detail',
                'routeParameters' => [
                    'slug' => $page->getSlug(),
                ]
            ]);
        }

        // Theming bootstrap
        $menu->setChildrenAttribute('class', 'navbar-nav');
        foreach ($menu as $child) {
            $child->setLinkAttribute('class', 'nav-link')
                ->setAttribute('class', 'nav-item');
        }

        return $menu;
    }

    public function createFooterMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Cap4 Group', ['uri' => 'https://www.cap4group.com/']);
        $menu['Cap4 Group']->setLinkAttribute('target', '_blank');

        $pages = $this->pageManager->findPageForMenu('footer');

        foreach ($pages as $page) {
            $menu->addChild($page->getTitle(), [
                'route' => 'page_detail',
                'routeParameters' => [
                    'slug' => $page->getSlug(),
                ]
            ]);
        }

        $menu->addChild('Contact', [
            'route' => 'page_contact',
        ]);

        // Theming bootstrap
        $menu->setChildrenAttribute('class', 'navbar-nav');
        foreach ($menu as $child) {
            $child->setLinkAttribute('class', 'nav-link')
                ->setAttribute('class', 'nav-item');
        }

        return $menu;
    }
}