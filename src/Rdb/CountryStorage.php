<?php 

namespace App\Rdb;

use App\Model\CountryRepository;
use mysqli;
use RuntimeException;
use Exception;

use App\Model\Country;
use App\Rdb\SqlHelper;

class CountryStorage  implements CountryRepository{
   
    public function __construct(
        private readonly SqlHelper $sqlHelper
    )
    {}
    public function selectAll(): array
    {
        try {
            // создать подключение к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить строку запроса
            $queryStr = '
                SELECT shortName, fullName, isoAlpha2, isoAlpha3, isoNumeric, population, square
                FROM country_t';
            // выполнить запрос
            $rows = $connection->query(query: $queryStr);
            // считать результаты запроса в цикле 
            $countries = [];
            while ($row = $rows->fetch_array()) {
                // каждая строка считается в тип массива
                $country = new Country(
                    shortName: $row[0],
                    fullName: $row[1],
                    isoAlpha2: $row[2],
                    isoAlpha3: $row[3],
                    isoNumeric: $row[4],
                    population: intval(value: $row[5]),
                    square: intval(value: $row[6]),
                );
                array_push($countries, $country);
            }
            // вернуть результат
            return $countries;
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }
    public function selectByCode(string $code):?Country
    {
        try {


            // создать подключение к БД
            $connection = $this->sqlHelper->openDbConnection();

            if (strlen($code)===2)
            {
                $queryStr = 'SELECT  shortName, fullName, isoAlpha2, isoAlpha3, isoNumeric, population, square
                FROM country_t
                WHERE isoAlpha2 = ?';
            }
            else if (strlen($code)===3 && ctype_alpha($code))
            {
                $queryStr = 'SELECT  shortName, fullName, isoAlpha2, isoAlpha3, isoNumeric, population, square
                FROM country_t
                WHERE isoAlpha3 = ?';
            }

           else  if (strlen($code)===3)
            {
                $queryStr = 'SELECT  shortName, fullName, isoAlpha2, isoAlpha3, isoNumeric, population, square
                FROM country_t
                WHERE isoNumeric = ?';
            }
            
        
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param('s', $code);
            // выполнить запрос
            $query->execute();
            $rows = $query->get_result();
            // считать результаты запроса в цикле 
            while ($row = $rows->fetch_array()) {
                // если есть результат - вернем его
                return new Country(
                    shortName: $row[0],
                    fullName: $row[1],
                    isoAlpha2: $row[2],
                    isoAlpha3: $row[3],
                    isoNumeric: $row[4],
                    population: intval(value: $row[5]),
                    square: intval(value: $row[6]),
                );
            }
            // иначе вернуть null
            return null;
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    // save - сохранение страны в БД
    function save(Country $country): void
    {
        try{

        
         // создать подключеник к БД
         $connection = $this->sqlHelper->openDbConnection();
         // подготовить запрос INSERT
         $queryStr = 'INSERT INTO country_t (shortName, fullName, isoAlpha2, isoAlpha3, isoNumeric, population, square)
             VALUES (?, ?, ?, ?, ?, ?, ?);';
         // подготовить запрос
         $query = $connection->prepare(query: $queryStr);
         $query->bind_param(
            'sssssii',
             $country->shortName, 
             $country->fullName,
              $country->isoAlpha2, 
              $country->isoAlpha3, 
              $country->isoNumeric,
              $country->population,
              $country->square,
         );
         // выполнить запрос
         if (!$query->execute()) {
             throw new Exception(message: 'insert execute failed');
         }
     } finally {
         // в конце в любом случае закрыть соединение с БД если оно было открыто
         if (isset($connection)) {
             $connection->close();
         }
     }
    }


    //delete-удаление страны из БД
    function delete(string $code) : void
    {
        try {
            // создать подключеник к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить запрос INSERT
            if (strlen($code)===2)
            {
            $queryStr = 'DELETE FROM country_t WHERE  isoAlpha2 = ?';
            }
            else if (strlen($code)===3 && ctype_alpha($code))
            { 
                $queryStr = 'DELETE FROM country_t WHERE  isoAlpha3 = ?';
            }

           else  if (strlen($code)===3)
            {
                $queryStr = 'DELETE FROM country_t WHERE  isoNumeric = ?';
            }
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param('s', $code);
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'delete execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }
    //update-обновление страны
    function update(string $code, Country $country) : void
    {
        try {
            // создать подключеник к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить запрос INSERT

           
                $queryStr = 'UPDATE  country_t SET 
                shortName = ?, 
                fullName = ?, 
                isoAlpha2 = ?, 
                isoAlpha3 = ?, 
                isoNumeric = ?, 
                population = ?, 
                square = ?
                WHERE isoAlpha2 = ?';
           
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param(
              'sssssiis',
             $country->shortName, 
             $country->fullName,
              $country->isoAlpha2, 
              $country->isoAlpha3, 
              $country->isoNumeric,
              $country->population,
              $country->square,
              $code,
            );
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'update execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }
}