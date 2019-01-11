<?php declare(strict_types=1);

namespace App\Validator\Contraints;

use Symfony\Component\Validator\Constraint;

/** @Annotation */
class Pgn extends Constraint
{
    public $message = 'import.pgn.invalid';
}
