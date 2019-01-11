<?php declare(strict_types=1);

namespace App\Chess;

interface PgnParserInterface
{
    public function parse(string $pgn): array;
    public function validate(string $pgn): bool;
}
