<?php

namespace App;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

use function App\functions\withJson;

class UserController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Response $response): Response
    {
        $users = $this->userRepository->findAll();

        return withJson($response, $users);
    }

    public function show(Response $response, $id): Response
    {
        $user = $this->userRepository->find($id);

        if ($user === null) {
            return withJson($response->withStatus(404), ['message' => 'User not found']);
        }

        return withJson($response, $user);
    }

    public function store(Request $request, Response $response)
    {
        ['name' => $name] = $request->getParsedBody();

        $this->userRepository->create($name);
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response)
    {
        $name = $request->getAttribute('name');

        var_dump($name);
        return $response->withStatus(204);
    }

    public function destroy(Response $response)
    {
        return $response->withStatus(204);
    }
}