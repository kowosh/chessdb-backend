<?php declare(strict_types=1);

namespace App\Validator\Contraints;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UsernameUniqueValidator extends ConstraintValidator
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param mixed $value
     * @param UsernameUnique $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (empty($value)) {
            return;
        }

        if (null !== $this->repository->loadUserByUsername((string) $value)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
