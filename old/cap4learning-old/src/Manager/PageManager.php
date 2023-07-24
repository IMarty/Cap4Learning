<?php

namespace App\Manager;

use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;

class PageManager extends ObjectManager
{
    public function findBySlug($slug = null, $locale = 'fr') {
        return $this->getRepository()->findBySlug($slug, $locale);
    }

    public function findPageForMenu($menu = 'footer') {
        return $this->getRepository()->findBy([
            'menu' => $menu,
            'published' => true,
        ]);
    }
}
