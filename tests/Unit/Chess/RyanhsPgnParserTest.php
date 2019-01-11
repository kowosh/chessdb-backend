<?php declare(strict_types=1);

namespace App\Tests\Unit\Chess;

use App\Chess\PgnParserInterface;
use App\Chess\RyanhsPgnParser;
use PHPUnit\Framework\TestCase;

class RyanhsPgnParserTest extends TestCase
{
    public function testParserImplementsParserInterface(): void
    {
        $parser = new RyanhsPgnParser();

        static::assertInstanceOf(PgnParserInterface::class, $parser);
    }
}
