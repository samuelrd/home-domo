<?php

namespace App\Domain;

use Doctrine\ORM\Mapping as ORM;

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

}