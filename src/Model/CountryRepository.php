<?php
 
 namespace App\Model;

 interface  CountryRepository {

    // selectAll - получение всех стран
    public function selectAll(): array;

// selectByCode - получить страну по коду
    public function selectByCode(string $code):?Country;

    // save - сохранение страны в БД
    function save(Country $country): void;

    //delete-удаление страны из БД
    function delete(string $code) : void;
    //update-обновление страны
    function update(string $code, Country $country) : void;
 }