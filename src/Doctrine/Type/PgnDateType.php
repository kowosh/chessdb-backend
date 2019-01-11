<?php declare(strict_types=1);

namespace App\Doctrine\Type;

use App\Chess\PgnDate;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class PgnDateType extends Type
{
    /**
     * @param PgnDate $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): PgnDate
    {
        return PgnDate::fromString($value);
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return 'TINYTEXT';
    }

    public function getName(): string
    {
        return 'pgn_date';
    }
}
