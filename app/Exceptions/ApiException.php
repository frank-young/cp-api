<?php
namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    function __construct($msg='')
    {
        parent::__construct($msg);
    }
}
