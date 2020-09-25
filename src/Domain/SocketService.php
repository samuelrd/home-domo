<?php

namespace App\Domain;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Socket;

final class SocketService
{
    protected $em;
    protected $socketRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->socketRepository = $em->getRepository(Socket::class);
    }

    public function findAll()
    {
        return $this->socketRepository->findAll();
    }

    public function find($id)
    {
        return $this->socketRepository->find($id);
    }

}