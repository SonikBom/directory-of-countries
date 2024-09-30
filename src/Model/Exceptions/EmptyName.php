<?php

namespace App\Model\Exceptions;

use Throwable;
use Exception;

class EmptyName extends Exception{
    public function __construct($emptyname, $message, Throwable $previous = null) {
        $exceptionMessage = "shortname and fullname'". $emptyname ."could't empty";
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: 5,
            previous: $previous,
        );

    }
}