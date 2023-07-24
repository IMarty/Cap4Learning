<?php

namespace App\Manager;

use Doctrine\Common\Persistence\ObjectManager as DoctrineManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

abstract class ObjectManager implements ObjectManagerInterface
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $objectManager;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param string          $class
     * @param DoctrineManager $objectManager
     * @param LoggerInterface $logger
     */
    public function __construct($class, EntityManagerInterface $objectManager, LoggerInterface $logger = null)
    {
        $this->class = $class;
        $this->objectManager = $objectManager;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new $this->class();
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * Returns the related Object Repository.
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository()
    {
        return $this->getObjectManager()->getRepository($this->class);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->getRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    public function findOneById($id)
    {
        return $this->getRepository()->findOneBy(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public function save($entity, $andFlush = true)
    {
        $this->checkObject($entity);

        $this->getObjectManager()->persist($entity);

        if ($andFlush) {
            $this->getObjectManager()->flush();
        }
    }

    /**
     * @param $object
     *
     * @throws \InvalidArgumentException
     */
    protected function checkObject($object)
    {
        if (!$object instanceof $this->class) {
            throw new \InvalidArgumentException(sprintf('Object must be instance of %s, %s given', $this->class, is_object($object) ? get_class($object) : gettype($object)));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete($entity, $andFlush = true)
    {
        $this->checkObject($entity);

        $this->getObjectManager()->remove($entity);

        if ($andFlush) {
            $this->getObjectManager()->flush();
        }
    }
}
