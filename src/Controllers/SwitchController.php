<?php

namespace App\Controllers;

use App\Application\SocketOperations\SocketOperationFactory;
use App\Domain\Socket;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SwitchController
{
    protected $em;
    protected $operationFactory;

    public function __construct(EntityManagerInterface $em, SocketOperationFactory $operationFactory) {

        $this->em = $em;
        $this->operationFactory = $operationFactory;
    }

    public function switch(Request $request, Response $response, $args){

        $data = $request->getParsedBody();
        $socket = $this->em->getRepository(Socket::class)->find($data["socket"]);
        $operation = $this->operationFactory->createSocketOperation($args['power'], $socket);
        
        try
        {
            $operationReturn = $operation->run();
        }
        catch (\Exception $ex)
        {
            $errorResponse = ['message' => $ex->getMessage()];
            $response->getBody()->write(json_encode($errorResponse));
            return $response
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
        }

        $returnData = ['message' => "Socket {$socket->getName()} is {$args['power']}", 'result' => implode(' ', $operationReturn)];
        $response->getBody()->write(json_encode($returnData));

        return $response
                ->withHeader('Content-Type', 'application/json');
    }
}
