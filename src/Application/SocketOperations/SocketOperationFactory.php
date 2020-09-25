<?php

namespace App\Application\SocketOperations;

use App\Domain\Socket;
use App\Application\SocketOperations\Exceptions\SocketOperationNotFoundException;
use App\Utility\Configuration;

class SocketOperationFactory
{
    const OPERATION_ON = 'on';
    const OPERATION_OFF = 'off';
    const OPERATION_PAIR = 'pair';

    const OPERATIONS = [
        self::OPERATION_ON,
        self::OPERATION_OFF,
        self::OPERATION_PAIR
    ];

    protected $scriptPath;

    public function __construct(Configuration $config)
    {
        $this->scriptPath = $config->get('scripts_path');
    }

    public function createSocketOperation(string $operation, Socket $socket)
    {
        if ($operation == self::OPERATION_ON)
        {
            return new SocketPowerOn($socket, $this->scriptPath);
        }
        else if ($operation == self::OPERATION_OFF)
        {
            return new SocketPowerOff($socket, $this->scriptPath);
        }
        else if ($operation == self::OPERATION_PAIR)
        {
            return new SocketPair($socket, $this->scriptPath);
        }
        
        throw new SocketOperationNotFoundException();
    }
}