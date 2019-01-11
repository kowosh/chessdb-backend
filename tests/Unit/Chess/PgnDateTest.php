<?php declare(strict_types=1);

namespace App\Tests\Unit\Chess;

use App\Chess\PgnDate;
use PHPUnit\Framework\TestCase;

class PgnDateTest extends TestCase
{
    /** @dataProvider pgnDateProvider */
    public function testCreateNewPgnDate(string $dateString, ?int $year, ?int $month, ?int $day): void
    {
        $pgnDate = PgnDate::fromString($dateString);
        static::assertSame($year, $pgnDate->getYear());
        static::assertSame($month, $pgnDate->getMonth());
        static::assertSame($day, $pgnDate->getDay());
        static::assertSame($dateString, $pgnDate->toString());
    }

    /** @dataProvider invalidPgnDateProvider */
    public function testInvalidDateFormats(string $invalidDateString): void
    {
        $this->expectException(\InvalidArgumentException::class);
        PgnDate::fromString($invalidDateString);
    }

    public function pgnDateProvider()
    {
        yield ['1992.02.31', 1992, 2, 31];
        yield ['1992.02.01', 1992, 2, 1];
        yield ['1992.12.13', 1992, 12, 13];
        yield ['1992.12.??', 1992, 12, null];
        yield ['1992.??.13', 1992, null, 13];
        yield ['????.12.13', null, 12, 13];
        yield ['????.??.13', null, null, 13];
        yield ['????.??.??', null, null, null];
    }

    public function invalidPgnDateProvider()
    {
        yield ['blafoo'];
        yield ['bla.foo.da'];
        yield ['bla.foo.31'];
        yield ['bla.23.31'];
        yield ['1234.23.31'];
        yield ['1234-23-31'];
        yield ['1234.23.31'];
        yield ['1992.13.32'];
        yield ['1992.12.32'];
        yield ['1992.13.32'];
        yield ['1992.13.-32'];
        yield ['1992.-13.32'];
        yield ['1992.13.32'];
    }
}
