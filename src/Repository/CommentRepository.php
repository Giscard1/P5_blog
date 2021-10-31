<?php


namespace App\Repository;


class CommentRepository extends AbstractRepository

{
    protected function getTableName()
    {
        return 'comment.';
    }

    public function findAll()
    {
        $query = "SELECT * FROM comment";
        return $this->database->request($query)->fetchAll();
    }

    public function findAllValidComments()
    {
        $query = "SELECT * FROM comment WHERE comment.is_valid = 1";
        return $this->database->request($query)->fetchAll();
    }

//        $query = "SELECT c.content AS comment_content, c.date_validation AS comment_date_validation, u.last_name AS user_last_name

    public function findByArticleIdValid($id)
    {
        $query = "SELECT c.*, u.last_name AS user_last_name
        FROM comment AS c
        INNER JOIN user AS u
        ON c.auther = u.id
        WHERE c.is_valid = 1
        AND c.post_id = :id";
        return $this->database->request($query, [':id' => $id])->fetchAll();
    }

    public function findById($id)
    {
        $query = "SELECT * FROM comment WHERE id = :id";
        return $this->database->request($query, [':id' => $id])->fetch();
    }

    public function delete(int $id){
        $query = "DELETE FROM comment WHERE id = :id";
        return $this->database->request($query, [':id' => $id]);
    }

    public function valid(int $id){
        $query = "UPDATE comment SET is_valid = true WHERE id = :id";
        return $this->database->request($query, [':id' => $id]);
    }

    //function doit prendre comme parametre, id de l'utilisateur connecter et l'id du post
    public function submitComment($dataSubmitted,$idPost, $idUser){

        $content = $dataSubmitted['comment'];
        $isValid = 0;
        $dateValidation = new \DateTime();

        $query = "INSERT INTO comment (content, is_valid, post_id, auther, date_validation) 
                    VALUES(:content, :is_valid, :post_id, :auther, :date_validation)";

        $this->database->request($query,
            [':content' => $content,
            ':is_valid' => $isValid,
            ':post_id' => $idPost,
            ':auther' => $idUser,
            ':date_validation' => $dateValidation
            ]);
    }
}
