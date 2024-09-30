<?php 

namespace App\Rdb;

use mysqli;
use RuntimeException;
use Exception;

use App\Model\Country;
use App\Model\CountryRepository;
use App\Rdb\CountryStorage;

class SqlHelper {

    public function __construct() {
        // при создании проверить доступность БД
        $this->pingDb();
    }

   
     // pingDb - проверить доступность БД
     public function pingDb() : void {
        // открыть и закрыть соединение с БД
        $connection = $this->openDbConnection();
        $connection->close();
    }
    
    public function openDbConnection(): mysqli  {
        // зададим параметры подключения к БД 
        // TODO: вынести параметры в .env-файл
        $host = 'localhost';
        $port = 3306;
        $user = 'root';
        $password = '';
        $database = 'country_db_pv225';
        // создать объект подключения через драйвер
        $connection = new mysqli(
            hostname: $host,
            port: $port, 
            username: $user, 
            password: $password, 
            database: $database, 
        );
        // открыть соединение с БД
        if ($connection->connect_errno) {
            throw new RuntimeException(message: "Failed to connect to MySQL: ".$connection->connect_error);
        }
        // если все ок - вернуть соединение с БД
        return $connection;
    }

}