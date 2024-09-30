<?php

namespace App\Model;
use App\Model\Exceptions\CountryNotFoundException;
use App\Model\Exceptions\InvalidCodeException;
use App\Model\Exceptions\DuplicatedCodeException;
use App\Model\Exceptions\NegativeNumberOfPopulationAndSquare;
use App\Model\Exceptions\EmptyName;
use App\Rdb\CountryStorage;

use Exception;
class CountryScenarios {

    public function __construct(
        private readonly CountryRepository $storage
    )
       
    {
    
    }
    //Получение списка стран
     // getAll - получение всех стран
    // вход: -
    // выход: список объектов Country
    public function getAll(): array {
        return $this->storage->selectAll();
    }

    //Получение страны по коду
    // get - получение страны по коду
    // вход: двухбуквенный код страны
    // выход: объект извлеченной страны
    // исключения: InvalidCodeException, CountryNotFoundException

    public function get(string $code) : Country {
        // выполнить проверку корректности кода
        if (!$this->validateCode1($code) && !$this->validateCode2($code) && !$this->validateCode3($code)) {
            throw new InvalidCodeException($code, 'validation failed');
        }
       
        $country = $this->storage->selectByCode($code);
        if ($country=== null) {
            // если страна не найдена - выбросить ошибку
            throw new CountryNotFoundException($code);
        }
       
        //  вернуть полученную страну
        return $country;
    }

    //Сохранение новой страны
    //store-сохранение страны
    //вход: обьект страны
    //выход: -
    //исключения: InvalidCodeException, DuplicatedCodeException, NegativeNumberOfPopulationAndSquare
    public function store(Country $country):void{
         // выполнить проверку корректности кода
         if (!$this->validateCode1(code: $country->isoAlpha2) ) {
            throw new InvalidCodeException(
                invalidCode: $country->isoAlpha2,
                message: 'validation failed',
            );
        }
        else if (!$this->validateCode2(code: $country->isoAlpha3) ){
            throw new InvalidCodeException(
                invalidCode: $country->isoAlpha3,
                message: 'validation failed',
            );
        }
        else if (!$this->validateCode3(code: $country->isoNumeric) ){
            throw new InvalidCodeException(
                invalidCode: $country->isoNumeric,
                message: 'validation failed',
            );
        }
        else if ($country->population<0 && $country->square<0)
        {
            throw new NegativeNumberOfPopulationAndSquare(
                NegativeNumberCode: $country->population,
                message: 'can not be negative',
            );
        }
        else if (empty($country->shortName) && empty($country->fullName))
        {
            throw new EmptyName(
                emptyname: $country->shortName,
                message: 'can not be empty',
            );
        }
        
        // выполнить проверку уникальности кода
        $sameCodeCountry = $this->storage->selectByCode(code: $country->isoAlpha2);
        $sameCodeCountry1 = $this->storage->selectByCode(code: $country->isoAlpha3);
        $sameCodeCountry2 = $this->storage->selectByCode(code: $country->isoNumeric);
      
        if ($sameCodeCountry != null) {
            throw new DuplicatedCodeException(duplicatedCode: $sameCodeCountry->isoAlpha2);
        }
        else if ($sameCodeCountry1 != null) {
            throw new DuplicatedCodeException(duplicatedCode: $sameCodeCountry1->isoAlpha3);
        }
        else if ($sameCodeCountry2 != null) {
            throw new DuplicatedCodeException(duplicatedCode: $sameCodeCountry2->isoNumeric);
        }
        
        // если все ок, то сохранить страну в БД
        $this->storage->save(country: $country);
       
        
    }

    //Редактирование страны
    // edit - редактирование страны по коду
    // вход: код двухбуквенной страны
    // выход: -
    // исключения: InvalidCodeException, CountryNotFoundException, DuplicatedCodeException
    public function edit(string $code, Country $country): void  {
       // выполнить проверку корректности кода (до и после редактирования)
       if (!$this->validateCode1(code: $code)) {
        throw new InvalidCodeException(invalidCode: $code, message: 'validation failed');
    }
    // выполнить проверку корректности отредактированного кода
    if (!$this->validateCode1(code: $country->isoAlpha2)) {
        throw new InvalidCodeException(invalidCode: $country->isoAlpha2, message: 'validation failed');
    }
    // выполнить проверку наличия страны для редактирования
    $updatedCountry = $this->storage->selectByCode(code: $code);
    if ($updatedCountry=== null) {
        // если страна не найдена - выбросить ошибку
        throw new CountryNotFoundException(notFoundCode: $code);
    }
    // проверить отсутствие дублирования кода при его обновлении
    if ($code != $country->isoAlpha2) {
        $duplicatedCodeCountry = $this->storage->selectByCode(code: $country->isoAlpha2);
        if ($duplicatedCodeCountry != null) {
            throw new DuplicatedCodeException(duplicatedCode: $country->isoAlpha2);
        }
    }
  
    // если все ок, то сделать update
    $this->storage->update(code: $code, country: $country);
    }

    //Удаление страны
    // delete - удаление страны по коду
    // вход: двухбуквенный код удаляемой страны
    // выход: -
    // исключения: InvalidCodeException, CountryNotFoundException
    public function delete(string $code):void{
        // выполнить проверку корректности кода
        if (!$this->validateCode1(code: $code) && !$this->validateCode2($code) && !$this->validateCode3($code) ) {
            throw new InvalidCodeException(invalidCode: $code, message: 'validation failed');
        }
        // если валидация пройдена, то получить аэропорт по данному коду
        $country = $this->storage->selectByCode(code: $code);
        if ($country === null) {
            // если страна не найдена - выбросить ошибку
            throw new CountryNotFoundException(notFoundCode: $code);
        }
        $this->storage->delete(code: $code);
    }

    
    // validateCode - проверка корректности кода страны
    // вход: двухбуквенный код страны
    // выход: true если строка корректная, иначе false
    private function validateCode1(string $code): bool {
        // ^[A-Z]{3}$
        return preg_match(pattern: '/^[A-Z]{2}$/', subject: $code);
    }
    private function validateCode2(string $code): bool {
        // ^[A-Z]{3}$
        return preg_match(pattern: '/^[A-Z]{3}$/', subject: $code);
    }
    private function validateCode3(string $code): bool {
        // ^[A-Z]{3}$
        return preg_match(pattern: '/^[0-9]{3}$/', subject: $code);
    }
    
   
}