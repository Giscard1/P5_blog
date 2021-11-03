<?php


namespace App\Repository;


use App\Application\Database\PDODatabase;

abstract class AbstractRepository
{
    protected PDODatabase $database;

    public function __construct()
    {
        try{
            $this->database = new PDODatabase(
                'mysql:host=127.0.0.1:3306; dbname=P5; charset=utf8',
                'root',
                'Samuel@"1992"'

            );
        }catch (\Exception $e){
           var_dump($e);
        }
    }
    abstract protected function getTableName();
}
