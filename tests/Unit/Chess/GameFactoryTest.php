<?php declare(strict_types=1);

namespace App\Tests\Unit\Chess;

use App\Chess\GameFactory;
use App\Chess\ImportPgn;
use App\Chess\PgnDate;
use App\Chess\PgnParserInterface;
use App\Tests\PgnFixtureTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GameFactoryTest extends TestCase
{
    use PgnFixtureTrait;

    public function testCreationOfNewGameFromValidPgn()
    {
        /** @var PgnParserInterface|MockObject $parserMock */
        $parserMock = $this->createMock(PgnParserInterface::class);
        $parserMock->method('parse')->willReturn(
            [
                'header' => [
                    'Event' => 'event',
                    'Site' => 'site',
                    'Date' => '2000.01.25',
                    'Round' => '4',
                    'White' => 'white player',
                    'Black' => 'black player',
                    'Result' => '1-0',
                ],
                'moves' => [
                    'e4',
                    'd5',
                    'exd5',
                ],
            ]
        );

        $gameFactory = new GameFactory($parserMock);
        $importPgn = new ImportPgn();
        $importPgn->setPgnString($this->validPgn());

        $resultGame = $gameFactory->createFromImportPgn($importPgn);

        static::assertSame('event', $resultGame->getEvent());
        static::assertSame('site', $resultGame->getSite());
        static::assertEquals(PgnDate::fromString('2000.01.25'), $resultGame->getDate());
        static::assertSame('4', $resultGame->getRound());
        static::assertSame('white player', $resultGame->getWhite());
        static::assertSame('black player', $resultGame->getBlack());
        static::assertSame('1-0', $resultGame->getResult());
        static::assertSame(['e4', 'd5', 'exd5'], $resultGame->getMoves());
    }
}
