<?php

namespace App\Application\SocketOperations;
use App\Domain\Socket;

class SocketPowerOff extends SocketOperation
{
    public function getCommandString()
    { 
        return "{$this->program} {$this->scriptPath}/energenie_switch.py {$this->socket->getId()} off";
    }
}