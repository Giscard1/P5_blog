<?php


namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface;


class StudentController
{

    public function edit(ServerRequestInterface $request, array $parameters)
    {
        var_dump($request);
        var_dump($parameters);

    }

}
