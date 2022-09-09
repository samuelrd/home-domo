<?php

namespace App\Domain;

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

	public function getId(): int
	{
		return $this->id;
	}

	public function getSocket(): Socket
	{
		return $this->socket;
	}

	public function setSocket(Socket $socket): self
	{
		$this->socket = $socket;

		return $this;
	}

	public function getOperationName(): string
	{
		return $this->operationName;
	}

	public function setOperationName(string $operationName): self
	{
		$this->operationName = $operationName;

		return $this;
	}

	public function getTime(): int
	{
		return $this->time;
	}

	public function setTime(int $time): self
	{
		$this->time = $time;

		return $this;
	}

	public function getHours(): int
	{
		return (int) ($this->time / 100);
	}

	public function getMinutes(): int
	{
		return $this->time % 100;
	}

	public function getTimeString(): string
	{
		$hoursString = substr("00{$this->getHours()}", -2, 2);
		$minutesString = substr("00{$this->getMinutes()}", -2, 2);

		return "{$hoursString}:{$minutesString}";
	}

	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'socket' => [
				'id' => $this->socket->getId(),
				'name' => $this->socket->getName(),
				'description' => $this->socket->getDescription()
			],
			'operationName' => $this->getOperationName(),
			'time' => $this->getTime(),
			'timeString' => $this->getTimeString()
		];
	}

	public function toJson(): string
	{
		return json_encode($this->toArray());
	}
}