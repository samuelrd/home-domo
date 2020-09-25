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
	 * @var string
	 *
	 * @ORM\Column(name="description", type="string", length=256, nullable=false)
	 */
	protected $description;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="command", type="string", length=256, nullable=false)
	 */
	protected $command;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="time", type="string", length=4, nullable=false)
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
	 * Get the value of description
	 *
	 * @return string
	 */ 
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set the value of description
	 *
	 * @param string $description
	 *
	 * @return self
	 */ 
	public function setDescription(string $description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * Get the value of command
	 *
	 * @return string
	 */ 
	public function getCommand()
	{
		return $this->command;
	}

	/**
	 * Set the value of command
	 *
	 * @param string $command
	 *
	 * @return self
	 */ 
	public function setCommand(string $command)
	{
		$this->command = $command;

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

}