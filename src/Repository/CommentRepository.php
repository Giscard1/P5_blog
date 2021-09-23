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
        $query = "SELECT c.content AS comment_content FROM comment AS c INNER JOIN post AS p ON c.post_id = p.id WHERE c.is_valid = 1 ANDWHERE ";

        return $this->database->request($query)->fetchAll();
    }

    public function findByArticleIdValid($id)
    {
        $query = "SELECT * FROM comment WHERE post_id = :id AND is_valid = 1";


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



        $query = "INSERT INTO comment (content, is_valid, post_id, auther) 
                    VALUES(:content, :is_valid, :post_id, :auther) ";


        $statement = $this->database->prepare($query);

        $statement->execute([':content' => $content,
            ':is_valid' => $isValid,
            ':post_id' => $idPost,
            ':auther' => $idUser,
           ]);
    }



}
