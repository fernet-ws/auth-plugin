<?php

namespace DoctrineFernet;

use Doctrine\ORM\EntityManager;

abstract class EntityRepository extends \Doctrine\ORM\EntityRepository
{
    abstract public function getEntity(): string;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata($this->getEntity())); 
    }
}

