<?php

namespace App\Application\SocketOperations\Exceptions;

class SocketOperationNotFoundException extends \Exception
{
    public $message = "Socket operation not found.";
}
