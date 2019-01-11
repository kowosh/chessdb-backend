<?php declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserRegistrationHandler
{
    private $repository;
    private $encoders;
    private $validator;

    public function __construct(
        UserRepository $repository,
        EncoderFactoryInterface $encoders,
        ValidatorInterface $validator
    ) {
        $this->repository = $repository;
        $this->encoders = $encoders;
        $this->validator = $validator;
    }

    public function handle(UserRegistration $dto): void
    {
        $violations = $this->validator->validate($dto);

        if ($violations->count() > 0) {
            throw new \InvalidArgumentException(sprintf('Invalid User registration object'));
        }

        $user = new User(
            (string)$dto->getUsername(),
            (string)$dto->getEmail(),
            $this->encoders->getEncoder(User::class)->encodePassword($dto->getPassword(), $dto->getSalt())
        );

        $this->repository->persist($user);
    }
}
