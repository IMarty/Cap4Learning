<?php

namespace App\Manager;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;

class TrainingManager extends ObjectManager
{
    public function findBySlug($slug = null, $locale = 'fr') {
        return $this->getRepository()->findBySlug($slug, $locale);
    }
}
