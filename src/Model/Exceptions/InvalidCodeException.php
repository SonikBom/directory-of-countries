<?php

namespace App\Model\Exceptions;

use Throwable;
use Exception;

// InvalidCodeException - исключение невалидного кода аэропорта
class InvalidCodeException extends Exception {

    // переопределение конструктора исключения
    public function __construct($invalidCode, $message, Throwable $previous = null) {
        $exceptionMessage = "country code '". $invalidCode ."' is invalid: ".$message;
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: 1,
            previous: $previous,
        );

    }
}
