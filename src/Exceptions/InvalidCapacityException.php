<?php

namespace App\Exceptions;

class InvalidCapacityException extends \Exception
{
    protected $message = 'Capacity must be a positive integer.';
}