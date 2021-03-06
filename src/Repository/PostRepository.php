<?php


namespace App\Repository;


class PostRepository extends AbstractRepository

{

    protected function getTableName()
    {
        return 'post.';
    }

    public function findAll()
    {
        $query = "SELECT p.*, u.last_name AS user_last_name
        FROM post AS p
        INNER JOIN user AS u
        ON p.user_id = u.id";
        return $this->database->request($query)->fetchAll();
    }

    public function findById($id)
    {
        $query = "SELECT * FROM post WHERE id = :id";
        return $this->database->request($query, [':id' => $id])->fetch();
    }

    public function findOneById($id)
    {
        $query = "SELECT p.id AS post_id, p.title AS post_title, p.chapo AS post_chapo, p.content AS post_content, p.updateDate AS post_updateDate, u.last_name AS user_last_name 
        FROM post AS p
        INNER JOIN user AS u 
        ON p.user_id = u.id
        WHERE p.id = :id";
        return $this->database->request($query, [':id' => $id])->fetch();
    }

    public function deletePostAdmin(int $id){
        $query = "DELETE FROM post WHERE id = :id";
        return $this->database->request($query, [':id' => $id]);
    }

    public function update($dataSubmitted, int $idUser, int $id){

        $title = $dataSubmitted['title'];
        $chapo = $dataSubmitted['chapo'];
        $content = $dataSubmitted['content'];
        $updateDate = new \DateTime();

        $query = "UPDATE post SET title = :title, chapo = :chapo, content = :content,
                     user_id = :user_id, updateDate = :updateDate
                    WHERE id = :idpost";

        $this->database->request($query,
            [':title' => $title,
                ':chapo' => $chapo,
                ':content' => $content,
                ':user_id' => $idUser,
                ':updateDate' => $updateDate,
                ':idpost' => $id,
            ]);
    }

    public function createNewPost($dataSubmitted,$id_User) {
        $title = $dataSubmitted['title'];
        $chapo = $dataSubmitted['chapo'];
        $content = $dataSubmitted['content'];
        $updateDate = new \DateTime();

        $query = "INSERT INTO post (title, chapo, content, user_id, updateDate) 
                    VALUES(:title, :chapo, :content, :user_id, :updateDate)";
        $this->database->request($query,
            [':title' => $title,
            ':chapo' => $chapo,
            ':content' => $content,
            ':user_id' => $id_User,
            ':updateDate' => $updateDate
        ]);
    }
}
