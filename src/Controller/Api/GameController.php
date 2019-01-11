<?php declare(strict_types=1);

namespace App\Controller\Api;

use App\Chess\GameFactory;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/** @Route("/games", name="game_") */
class GameController
{
    private $repository;
    private $normalizer;
    private $router;
    private $gameFactory;

    public function __construct(
        GameRepository $repository,
        NormalizerInterface $normalizer,
        UrlGeneratorInterface $router,
        GameFactory $gameFactory
    ) {
        $this->repository = $repository;
        $this->normalizer = $normalizer;
        $this->router = $router;
        $this->gameFactory = $gameFactory;
    }

    /** @Route("/", name="list", methods={"GET"}) */
    public function list()
    {
        return $this->createJsonResponse(
            array_merge(
                [
                    'games' =>
                        array_map(
                            function ($game) {
                                return $this->normalizer->normalize($game, 'api');
                            },
                            $this->repository->findAll()
                        ),
                ],
                [
                    '_links' => [
                        '_self' => $this->router->generate(
                            'api_game_list',
                            [],
                            UrlGeneratorInterface::ABSOLUTE_URL
                        ),
                    ],
                ]
            )
        );
    }

    /** @Route("/count", name="count", methods={"GET"}) */
    public function count()
    {
        return $this->createJsonResponse(['count' => $this->repository->count()]);
    }

    /** @Route("/{id}", name="show", methods={"GET"}) */
    public function show(string $id)
    {
        $game = $this->repository->find($id);

        return $this->createJsonResponse($this->normalizer->normalize($game, 'api'));
    }

    /** @Route("/", name="add", methods={"POST"}) */
    public function add(Request $request)
    {
        $game = $this->gameFactory->createFromPgnString($request->getContent());
        $this->repository->persist($game);

        return $this->createJsonResponse(
            null,
            201,
            [
                'Location' => $this->router->generate(
                    'api_game_show',
                    ['id' => $game->getId()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
            ]
        );
    }

    /** @Route("/{id}", name="edit", methods={"PUT"}) */
    public function edit(string $id, Request $request)
    {
        $original = $this->repository->find($id);
        $sent = $this->gameFactory->createFromPgnString($request->getContent());

        $original->setEvent($sent->getEvent());
        $original->setSite($sent->getSite());
        $original->setDate($sent->getDate());
        $original->setRound($sent->getRound());
        $original->setWhite($sent->getWhite());
        $original->setBlack($sent->getBlack());
        $original->setResult($sent->getResult());
        $original->setMoves($sent->getMoves());

        $this->repository->persist($original);

        return $this->createJsonResponse();
    }

    /** @Route("/{id}", name="delete", methods={"DELETE"}) */
    public function delete(string $id)
    {
        $this->repository->delete($id);

        return $this->createJsonResponse();
    }

    private function createJsonResponse($content = null, int $statusCode = 200, array $headers = [])
    {
        return new JsonResponse(
            $content, $statusCode, array_merge(
                [
                    'Access-Control-Allow-Origin' => '*',
                ],
                $headers
            )
        );
    }


}

