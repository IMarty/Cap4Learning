<?php

namespace App\Utils;

use App\Manager\ObjectManagerInterface;
use Doctrine\ORM\EntityManager;
use Sonata\Doctrine\Model\ManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class Paginator {
    // Request
    private $request;
    // EntityManager
    private $manager;
    // Entity name of the database table
    private $filters;
    // Number of records per page
    private $pageSize;
    // Current page number
    private $currentPage;
    // Total number of pages
    private $totalPages;
    // Total records
    private $totalRecords;
    // Offset of the current page for db table
    private $offset;
    // Sort field
    private $sortField;

    private $defaultSortType;

    public function __construct(Request $request, ObjectManagerInterface $manager, array $filters, $default_sort_field = null, $page_size = 20, $default_sort_type = 'ASC') {
        $this->request = $request;
        $this->manager = $manager;
        $this->filters = $filters;
        $this->sortField = $default_sort_field;
        $this->defaultSortType = $default_sort_type;
        $this->pageSize = $page_size;
        $this->totalRecords = $this->getTotal();
        $this->setCurrentPage();
    }

    /**
     * Get the total number of records
     */
    private function getTotal() {
        $total = $this->manager->getRepository()
            ->createQueryBuilder('model')
            ->select('count(DISTINCT model.id)')
        ;

        $total = $this->prepareQuery($total);

        $total = $total
            ->getQuery()
            ->getSingleScalarResult();

        return $total;
    }

    /**
     * Set the current page and total number of pages
     */
    private function setCurrentPage() {
        $this->currentPage = $this->request->get('page');
        if(empty($this->currentPage)) {
            $this->currentPage = 1;
        }
        $this->totalPages = ceil($this->totalRecords/$this->pageSize);
        if(($this->currentPage * $this->pageSize) > $this->totalRecords) {
            $this->currentPage = $this->totalPages;
        }
        // Offset for db table
        if($this->currentPage > 1) {
            $this->offset = ($this->currentPage - 1) * $this->pageSize;
        } else {
            $this->offset = 0;
        }
    }

    /**
     * Get the records for the current page
     */
    public function getRecords() {

        $records = $this->manager->getRepository()->createQueryBuilder('model');

        $records = $this->prepareQuery($records);

        if (isset($this->sortField)) {
            $records = $records->addSelect('CASE WHEN '.$this->sortField.' IS NULL THEN 0 ELSE 1 END as HIDDEN priority_is_null');
            $records = $records->addOrderBy('priority_is_null', 'DESC');
            $records = $records->addOrderBy($this->sortField, $this->defaultSortType);
        }

        $records = $records
            ->groupBy("model.id")
            ->setFirstResult($this->offset)
            ->setMaxResults($this->pageSize)
            ->getQuery()
            ->getResult();

        return $records;
    }

    public function prepareQuery($query)
    {
        // Make the join with translations
        if (null !== $this->manager->getRepository()->getTranslationNameDoctrine()) {
            $query = $query->leftJoin(
                $this->manager->getRepository()->getTranslationNameDoctrine(),
                'translation',
                'WITH',
                'model.id = translation.translatable'
            );
        }

        // Create the join with model entities references
        $joins = [];
        foreach ($this->filters as $key => $filter) {
            if (isset($filter['dataModel']) && !(empty($filter['dataModel']))) {
                $alreadyIn = false;
                foreach ($joins as $join) {
                    if ($join['model'] == $filter['dataModel']['model']) {
                        $alreadyIn = true;
                    }
                }
                if (!$alreadyIn) {
                    $joins[] = $filter['dataModel'];
                }
            }
        }

        foreach ($joins as $join) {
            $query = $query->leftJoin(
                $join['model'],
                $join['modelKey'],
                'WITH',
                $join['joinCondition']
            );

            if (isset($join['modelTranslation']) && !empty($join['modelTranslation'])) {
                $query = $query->leftJoin(
                    $join['modelTranslation'],
                    $join['modelTranslationKey'],
                    'WITH',
                    $join['modelKey'].'.id = '.$join['modelTranslationKey'].'.translatable'
                );
            }
        }

        $keywordsSearch = [];
        $keywordsParameters = [];
        if(!empty($this->filters)) {
            foreach($this->filters as $key => $parameters) {
                if (isset($parameters['isKeywordSearch']) && $parameters['isKeywordSearch'] === true) {
                    // Prepare query "and" with multiple "or" for keywords search
                    if (isset($parameters['dataModel']) && !empty($parameters['dataModel'])) {
                        // No check translatable because condition is already made in definition filter (controller side)
                        $keywordsSearch[] = $parameters['dataModel']['fieldCompared']. ' '.$parameters['SQLComparison']. ' :field_'.$key;
                    } else {
                        // Prepare condition between direct field and model switching if translatable or not
                        if ($parameters['translatable'] === true) {
                            $keywordsSearch[] = "translation.{$key} ".$parameters['SQLComparison']." :field_{$key}";
                        } else {
                            $keywordsSearch[]  = "model.{$key} ".$parameters['SQLComparison']." :field_{$key}";
                        }
                    }
                    $keywordsParameters['field_'.$key] = $parameters['value'];
                } else {
                    // Directly "and" condition, so we can directly set the query itself
                    if ($parameters['translatable'] === true) {
                        $query = $query->andWhere();
                        $query = $query->setParameter('field_'.$key, $parameters['value']);
                    } else {
                        $query = $query->andWhere("model.{$key} ".$parameters['SQLComparison']." :field_{$key}");
                        $query = $query->setParameter('field_'.$key, $parameters['value']);
                    }
                }
            }

            // Create the andwhere with multipleOr
            if (count($keywordsSearch)) {
                $keywordsString = implode(' OR ', $keywordsSearch);
                $query = $query->andWhere($keywordsString);
                foreach ($keywordsParameters as $key => $parameter) {
                    $query = $query->setParameter($key, $parameter);
                }
            }
        }

        return $query;
    }

    /**
     * Get the parameters for the page display
     */
    public function getDisplayParameters() {
        $return = array(
            'current_page' => $this->currentPage,
            'total_pages' => $this->totalPages,
        );
        return $return;
    }
}
