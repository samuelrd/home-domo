<?php

namespace App\Controllers;

use App\Domain\Socket;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class SocketController
{
	protected $em;
	protected $view;

	public function __construct(EntityManagerInterface $em, Twig $view) {
		$this->em = $em;
		$this->view = $view;
	}

	public function list(Request $request, Response $response, $args)
	{
		$allSockets = $this->em->getRepository(Socket::class)->findAll();
		$sockets = array_map(function($socket) { return $socket->toArray(); }, $allSockets);
		$response->getBody()->write(json_encode($sockets));

		return $response->withHeader('Content-Type', 'application/json');
	}

	public function get(Request $request, Response $response, $args)
	{
		$socket = $this->em->getRepository(Socket::class)->find($args['id']);
		$response->getBody()->write($socket->toJson());

		return $response->withHeader('Content-Type', 'application/json');
	}

	public function store(Request $request, Response $response, $args)
	{
		$data = $request->getParsedBody();
		$name = $data['name'];
		$description = $data['description'];

		// TODO validate

		$socket = new Socket();
		$socket->setName($name)->setDescription($description);
		$this->em->persist($socket);
		$this->em->flush();
		$response->getBody()->write($socket->toJson());

		return $response->withHeader('Content-Type', 'application/json');
	}

	public function update(Request $request, Response $response, $args)
	{
		$data = $request->getParsedBody();
		$socketId = $args['id'];
		$name = $data['name'];
		$description = $data['description'];

		// TODO validate

		$socket = $this->em->getRepository(Socket::class)->find($socketId);
		$socket->setName($name)->setDescription($description);
		$this->em->persist($socket);
		$this->em->flush();
		$response->getBody()->write($socket->toJson());

		return $response->withHeader('Content-Type', 'application/json');
	}

	public function delete(Request $request, Response $response, $args)
	{
		$socketId = $args['id'];

		// TODO
		// validate
		// delete all linked events

		$socket = $this->em->getRepository(Socket::class)->find($socketId);
		$this->em->remove($socket);
		$this->em->flush();
		$response->getBody()->write(json_encode(['message' => 'socket successfully deleted']));

		return $response->withHeader('Content-Type', 'application/json');
	}

	public function edit(Request $request, Response $response, $args)
	{
		$socketId = $args['id'] ?? false;
		// TODO validate
		$socket = $socketId ? $this->em->getRepository(Socket::class)->find($socketId) : null;

		return $this->view->render($response, 'forms/socketForm.twig', ['socket' => $socket]);
	}

	public function editEvents(Request $request, Response $response, $args)
	{
		$socketId = $args['id'] ?? false;
		// TODO validate
		$socket = $socketId ? $this->em->getRepository(Socket::class)->find($socketId) : null;

		return $this->view->render($response, 'forms/eventEditForm.twig', ['socket' => $socket]);
	}
}