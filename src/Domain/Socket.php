<?php

namespace App\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Datetime;

/**
 * Socket
 *
 * @ORM\Table(name="homedom.sockets")
 * @ORM\Entity
 */
class Socket
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=50, nullable=false)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="string", length=256, nullable=false)
	 */
	private $description;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Event", mappedBy="socket")
	 * @ORM\OrderBy({"time" = "ASC"})
	 */
	protected $events;

	public function __construct()
	{
		$this->events = new ArrayCollection();
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function setName(string $name)
	{
		$this->name = $name;

		return $this;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setDescription(string $description): self
	{
		$this->description = $description;

		return $this;
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	public function addEvent(Event $event): self
	{
		$this->events->add[] = $event;

		return $this;
	}

	public function removeEvent(Event $event): self
	{
		$this->events->removeElement($event);

		return $this;
	}

	public function getEvents(): ArrayCollection
	{
		return $this->events;
	}

	public function getNextEvent(int $time = null): ?Event
	{
		$time = $time ?? (int) ((new DateTime())->format('Hi'));
		$nextEvents = $this->getEvents()->filter(function(Event $event) use ($time) {
						return $event->getTime() > $time;
					});

		return $nextEvents->first() ?: $this->events->first();
	}

	public function getPreviousEvent(int $time = null): ?Event
	{
		$time = $time ?? (int) ((new DateTime())->format('Hi'));
		$prevEvents = $this->getEvents()->filter(function(Event $event) use ($time) {
						return $event->getTime() < $time;
					});

		return $prevEvents->last() ?: $this->events->last();
	}

	public function toArray(): array
	{
		return [
			'id' => $this->getId(),
			'name' => $this->getName(),
			'description' => $this->getDescription(),
			'events' => array_map(function($event) {
				return [
					'id' => $event->getId(),
					'operationName' => $event->getOperationName(),
					'time' => $event->getTime(),
					'timeString' => $event->getTimeString()
				];
			}, $this->events->toArray()),
			'nextEvent' => $this->getNextEvent() ? $this->getNextEvent()->toArray() : null,
			'previousEvent' => $this->getPreviousEvent() ? $this->getPreviousEvent()->toArray() : null,
		];
	}

	public function toJson(): string
	{
		return json_encode($this->toArray());
	}
}