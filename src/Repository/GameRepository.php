<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class GameRepository
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist(Game $game, bool $flush = true): void
    {
        $this->entityManager->persist($game);

        $flush && $this->entityManager->flush();
    }

    public function find(string $id): Game
    {
        return $this->getRepository()->find($id);
    }

    public function findAll(): array
    {
        return $this->getRepository()->findAll();
    }

    public function count(): int
    {
        return count($this->getRepository()->findAll());
    }

    public function delete(string $id, bool $flush = true): void
    {
        $game = $this->find($id);
        $this->entityManager->remove($game);

        $flush && $this->entityManager->flush();
    }

    private function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Game::class);
    }
}
