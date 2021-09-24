<?php


namespace App\Repository;



use App\Models\User;

class UserRepository extends AbstractRepository
{

    protected function getTableName()
    {
        return 'user.';
    }

    public function findByEmail($email)
    {
        $query = "SELECT * FROM user WHERE email = :email";
        return $this->database->request($query, [':email' => $email])->fetch();
    }

    public function findAll()
    {
        $query = "SELECT * FROM user";
        return $this->database->request($query)->fetchAll();
    }

    public function deleteUser(int $id){
        $query = "DELETE FROM user WHERE id = :id";
        return $this->database->request($query, [':id' => $id]);
    }

    public function validUser(int $id){
        $query = "UPDATE user SET valid = true WHERE id = :id";
        return $this->database->request($query, [':id' => $id]);
    }

    public function adminUser(int $id){
        $query = "UPDATE user SET admin = true WHERE id = :id";
        return $this->database->request($query, [':id' => $id]);
    }




    public function registerNewUser($dataSubmitted){

        $firstname = $dataSubmitted['firstname'];
        $lastname = $dataSubmitted['lastname'];
        $email = $dataSubmitted['email'];
        $password = $dataSubmitted['password'];
        $valid = 0;
        $admin = 0;

        $query = "INSERT INTO user (last_name, first_name, email, password, valid, admin) 
                    VALUES(:last_name, :first_name, :email, :password, :valid, :admin) ";

        $statement = $this->database->prepare($query);

        $statement->execute(['last_name' => $lastname,
            'first_name' => $firstname,
            'email' => $email,
            'password' => $password,
            'valid' => $valid,
            'admin' => $admin]);
    }

}
