<?php

namespace App\Application\SocketOperations;

class SocketPowerOn extends SocketOperation
{
	protected $name = 'on';

	public function getCommandString()
	{
		return "{$this->program} {$this->scriptPath}/energenie_switch.py {$this->socket->getId()} on";
	}
}
