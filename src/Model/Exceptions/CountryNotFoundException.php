<?php

namespace App\Model\Exceptions;

use Throwable;
use Exception;

class CountryNotFoundException extends Exception{
    public function __construct($notFoundCode, Throwable $previous = null) {
        $exceptionMessage = "country'". $notFoundCode ."' not found";
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: 2,
            previous: $previous,
        );

    }
}