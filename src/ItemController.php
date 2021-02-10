<?php

namespace App;

use App\Entities\Item;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

use function App\functions\withJson;

class ItemController
{
    private ItemRepository $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function index(Response $response): Response
    {
        $items = $this->itemRepository->findAll();
        return withJson($response, [
            'items' => array_map(fn(Item $item) => [
                'id' => $item->getId(),
                'title' => $item->getTitle(),
            ], $items)
        ]);
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $item = $this->itemRepository->create($data);

        return withJson($response, ['id' => $item->getId()])->withStatus(201);
    }
}