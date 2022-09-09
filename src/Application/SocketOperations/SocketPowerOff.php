<?php

namespace App\Application\SocketOperations;

class SocketPowerOff extends SocketOperation
{
	public $name = 'off';

	public function getCommandString()
	{
		return "{$this->program} {$this->scriptPath}/energenie_switch.py {$this->socket->getId()} off";
	}
}