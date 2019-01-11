<?php declare(strict_types=1);

namespace App\Chess;

class PgnDate
{
    private $year;
    private $month;
    private $day;

    private function __construct(?int $year, ?int $month, ?int $day)
    {
        $this->setYear($year);
        $this->setMonth($month);
        $this->setDay($day);
    }

    public static function fromString(string $dateString): self
    {
        $regex = '/([\d\?]{4})\.([\d\?]{2})\.([\d\?]{2})/';

        if (!preg_match($regex, $dateString, $matches)) {
            throw new \InvalidArgumentException(sprintf('the string "%s" is not a valid pgn date.', $dateString));
        }

        return new self(
            (int)$matches[1] === 0 ? null : (int)$matches[1],
            (int)$matches[2] === 0 ? null : (int)$matches[2],
            (int)$matches[3] === 0 ? null : (int)$matches[3]
        );
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): void
    {
        $this->year = $year;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(?int $month): void
    {
        if ($month > 12 || $month < 0) {
            throw new \InvalidArgumentException(sprintf('given month "%s" is not valid', $month));
        }

        $this->month = $month;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(?int $day): void
    {
        if ($day > 31) {
            throw new \InvalidArgumentException(sprintf('given day "%s" is not valid', $day));
        }

        $this->day = $day;
    }

    public function toString(): string
    {
        return sprintf(
            '%s.%s.%s',
            $this->getYear() ? sprintf("%'04d", $this->getYear()) : '????',
            $this->getMonth() ? sprintf("%'02d", $this->getMonth()) : '??',
            $this->getDay() ? sprintf("%'02d", $this->getDay()) : '??'
        );
    }
}
