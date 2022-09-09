<?php

namespace App\Domain;

use Doctrine\ORM\EntityManagerInterface;
use DateTime;

final class EventService
{
	private $em;
	private $eventRepository;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
		$this->eventRepository = $this->em->getRepository(Event::class);
	}

	public function findAll()
	{
		return $this->eventRepository->findAll();
	}

	public function find(int $id): ?Event
	{
		return $this->eventRepository->find($id);
	}

	public function findDue($time = null)
	{
		$time = $time ?? (int) ((new DateTime())->format('Hi'));

		return $this->eventRepository->findBy(['time' => $time]);
	}
}