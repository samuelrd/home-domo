<?php

namespace App\Domain;

use App\Domain\Event;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

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

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Set name
	 *
	 * @param integer $name
	 *
	 * @return Socket
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return integer
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set description
	 *
	 * @param integer $description
	 *
	 * @return Socket
	 */
	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * Get description
	 *
	 * @return integer
	 */
	public function getDescription()
	{
		return $this->description;
	}

    /**
     * Add Event
     *
     * @return Event
     */
    public function addEvent(Event $event)
    {
        $this->events->add[] = $event;

        return $this;
    }

    /**
     * Remove Event
     */
    public function removeEvent(Event $event): void
    {
        $this->events->removeElement($event);
    }

    /**
     * Get the value of events
     *
     * @return ArrayCollection
     */ 
    public function getEvents()
    {
        return $this->events;
	}

	public function getNextEvent($time = null)
	{
		$time = $time ?? intval((new DateTime())->format('Hi'));
		$nextEvents = $this->getEvents()->filter(function(Event $event) use ($time){
						return $event->getTime() > $time;
					});

		return $nextEvents->first() ?: $this->events->first();
	}
	
	public function getPreviousEvent($time = null)
	{
		$time = $time ?? intval((new DateTime())->format('Hi'));
		$prevEvents = $this->getEvents()->filter(function(Event $event) use ($time){
						return $event->getTime() < $time;
					});
		return $prevEvents->last() ?: $this->events->last();
	}
	
	public function toArray()
	{
		return [
			"id" => $this->getId(),
			"name" => $this->getName(),
			"description" => $this->getDescription(),
			"events" => array_map(function($event){
				return [
					"id" => $event->getId(),
					"operationName" => $event->getOperationName(),
					"time" => $event->getTime(),
					"timeString" => $event->getTimeString()
				];
			}, $this->events->toArray()),
			"nextEvent" => $this->getNextEvent()->toArray(),
			"previousEvent" => $this->getPreviousEvent()->toArray(),
		];
	}

	public function toJson()
	{
		return json_encode($this->toArray());
	}
}