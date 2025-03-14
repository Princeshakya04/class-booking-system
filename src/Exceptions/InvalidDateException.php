<?php

namespace App\Exceptions;

class InvalidDateException extends \Exception
{
    protected $message = 'End date must be greater than start date.';
}