<?php

namespace App\Application\SocketOperations;
use App\Domain\Socket;

class SocketPair extends SocketOperation
{
    public function getCommandString()
    { 
        return "{$this->program} {$this->scriptPath}/energenie_pair.py {$this->socket->getId()}";
    }

}