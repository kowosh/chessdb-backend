<?php declare(strict_types=1);

namespace App\Validator\Contraints;

use App\Chess\PgnParserInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PgnValidator extends ConstraintValidator
{
    private $chess;

    public function __construct(PgnParserInterface $chess)
    {
        $this->chess = $chess;
    }

    /**
     * @param mixed $value
     * @param Pgn $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (empty($value)) {
            return;
        }

        if (!$this->chess->validate($value)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
