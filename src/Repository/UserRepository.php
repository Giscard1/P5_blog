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

    public function turnToAdmin($id){
        $user = new User();
        $this->$user->setAdmin(1);
    }

    public function deleteUser($userId){

          $query = "DELETE FROM user WHERE id = :userId";

          return $this->database->request($query, [':userId' => $userId])->fetch();

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
