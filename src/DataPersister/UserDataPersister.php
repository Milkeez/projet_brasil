<?php
namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements DataPersisterInterface
{
    private UserPasswordHasherInterface
    $passwordHasher;
    private EntityManagerInterface $entityManager;
    public function __construct(UserPasswordHasherInterface $passwordHasher,
    EntityManagerInterface $entityManager)

    {
    $this->passwordHasher= $passwordHasher;
    $this->entityManager = $entityManager;
    }
    public function supports($data): bool
    {
        return $data instanceof User;
    }
/**
*   @param User $data
*/
    public function persist($data)
    {
        $hashedPassword = $this->passwordHasher->hashPassword(
        $data,
        'passer'
        );
        $data->setPassword($hashedPassword);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}