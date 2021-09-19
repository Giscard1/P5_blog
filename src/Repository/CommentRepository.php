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
        $query = "SELECT * FROM post";

        return $this->database->request($query)->fetch();
    }



    public function createNewPost($dataSubmitted) {

        $title = $dataSubmitted['title'];
        $chapo = $dataSubmitted['chapo'];
        $content = $dataSubmitted['content'];
        $author = "none";
        $updateDate = new \DateTime();

        $query = "INSERT INTO post (title, chapo, content, author, updateDate) 
                    VALUES(:title, :chapo, :content, :author, :updateDate)";
        $this->database->request($query, [':title' => $title,
            ':chapo' => $chapo,
            ':content' => $content,
            ':author' => $author,
            ':updateDate' => $updateDate
        ]);

    }
}
