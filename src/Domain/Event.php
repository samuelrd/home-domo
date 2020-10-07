<?php

namespace App\Domain;

use App\Domain\Socket;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="homedom.events")
 * @ORM\Entity
 */
class Event
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	protected $id;

    /**
     * @var Socket
     * 
     * @ORM\ManyToOne(targetEntity="Socket", inversedBy="events")
     * @ORM\JoinColumn(name="socket_id", referencedColumnName="id")
     */
    protected $socket;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="socket_operation", type="string", length=10, nullable=false)
	 */
	protected $operationName;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="time", type="integer", nullable=false)
	 */
	protected $time;

	/**
	 * Get the value of id
	 *
	 * @return integer
	 */ 
	public function getId()
	{
		return $this->id;
	}

    /**
     * Get the value of socket
     *
     * @return Socket
     */ 
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * Set the value of socket
     *
     * @param Socket $socket
     *
     * @return self
     */ 
    public function setSocket(Socket $socket)
    {
        $this->socket = $socket;

        return $this;
    }

	/**
	 * Get the value of operationName
	 *
	 * @return string
	 */ 
	public function getOperationName()
	{
		return $this->operationName;
	}

	/**
	 * Set the value of operationName
	 *
	 * @param string $operationName
	 *
	 * @return self
	 */ 
	public function setOperationName(string $operationName)
	{
		$this->operationName = $operationName;

		return $this;
	}

	/**
	 * Get the value of time
	 *
	 * @return integer
	 */ 
	public function getTime()
	{
		return $this->time;
	}

	/**
	 * Set the value of time
	 *
	 * @param integer $time
	 *
	 * @return self
	 */ 
	public function setTime($time)
	{
		$this->time = $time;

		return $this;
	}

	public function getHours()
    {
        return intval($this->time / 100);
    }

    public function getMinutes()
    {
        return $this->time % 100;
	}
	
	public function getTimeString()
    {
		$hoursString = substr("00{$this->getHours()}", -2, 2);
		$minutesString = substr("00{$this->getMinutes()}", -2, 2);
        return "{$hoursString}:{$minutesString}";
	}

	public function toArray()
	{
		return [
			"id" => $this->id,
			"socket" => [
				"id" => $this->socket->getId(),
				"name" => $this->socket->getName(),
				"description" => $this->socket->getDescription()
			],
			"operationName" => $this->getOperationName(),
			"time" => $this->getTime(),
			"timeString" => $this->getTimeString()
		];
	}

	public function toJson()
	{
		return json_encode($this->toArray());
	}
}