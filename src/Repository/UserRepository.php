<?php


namespace App\Repository;


use App\Application\Database\PDODatabase;

class UserRepository
{
    protected PDODatabase $database;

    public function __construct()
    {
        try{
            $this->database = new PDODatabase(
                'mysql:host=127.0.0.1:3306; dbname=P5; charset=utf8',
                'giscard',
                'Samuel@"1992"'

            );
        }catch (\Exception $e){
            var_dump($e);
        }
    }

    public function findAllUsers()
    {
        $query = "SELECT * FROM user";
        $statement = $this->database->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }
}
