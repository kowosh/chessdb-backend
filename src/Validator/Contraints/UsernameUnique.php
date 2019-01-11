<?php declare(strict_types=1);

namespace App\Validator\Contraints;

use Symfony\Component\Validator\Constraint;

/** @Annotation */
class UsernameUnique extends Constraint
{
    public $message = 'username.unique';
}
