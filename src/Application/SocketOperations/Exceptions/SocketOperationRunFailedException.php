<?php

namespace App\Application\SocketOperations\Exceptions;

class SocketOperationRunFailedException extends \Exception
{
	protected $debugInfo;

	public function __construct($debugInfo = '')
	{
		parent::__construct('Socket operation run failed.');
		$this->debugInfo = $debugInfo;
	}

	public function getDebugInfo()
	{
		return $this->debugInfo;
	}

	public function setDebugInfo($debugInfo)
	{
		$this->debugInfo = $debugInfo;

		return $this;
	}
}
