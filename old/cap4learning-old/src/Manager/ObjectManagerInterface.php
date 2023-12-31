<?php

namespace App\Manager;

use Psr\Log\LoggerInterface;

interface ObjectManagerInterface
{
    /**
     * Return the Logger.
     *
     * @return LoggerInterface
     */
    public function getLogger();

    /**
     * Return the Entity class name.
     *
     * @return string
     */
    public function getClass();

    /**
     * Find all entities in the repository.
     *
     * @return array
     */
    public function findAll();

    /**
     * Find entities by a set of criteria.
     *
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * Find a single entity by a set of criteria.
     *
     * @return object|null
     */
    public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param mixed $id The identifier
     *
     * @return object
     */
    public function find($id);

    /**
     * Create an empty Entity instance.
     *
     * @return object
     */
    public function create();

    /**
     * Save an Entity.
     *
     * @param object $entity   The Entity to save
     * @param bool   $andFlush Flush the EntityManager after saving the object?
     */
    public function save($entity, $andFlush = true);

    /**
     * Delete an Entity.
     *
     * @param object $entity   The Entity to delete
     * @param bool   $andFlush Flush the EntityManager after deleting the object?
     */
    public function delete($entity, $andFlush = true);
}
