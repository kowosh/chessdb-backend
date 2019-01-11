<?php declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Game;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class GameApiNormalizer implements NormalizerInterface
{
    private $routing;

    public function __construct(UrlGeneratorInterface $routing)
    {
        $this->routing = $routing;
    }

    /**
     * @param Game $object
     * @param null $format
     * @param array $context
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'id' => $object->getId(),
            'event' => $object->getEvent(),
            'site' => $object->getSite(),
            'date' => $object->getDate(),
            'round' => $object->getRound(),
            'white' => $object->getWhite(),
            'black' => $object->getBlack(),
            'result' => $object->getResult(),
            'moves' => $object->getMoves(),
            'pgn' => $object->getPgn(),
            '_links' => [
                '_self' => $this->routing->generate(
                    'api_game_show',
                    ['id' => $object->getId()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
            ],
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return ($data instanceof Game) && 'api' === $format;
    }
}
