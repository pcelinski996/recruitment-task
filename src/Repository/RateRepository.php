<?php

namespace App\Repository;

use App\Entity\Rate;
use Doctrine\ORM\EntityManagerInterface;

class RateRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Rate $newRate): void
    {
        $this->entityManager->persist($newRate);
        $this->entityManager->flush();
    }

    public function get(string $RateId): Rate
    {
        return $this->entityManager->getRepository(Rate::class)->find($RateId);
    }

    public function findAll()
    {
        return $this->entityManager->getRepository(Rate::class)->findAll();
    }
}