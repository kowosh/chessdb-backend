<?php declare(strict_types=1);

namespace App\Chess;

use Ryanhs\Chess\Chess;

class RyanhsPgnParser implements PgnParserInterface
{
    public function parse(string $pgn): array
    {
        return Chess::parsePgn($pgn);
    }

    public function validate(string $pgn): bool
    {
        return Chess::validatePgn($pgn);
    }
}
