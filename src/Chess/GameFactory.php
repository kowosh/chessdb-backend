<?php declare(strict_types=1);

namespace App\Chess;

use App\Entity\Game;

class GameFactory
{
    private $parser;

    public function __construct(PgnParserInterface $parser)
    {
        $this->parser = $parser;
    }

    public function createFromImportPgn(ImportPgn $importPgn): Game
    {
        return $this->createFromPgnString($importPgn->getPgnString());
    }

    public function createFromPgnString(string $pgnString)
    {
        $info = $this->parser->parse($pgnString);

        return new Game(
            $info['header']['Event'],
            $info['header']['Site'],
            PgnDate::fromString($info['header']['Date']),
            $info['header']['Round'],
            $info['header']['White'],
            $info['header']['Black'],
            $info['header']['Result'],
            $info['moves']
        );
    }
}
