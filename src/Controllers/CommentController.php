<?php


namespace App\Controllers;


use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class CommentController extends AbstractController
{

    protected CommentRepository $commentRepository;

    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
    }


        public function newComment(ServerRequestInterface $request, array $params)
        {

            $response =  new Response(
                200,
                [],
                $this->renderHtml('Post/TheOne/post.html.twig'
                )
            );

            return $response->getBody();

            /*
             * $response =  new Response(
                200,
                [],
                $this->renderHtml('comment/comment.html.twig',
                    ['errors' => $errors]
                )
            );

            return $response->getBody();
             */
        }







}
