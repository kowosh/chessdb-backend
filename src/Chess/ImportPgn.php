<?php declare(strict_types=1);

namespace App\Chess;

use App\Validator\Contraints\Pgn;
use Symfony\Component\Validator\Constraints\NotBlank;

class ImportPgn
{
    /**
     * @NotBlank(message="import.pgn.not_blank")
     * @Pgn(message="import.pgn.invalid")
     */
    private $pgnString;

    public function setPgnString(?string $pgnString)
    {
        $this->pgnString = $pgnString;
    }

    public function getPgnString(): ?string
    {
        return $this->pgnString;
    }
}
