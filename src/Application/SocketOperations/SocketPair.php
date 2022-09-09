<?php

namespace App\Application\SocketOperations;

class SocketPair extends SocketOperation
{
	protected $name = 'pair';

	public function getCommandString()
	{
		return "{$this->program} {$this->scriptPath}/energenie_pair.py {$this->socket->getId()}";
	}
}