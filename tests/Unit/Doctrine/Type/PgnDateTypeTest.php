<?php declare(strict_types=1);

namespace App\Tests\Unit\Doctrine\Type;

use App\Chess\PgnDate;
use App\Doctrine\Type\PgnDateType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PgnDateTypeTest extends TestCase
{
    /** @var PgnDateType */
    private $type;
    /** @var AbstractPlatform|MockObject */
    private $platform;

    public static function setUpBeforeClass()
    {
        Type::addType('pgn_type', PgnDateType::class);
    }

    public function setUp()
    {
        $this->type = Type::getType('pgn_type');
        $this->platform = $this->createMock(AbstractPlatform::class);
    }

    public function testFactoryCreatesCorectType()
    {
        self::assertSame(PgnDateType::class, get_class($this->type));
    }

    public function testReturnsCorrectName()
    {
        self::assertSame('pgn_date', $this->type->getName());
    }

    /** @dataProvider providePgnDatesAndStrings */
    public function testConvertsToDatabaseValueWorks(PgnDate $asPgnDate, string $asString)
    {
        static::assertSame($asString, $this->type->convertToDatabaseValue($asPgnDate, $this->platform));
    }

    /** @dataProvider providePgnDatesAndStrings */
    public function testConvertsToPHPValueWorks(PgnDate $asPgnDate, string $asString)
    {
        static::assertEquals($asPgnDate, $this->type->convertToPHPValue($asString, $this->platform));
    }

    public function testSqlDeclarationIsCorrect()
    {
        static::assertSame('TINYTEXT', $this->type->getSQLDeclaration([], $this->platform));
    }

    public function providePgnDatesAndStrings()
    {
        yield [PgnDate::fromString('2000.01.03'), '2000.01.03'];
    }
}
