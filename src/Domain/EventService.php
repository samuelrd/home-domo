<?php

namespace App\Domain;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Event;

final class EventService
{
    protected $em;
    protected $eventRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->eventRepository = $em->getRepository(Event::class);
    }

    public function findAll()
    {
        return $this->eventRepository->findAll();
    }

    public function find($id)
    {
        return $this->eventRepository->find($id);
    }

    public function findDue($time = null)
    {
        $time = $time ?? date('Hi');

        return $this->eventRepository->findBy(['time' => $time]);
    }

}