<?php

namespace App\Application\SocketOperations;

use App\Application\SocketOperations\Exceptions\SocketOperationRunFailedException;
use App\Domain\Socket;

abstract class SocketOperation
{
    protected $program = '/usr/bin/python3';
    protected $scriptPath;
    protected $socket;

    public function __construct(Socket $socket, $scriptPath = '/home/pi')
    {
        $this->scriptPath = $scriptPath;
        $this->socket = $socket;
    }

    abstract public function getCommandString();

    public function run()
    {
        $output = [];
        $return = null;

        exec(escapeshellcmd($this->getCommandString()), $output, $return);

        if ($return !== 0)
        {
            throw new SocketOperationRunFailedException(implode(" ", $output));
        }

        return $output;
    }
}
