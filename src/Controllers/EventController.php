<?php

namespace App\Controllers;

use App\Domain\Event;
use App\Domain\Socket;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class EventController
{
	protected $em;
	protected $view;

	public function __construct(EntityManagerInterface $em, Twig $view) {
		$this->em = $em;
		$this->view = $view;
	}

	public function list(Request $request, Response $response, $args)
	{
		$allEvents = $this->em->getRepository(Event::class)->findAll();
		$events = array_map(function($event) { return $event->toArray(); }, $allEvents);
		$response->getBody()->write(json_encode($events));

		return $response->withHeader('Content-Type', 'application/json');
	}

	public function get(Request $request, Response $response, $args)
	{
		$event = $this->em->getRepository(Event::class)->find($args['id']);
		$response->getBody()->write($event->toJson());

		return $response->withHeader('Content-Type', 'application/json');
	}

	public function store(Request $request, Response $response, $args)
	{
		$data = $request->getParsedBody();
		$socket = $this->em->getRepository(Socket::class)->find($data['socket_id']);
		$operationName = $data['operation_name'];
		$time = $data['time'];

		// TODO validate

		$event = new Event();
		$event->setSocket($socket)
			->setOperationName($operationName)
			->setTime($time)
		;
		$socket->addEvent($event);
		$this->em->persist($event);
		$this->em->persist($socket);
		$this->em->flush();
		$response->getBody()->write($event->toJson());

		return $response->withHeader('Content-Type', 'application/json');
	}

	public function update(Request $request, Response $response, $args)
	{
		$data = $request->getParsedBody();
		$eventId = $args['id'];
		$operationName = $data['operation_name'];
		$time = $data['time'];

		// TODO validate

		$event = $this->em->getRepository(Event::class)->find($eventId);
		$event->setOperationName($operationName)->setTime($time);
		$this->em->persist($event);
		$this->em->flush();
		$response->getBody()->write($event->toJson());

		return $response->withHeader('Content-Type', 'application/json');
	}

	public function delete(Request $request, Response $response, $args)
	{
		$eventId = $args['id'];

		// TODO validate

		$event = $this->em->getRepository(Event::class)->find($eventId);
		$this->em->remove($event);
		$this->em->flush();
		$response->getBody()->write(json_encode(['message' => 'event successfully deleted']));

		return $response->withHeader('Content-Type', 'application/json');
	}

	public function edit(Request $request, Response $response, $args)
	{
		$eventId = $args['id'] ?? false;
		// TODO validate
		$event = $eventId ? $this->em->getRepository(Event::class)->find($eventId) : null;

		return $this->view->render($response, 'forms/eventForm.twig', ['event' => $event]);
	}
}