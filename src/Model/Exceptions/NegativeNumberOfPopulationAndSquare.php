<?php

namespace App\Model\Exceptions;

use Throwable;
use Exception;

// NegativeNumberOfPopulationAndSquare- исключение ошибки отрицательной площади и населении
class NegativeNumberOfPopulationAndSquare extends Exception {

    // переопределение конструктора исключения
    public function __construct(string $NegativeNumberCode,  $message, Throwable $previous = null) {
   $exceptionMessage = "population and square '". $NegativeNumberCode ."can not be negative";
// вызов конструктора базового класса исключения
parent::__construct(
    message: $exceptionMessage, 
    code: 4,
    previous: $previous,
        );
    }
}