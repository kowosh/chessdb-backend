<?php declare(strict_types=1);

namespace App\Entity;

use App\Chess\PgnDate;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Entity()
 */
class Game
{
    /**
     * @Id()
     * @Column(type="uuid", unique=true)
     * @GeneratedValue(strategy="CUSTOM")
     * @CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @Column()
     * @Assert\NotBlank(message="game.event.not_blank")
     */
    private $event;

    /**
     * @Column()
     * @Assert\NotBlank(message="game.site.not_blank")
     */
    private $site;

    /**
     * @Column(type="pgn_date")
     * @Assert\NotBlank(message="game.date.not_blank")
     */
    private $date;

    /**
     * @Column()
     * @Assert\NotBlank(message="game.round.not_blank")
     */
    private $round;

    /**
     * @Column()
     * @Assert\NotBlank(message="game.white.not_blank")
     */
    private $white;

    /**
     * @Column()
     * @Assert\NotBlank(message="game.black.not_blank")
     */
    private $black;

    /**
     * @Column()
     * @Assert\NotBlank(message="game.result.not_blank")
     * @Assert\Choice({"1-0", "0-1", "1/2-1/2", "*"}, message="game.result.choice")
     */
    private $result;

    /**
     * @Column(type="simple_array")
     * @Assert\NotBlank(message="game.moves.not_blank")
     */
    private $moves;

    public function __construct(
        string $event,
        string $site,
        PgnDate $date,
        string $round,
        string $white,
        string $black,
        string $result,
        array $moves
    ) {
        $this->event = $event;
        $this->site = $site;
        $this->date = $date;
        $this->round = $round;
        $this->white = $white;
        $this->black = $black;
        $this->result = $result;
        $this->moves = $moves;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getSite(): string
    {
        return $this->site;
    }

    public function getDate(): PgnDate
    {
        return $this->date;
    }

    public function getRound(): string
    {
        return $this->round;
    }

    public function getWhite(): string
    {
        return $this->white;
    }

    public function getBlack(): string
    {
        return $this->black;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function getMoves(): array
    {
        return $this->moves;
    }

    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    public function setSite(string $site): void
    {
        $this->site = $site;
    }

    public function setDate(PgnDate $date): void
    {
        $this->date = $date;
    }

    public function setRound(string $round): void
    {
        $this->round = $round;
    }

    public function setWhite(string $white): void
    {
        $this->white = $white;
    }

    public function setBlack(string $black): void
    {
        $this->black = $black;
    }

    public function setResult(string $result): void
    {
        $this->result = $result;
    }

    public function setMoves(array $moves): void
    {
        $this->moves = $moves;
    }

    public function getPgn(): string
    {
        $format = <<<EOF
[Event "%s"]
[Site "%s"]
[Date "%s"]
[Round "%s"]
[Result "%s"]
[White "%s"]
[Black "%s"]

%s %s
EOF;

        return sprintf(
            $format,
            $this->getEvent(),
            $this->getSite(),
            $this->getDate()->toString(),
            $this->getRound(),
            $this->getResult(),
            $this->getWhite(),
            $this->getBlack(),
            $this->moveArrayToString($this->getMoves()),
            $this->getResult()
        );
    }

    private function moveArrayToString(array $moves): string
    {
        $movesString = '';
        $moveCounter = 1;

        foreach ($moves as $key => $move) {
            if (0 === $key % 2) {
                $movesString = $movesString.$moveCounter.'.';
                $moveCounter++;
            }

            $movesString = $movesString.$move.' ';
        }

        return trim($movesString);
    }
}
