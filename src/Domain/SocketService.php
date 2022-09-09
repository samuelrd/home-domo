<?php

namespace App\Domain;

use Doctrine\ORM\EntityManagerInterface;

final class SocketService
{
	private $em;
	private $socketRepository;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
		$this->socketRepository = $this->em->getRepository(Socket::class);
	}

	public function findAll()
	{
		return $this->socketRepository->findAll();
	}

	public function find(int $id): ?Socket
	{
		return $this->socketRepository->find($id);
	}
}