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
}
