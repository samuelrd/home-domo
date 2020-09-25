<?php

namespace App\Controllers;

use App\Domain\Socket;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class HomeController
{
    protected $em;
    protected $view;

    public function __construct(EntityManagerInterface $em, Twig $view) {
        $this->em = $em;
        $this->view = $view;
    }

    public function home(Request $request, Response $response, $args){
        $socketRepository = $this->em->getRepository(Socket::class);
        $sockets = $socketRepository->findAll();
        return $this->view->render($response, 'index.twig', ["sockets" => $sockets]);
    }
}
